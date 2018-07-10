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
     * @var array
     */
    private $bizContent;

    /**
     * @var string
     */
    private $apiVersion = "1.0";

    /**
     * @var string
     */
    private $notifyUrl;

    /**
     * @var string
     */
    private $returnUrl;

    /**
     * 设置业务参数
     * @param string $key
     * @param mixed $value
     */
    public function setBizContent($key, $value)
    {
        $this->bizContent[$key] = $value;
    }

    /**
     * 设置业务参数
     * @param array $bizContent
     */
    public function setBizContents($bizContent)
    {
        $this->bizContent = $bizContent;
    }

    /**
     * 获取业务参数
     * @return array
     */
    public function getBizContents()
    {
        return $this->bizContent;
    }

    /**
     * 获取API方法名称
     * @return string
     */
    abstract public function getApiMethodName();

    /**
     * 设置通知 Url
     * @param string $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }

    /**
     * 获取通知 URL
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * 设置回调 URL
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * 获取回调 Url
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * 设置 API 版本
     * @param string $apiVersion
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    /**
     * 获取 API 版本
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }
}
