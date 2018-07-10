<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

/**
 * Class GetSubscriptionAttributeRequest
 * @package XuTL\QCloud\Cmq\Requests
 */
class GetSubscriptionAttributeRequest extends BaseRequest
{
    /**
     * UnsubscribeRequest constructor.
     * @param string $topicName
     * @param string $subscriptionName
     */
    public function __construct($topicName, $subscriptionName)
    {
        parent::__construct('GetSubscriptionAttributes');
        $this->setTopicName($topicName);
        $this->setSubscriptionName($subscriptionName);
    }

    /**
     * 设置主题名称
     * @param string $topicName
     * @return BaseRequest
     */
    public function setTopicName($topicName)
    {
        $this->setParameter('topicName', $topicName);
        return $this;
    }

    /**
     * 订阅名字，在单个地域同一帐号的同一主题下唯一。订阅名称是一个不超过 64 个字符的字符串，必须以字母为首字符，剩余部分可以包含字母、数字和横划线(-)。
     * @param string $subscriptionName
     * @return BaseRequest
     */
    public function setSubscriptionName($subscriptionName)
    {
        $this->setParameter('subscriptionName', $subscriptionName);
        return $this;
    }
}
