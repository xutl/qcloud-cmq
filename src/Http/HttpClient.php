<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use RuntimeException;
use XuTL\QCloud\Cmq\AsyncCallback;
use XuTL\QCloud\Cmq\Config;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\TransferException;

/**
 * Class HttpClient
 * @package XuTL\Alipay
 */
class HttpClient
{
    const SIGNATURE_METHOD_RSA = 'RSA';
    const SIGNATURE_METHOD_RSA2 = 'RSA2';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string 签名方法
     */
    private $signType = self::SIGNATURE_METHOD_RSA2;
    private $requestTimeout;
    private $connectTimeout;

    /**
     * HttpClient constructor.
     * @param string $endPoint
     * @param string $appId
     * @param string $privateKey
     * @param string $publicKey
     * @param Config|null $config
     */
    public function __construct($endPoint, $appId, $privateKey, $publicKey, Config $config = null)
    {
        if ($config == null) {
            $config = new Config;
        }
        $this->appId = $appId;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $endPoint,
            'defaults' => [
                'proxy' => $config->getProxy(),
                'expect' => $config->getExpectContinue()
            ]
        ]);
        $this->requestTimeout = $config->getRequestTimeout();
        $this->connectTimeout = $config->getConnectTimeout();
        $this->initPrivateKey();
        $this->initPublicKey();
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * 初始化私钥
     * @throws RuntimeException
     */
    protected function initPrivateKey()
    {
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($this->privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        $this->privateKey = openssl_pkey_get_private($privateKey);
        if ($this->privateKey === false) {
            throw new RuntimeException(openssl_error_string());
        }
    }

    /**
     * 初始化公钥
     * @throws RuntimeException
     */
    protected function initPublicKey()
    {
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($this->publicKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        $this->publicKey = openssl_pkey_get_public($publicKey);
        if ($this->publicKey === false) {
            throw new RuntimeException(openssl_error_string());
        }
    }

    /**
     * 数据签名处理
     * @param array $toBeSigned
     * @param bool $verify
     * @return bool|string
     */
    public function getSignContent(array $toBeSigned, $verify = false)
    {
        $stringToBeSigned = '';
        foreach ($toBeSigned as $k => $v) {
            if ($verify && $k != 'sign' && $k != 'sign_type') {
                $stringToBeSigned .= $k . '=' . $v . '&';
            }
            if (!$verify && $v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $stringToBeSigned .= $k . '=' . $v . '&';
            }
        }
        $stringToBeSigned = substr($stringToBeSigned, 0, -1);
        unset($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 验证支付宝返回值
     * @param array $data 返回数据
     * @param null $sign 数据签名
     * @param bool $sync
     * @return bool
     */
    public function verify($data, $sign, $sync = false)
    {
        $toVerify = $sync ? json_encode($data) : $this->getSignContent($data, true);
        return openssl_verify($toVerify, base64_decode($sign), $this->publicKey, OPENSSL_ALGO_SHA256) === 1 ? true : false;
    }

    /**
     * 编译请求参数
     * @param BaseRequest $request
     * @return array
     */
    public function buildRequestBody(BaseRequest &$request)
    {
        $params = [];
        $params['app_id'] = $this->appId;
        $params['method'] = $request->getApiMethodName();
        $params['format'] = 'JSON';
        $params['charset'] = 'utf-8';
        $params['sign_type'] = $this->signType;
        $params['timestamp'] = date('Y-m-d H:i:s');
        $params['version'] = $request->getApiVersion();
        $params['notify_url'] = $request->getNotifyUrl();
        $params['_input_charset'] = 'utf-8';
        $params['biz_content'] = \GuzzleHttp\json_encode($request->getBizContents());
        ksort($params);
        //签名
        if ($this->signType == self::SIGNATURE_METHOD_RSA2) {
            $params['sign'] = openssl_sign($this->getSignContent($params), $sign, $this->privateKey, OPENSSL_ALGO_SHA256) ? base64_encode($sign) : null;
        } elseif ($this->signType == self::SIGNATURE_METHOD_RSA) {
            $params['sign'] = openssl_sign($this->getSignContent($params), $sign, $this->privateKey, OPENSSL_ALGO_SHA1) ? base64_encode($sign) : null;
        }
        return $params;
    }

    /**
     * 发送异步请求
     * @param BaseRequest $request
     * @param BaseResponse $response
     * @param AsyncCallback|NULL $callback
     * @return Promise
     */
    public function sendRequestAsync(BaseRequest $request, BaseResponse &$response, AsyncCallback $callback = NULL)
    {
        $promise = $this->sendRequestAsyncInternal($request, $response, $callback);
        return new Promise($promise, $response);
    }

    /**
     * 发送同步请求
     * @param BaseRequest $request
     * @param BaseResponse $response
     * @return BaseResponse
     */
    public function sendRequest(BaseRequest $request, BaseResponse &$response)
    {
        $promise = $this->sendRequestAsync($request, $response);
        return $promise->wait();
    }

    /**
     * 内部方法，发送异步请求
     * @param BaseRequest $request
     * @param BaseResponse $response
     * @param AsyncCallback|null $callback
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    private function sendRequestAsyncInternal(BaseRequest &$request, BaseResponse &$response, AsyncCallback $callback = null)
    {
        $options = ['exceptions' => false, 'http_errors' => false];
        $options['form_params'] = $this->buildRequestBody($request);
        $options['timeout'] = $this->requestTimeout;
        $options['connect_timeout'] = $this->connectTimeout;
        $response->setResponseNode(str_replace(".", "_", $request->getApiMethodName()) . '_response');
        $response->setHttpClient($this);
        $request = new Request('POST', '/gateway.do?_input_charset=utf-8');
        try {
            if ($callback != null) {
                return $this->client->sendAsync($request, $options)->then(
                    function (ResponseInterface $res) use (&$response, $callback) {
                        try {
                            $response->unwrapResponse($res);
                            $callback->onSucceed($response);
                        } catch (AlipayException $e) {
                            $callback->onFailed($e);
                        }
                    }
                );
            } else {
                return $this->client->sendAsync($request, $options);
            }
        } catch (TransferException $e) {
            $message = $e->getMessage();
            if ($e->hasResponse()) {
                $message = $e->getResponse()->getBody();
            }
            throw new RuntimeException($e->getCode(), $message, $e);
        }
    }
}
