<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseResponse
 * @package XuTL\QCloud\Cmq\Http
 */
abstract class BaseResponse
{
    /**
     * @var string
     */
    protected $responseNode;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var int
     */
    protected $code;

    protected $subCode;

    /**
     * @var string
     */
    protected $msg;

    protected $subMsg;

    /**
     * @var boolean
     */
    protected $succeed;

    /**
     * @param string $responseNode
     */
    public function setResponseNode($responseNode)
    {
        $this->responseNode = $responseNode;
    }

    /**
     * @return string
     */
    public function getResponseNode()
    {
        return $this->responseNode;
    }

    /**
     * Convert response contents to json.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        $contents = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $content = $contents[$this->getResponseNode()];
        $this->code = $content['code'];
        $this->msg = $content['msg'];
        if ($this->code == 10000) {
            if ($this->httpClient->verify($content, $contents['sign'], true) == true) {
                $this->succeed = true;
                $this->parseResponse($content);
            } else {
                throw new AlipayException(422, 'Signature verification error.');
            }
        } else {
            $this->parseErrorResponse($content);
        }
    }

    /**
     * @param array $content
     */
    public function parseErrorResponse(array $content)
    {
        $this->subCode = $content['sub_code'];
        $this->subMsg = $content['sub_msg'];
    }

    /**
     * @param $httpClient
     */
    public function setHttpClient(HttpClient &$httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array $content
     */
    abstract public function parseResponse(array $content);

    /**
     * @return boolean
     */
    public function isSucceed()
    {
        return $this->succeed;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return int
     */
    public function getSubCode()
    {
        return $this->subCode;
    }

    /**
     * @return string
     */
    public function getSubMsg()
    {
        return $this->subMsg;
    }
}
