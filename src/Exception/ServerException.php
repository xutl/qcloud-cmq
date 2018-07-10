<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class ServerException extends Exception
{
    /**
     * @var string
     */
    public $requestId;

    /**
     * ServerException constructor.
     * @param string $message
     * @param string $requestId
     * @param int $code
     * @param array $data
     */
    public function __construct($message, $requestId, $code = -1, $data = [])
    {
        parent::__construct($message, $code, $data);
        $this->requestId = $requestId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "ServerException  " . $this->getInfo() . ", RequestID:" . $this->requestId;
    }
}
