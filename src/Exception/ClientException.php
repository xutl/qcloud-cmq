<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class ClientException extends Exception
{
    /**
     * ClientException constructor.
     * @param string $message
     * @param int $code
     * @param array $data
     */
    public function __construct($message, $code = -1, $data = [])
    {
        parent::__construct($message, $code, $data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "ClientException  " . $this->getInfo();
    }
}
