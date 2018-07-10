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
    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;
    /**
     * @var array
     */
    public $data;

    /**
     * Exception constructor.
     * @param string $message 错误描述
     * @param int $code 错误类型
     * @param array $data 错误数据
     */
    public function __construct($message, $code = -1, $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Exception  " . $this->getInfo();
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        $info = [
            'code' => $this->code,
            'data' => json_encode($this->data),
            'message' => $this->message
        ];
        return json_encode($info);
    }
}
