<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use Psr\Http\Message\ResponseInterface;
use XuTL\QCloud\Cmq\Exception\Exception;

/**
 * Class BaseResponse
 * @package XuTL\QCloud\Cmq\Http
 */
abstract class BaseResponse
{
    /**
     * @var boolean
     */
    protected $succeed;

    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if ($content['code'] == 0) {
            $this->succeed = true;
            $this->parseResponse($content);
        } else {
            $this->succeed = false;
            throw new Exception($content['message'], $content['code']);
        }
    }

    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed
     */
    abstract public function unwrapResponse1(ResponseInterface $response);

    /**
     * @return boolean
     */
    public function isSucceed()
    {
        return $this->succeed;
    }
}
