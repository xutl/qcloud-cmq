<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

/**
 * Class BaseRequest
 * @package Xutl\QCloud\Cmq\Http
 */
abstract class BaseRequest
{
    /**
     * @var string
     */
    private $action;

    /**
     * BaseRequest constructor.
     * @param string $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }
}
