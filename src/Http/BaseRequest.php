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
class BaseRequest
{
    private $parameter = [];

    /**
     * BaseRequest constructor.
     * @param string $action
     */
    public function __construct($action)
    {
        $this->parameter['Action'] = ucfirst($action);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->parameter['Action'];
    }

    /**
     * @param string $key
     * @param string|array $value
     */
    public function setParameter($key, $value)
    {
        $this->parameter[$key] = $value;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameter;
    }
}
