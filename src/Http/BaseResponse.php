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
     * @var int
     */
    protected $code;
    /**
     * @var string
     */
    protected $msg;

    /**
     * @var boolean
     */
    protected $succeed;

    abstract public function parseResponse($statusCode, $content);

    /**
     * Convert response contents to json.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        $contents = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if ($contents['code'] == 0) {

        }

        print_r($contents);
        exit;
    }


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
}
