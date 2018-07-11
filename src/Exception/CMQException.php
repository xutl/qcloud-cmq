<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;

use RuntimeException;

/**
 * Class CmqException
 * @package XuTL\QCloud\Cmq\Exception
 */
class CMQException extends RuntimeException
{
    public $code;
    public $message;
    public $data;

    public function __construct($message, $code = -1, $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function __toString()
    {
        return "CMQException  " . $this->getInfo();
    }

    public function getInfo()
    {
        $info = ['code' => $this->code,
            'data' => json_encode($this->data),
            'message' => $this->message
        ];
        return json_encode($info);
    }
}
