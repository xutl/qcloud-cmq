<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class SetSubscriptionAttributeRequest extends BaseRequest
{
    /**
     * SetSubscriptionAttributeRequest constructor.
     */
    public function __construct()
    {
        parent::__construct('SetSubscriptionAttributes');
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

    /**
     * 向 endpoint 推送消息出现错误时，CMQ 推送服务器的重试策略。取值有：1）BACKOFF_RETRY，退避重试。每隔一定时间重试一次，重试够一定次数后，就把该消息丢弃，继续推送下一条消息；2）
     * EXPONENTIAL_DECAY_RETRY，指数衰退重试。每次重试的间隔是指数递增的，例如开始 1s，后面是2s，4s，8s...由于 Topic 消息的周期是一天，所以最多重试一天就把消息丢弃。默认值是EXPONENTIAL_DECAY_RETRY。
     * @param string $notifyStrategy
     * @return BaseRequest
     */
    public function setNotifyStrategy($notifyStrategy)
    {
        $this->setParameter('notifyStrategy', $notifyStrategy);
        return $this;
    }

    /**
     * 推送内容的格式。取值：1）JSON；2）SIMPLIFIED，即 raw 格式。如果 protocol 是 queue，则取值必须为 SIMPLIFIED。如果 protocol 是 http，两个值均可以，默认值是 JSON。
     * @param string $notifyContentFormat
     * @return BaseRequest
     */
    public function setNotifyContentFormat($notifyContentFormat)
    {
        $this->setParameter('notifyContentFormat', $notifyContentFormat);
        return $this;
    }

    /**
     * 消息正文。消息标签（用于消息过滤)。标签数量不能超过5个，每个标签不超过16个字符。与 (Batch)PublishMessage 的 msgTag 参数配合使用，规则：1）如果 filterTag 没有设置，
     * 则无论 msgTag 是否有设置，订阅接收所有发布到 Topic 的消息；2）如果 filterTag 数组有值，则只有数组中至少有一个值在 msgTag 数组中也存在时（即 filterTag 和 msgTag 有交集），订阅才接收该发布到 Topic 的消息；3）
     * 如果 filterTag 数组有值，但 msgTag 没设置，则不接收任何发布到 Topic 的消息，可以认为是2）的一种特例，此时 filterTag 和 msgTag 没有交集。规则整体的设计思想是以订阅者的意愿为主。
     * @param array $tags
     * @return BaseRequest
     */
    public function setFilterTags($tags)
    {
        if (is_array($tags) && !empty($tags)) {
            $n = 1;
            foreach ($tags as $tag) {
                $key = 'filterTag.' . $n;
                $this->setParameter($key, $tag);
                $n += 1;
            }
        }
        return $this;
    }

    /**
     * bindingKey 数量不超过 5 个， 每个 bindingKey 长度不超过 64 字节，该字段表示订阅接收消息的过滤策略，每个 bindingKey 最多含有 15 个“.”， 即最多 16 个词组。
     * @param array $bindingKeys
     * @return BaseRequest
     */
    public function setBindingKeys($bindingKeys)
    {
        if (is_array($bindingKeys) && !empty($bindingKeys)) {
            $n = 1;
            foreach ($bindingKeys as $bindingKey) {
                $key = 'bindingKey.' . $n;
                $this->setParameter($key, $bindingKey);
                $n += 1;
            }
        }
        return $this;
    }

}
