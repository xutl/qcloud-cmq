<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class CMQServerNetworkException extends CMQException
{
    public $status;
    public $header;
    public $data;

    public function __construct($status = 200, $header = null, $data = "")
    {
        if ($header == null) {
            $header = [];
        }
        $this->status = $status;
        $this->header = $header;
        $this->data = $data;
    }

    public function __toString()
    {
        $info = [
            "status" => $this->status,
            "header" => json_encode($this->header),
            "data" => $this->data
        ];

        return "CMQServerNetworkException  " . json_encode($info);
    }
}
