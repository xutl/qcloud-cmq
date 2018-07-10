<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use Psr\Http\Message\ResponseInterface;
use XuTL\QCloud\Cmq\Exception\CmqException;
use XuTL\QCloud\Cmq\Exception\CMQServerException;
use XuTL\QCloud\Cmq\Exception\CMQServerNetworkException;

/**
 * Class BaseResponse
 * @package XuTL\QCloud\Cmq\Http
 */
class BaseResponse
{
    /**
     * @var boolean
     */
    protected $succeed;

    protected $code;

    protected $message;

    protected $_content = [];

    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() != 200) {
            throw new CMQServerNetworkException($response->getStatusCode(), $response->getHeaders(), $response->getBody()->getContents());
        }
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if ($content['code'] != 0) {
            $this->succeed = false;
            throw new CMQServerException($content['message'], $content['requestId'] ?? '', $content['code'], $content);
        }
        $this->succeed = true;
        foreach ($content as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            } else {
                $this->_content[$name] = $value;
            }
        }
    }

    /**
     * @return boolean
     */
    public function isSucceed()
    {
        return $this->succeed;
    }

    public function getContent()
    {
        return $this->_content;
    }
}
