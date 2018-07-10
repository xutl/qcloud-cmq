<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use Psr\Http\Message\StreamInterface;

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
     * @param string $statusCode
     * @param StreamInterface $content
     * @return mixed
     */
    abstract public function parseResponse($statusCode, StreamInterface $content);

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
