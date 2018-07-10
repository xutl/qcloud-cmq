<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use XuTL\QCloud\Cmq\AsyncCallback;
use XuTL\QCloud\Cmq\Config;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\TransferException;
use XuTL\QCloud\Cmq\Exception\CmqException;

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

    const SIGNATURE_METHOD_HMAC_SHA1 = 'HmacSHA1';
    const SIGNATURE_METHOD_HMAC_SHA256 = 'HmacSHA256';

    /**
     * @var string
     */
    public $endPoint;

    /**
     * @var string
     */
    public $secretId;

    /**
     * @var string
     */
    public $secretKey;

    /**
     * @var string 操作的地域
     */
    public $region;

    /**
     * @var string
     */
    public $requestPath = '/v2/index.php';
    public $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $signatureMethod = self::SIGNATURE_METHOD_HMAC_SHA256;

    private $requestTimeout;
    private $connectTimeout;


    /**
     * HttpClient constructor.
     * @param string $endPoint
     * @param string $secretId
     * @param string $secretKey
     * @param Config|null $config
     */
    public function __construct($endPoint, $secretId, $secretKey, Config $config = null)
    {
        if ($config == null) {
            $config = new Config;
        }
        $this->endPoint = $endPoint;
        $this->secretId = $secretId;
        $this->secretKey = $secretKey;
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $endPoint,
            'defaults' => [
                'proxy' => $config->getProxy(),
                'expect' => $config->getExpectContinue()
            ]
        ]);
        $this->requestTimeout = $config->getRequestTimeout();
        $this->connectTimeout = $config->getConnectTimeout();
    }

    /**
     * @return string
     */
    public function getSecretId()
    {
        return $this->secretId;
    }

    /**
     * _buildParamStr
     * 拼接参数
     * @param  array $requestParams 请求参数
     * @param  string $requestMethod 请求方法
     * @return string
     */
    protected function _buildParamStr($requestParams, $requestMethod = 'POST')
    {
        $paramStr = '';
        ksort($requestParams);
        $i = 0;
        foreach ($requestParams as $key => $value) {
            if ($key == 'Signature') {
                continue;
            }
            // 排除上传文件的参数
            if ($requestMethod == 'POST' && substr($value, 0, 1) == '@') {
                continue;
            }
            // 把 参数中的 _ 替换成 .
            if (strpos($key, '_')) {
                $key = str_replace('_', '.', $key);
            }

            if ($i == 0) {
                $paramStr .= '?';
            } else {
                $paramStr .= '&';
            }
            $paramStr .= $key . '=' . $value;
            ++$i;
        }

        return $paramStr;
    }

    /**
     * makeSignPlainText
     * 生成拼接签名源文字符串
     * @param  array $requestParams 请求参数
     * @param  string $requestMethod 请求方法
     * @param  string $requestHost 接口域名
     * @param  string $requestPath url路径
     * @return string
     */
    public function makeSignPlainText($requestParams, $requestMethod = 'POST', $requestHost = '', $requestPath = '/v2/index.php')
    {
        $url = $requestHost . $requestPath;
        // 取出所有的参数
        $paramStr = $this->_buildParamStr($requestParams, $requestMethod);
        $plainText = $requestMethod . $url . $paramStr;
        return $plainText;
    }

    /**
     * 编译请求参数
     * @param BaseRequest $request
     * @return array
     */
    public function buildRequestBody(BaseRequest &$request)
    {
        $params = $request->getParameters();
        $params['SecretId'] = $this->secretId;
        $params['Nonce'] = uniqid();
        $params['Timestamp'] = time();
        $params['SignatureMethod'] = $this->signatureMethod;
        $host = str_replace(['http://', 'https://'], '', $this->endPoint);
        $plainText = $this->makeSignPlainText($params, $this->requestMethod, $host, $this->requestPath);
        //签名
        if ($this->signatureMethod == self::SIGNATURE_METHOD_HMAC_SHA256) {
            $params['Signature'] = base64_encode(hash_hmac('sha256', $plainText, $this->secretKey, true));
        } elseif ($this->signatureMethod == self::SIGNATURE_METHOD_HMAC_SHA1) {
            $params['Signature'] = base64_encode(hash_hmac('sha1', $plainText, $this->secretKey, true));
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
    public function sendRequestAsync(BaseRequest $request, BaseResponse &$response, AsyncCallback $callback = null)
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
        $request = new Request($this->requestMethod, $this->requestPath);
        try {
            if ($callback != null) {
                return $this->client->sendAsync($request, $options)->then(
                    function (ResponseInterface $res) use (&$response, $callback) {
                        try {
                            $response->unwrapResponse($res);
                            $callback->onSucceed($response);
                        } catch (CMQException $e) {
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
            throw new CMQException($message, $e->getCode());
        }
    }
}
