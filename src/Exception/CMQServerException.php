<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class CMQServerException extends CMQException
{
    public $requestId;

    public function __construct($message, $requestId, $code = -1, $data = [])
    {
        parent::__construct($message, $code, $data);
        $this->requestId = $requestId;
    }

    public function __toString()
    {
        return "CMQServerException  " . $this->getinfo() . ", RequestID:" . $this->requestId;
    }
}
