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
     * Http状态码
     * @var int
     */
    protected $statusCode;

    /**
     * @var boolean
     */
    protected $succeed;

    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed
     */
    abstract public function unwrapResponse(ResponseInterface $response);

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
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
