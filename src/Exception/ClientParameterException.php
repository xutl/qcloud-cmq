<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class ClientParameterException extends ClientException
{
    public function __construct($message, $code = -1, $data = [])
    {
        parent::__construct($message, $code, $data);
    }

    public function __toString()
    {
        return "ClientParameterException  " . $this->getInfo();
    }
}
