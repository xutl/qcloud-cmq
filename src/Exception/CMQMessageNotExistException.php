<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Exception;


class CMQMessageNotExistException extends CMQException
{
    public function __toString()
    {
        return "CMQMessageNotExistException  " . $this->getInfo();
    }
}
