<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


use RuntimeException;

/**
 * Class Exception
 * @package XuTL\QCloud\Cmq\Exception
 */
class Exception extends RuntimeException
{
    private $errorCode;
    private $requestId;

    public function __construct($code, $message, $previousException = null, $errorCode = null, $requestId = null)
    {
        parent::__construct($message, $code, $previousException);

        if ($errorCode == null) {
            if ($code >= 500) {
                $errorCode = "ServerError";
            } else {
                $errorCode = "ClientError";
            }
        }
        $this->errorCode = $errorCode;
        $this->requestId = $requestId;
    }

    public function __toString()
    {
        $str = "Code: " . $this->getCode() . " Message: " . $this->getMessage();
        if ($this->errorCode != NULL) {
            $str .= " ErrorCode: " . $this->errorCode;
        }
        if ($this->requestId != NULL) {
            $str .= " RequestId: " . $this->requestId;
        }
        return $str;
    }

    public function getMnsErrorCode()
    {
        return $this->errorCode;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }
}
