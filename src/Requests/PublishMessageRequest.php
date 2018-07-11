<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class PublishMessageRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct('PublishMessage');
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
     * 消息正文。至少 1 Byte，最大长度受限于设置的队列消息最大长度属性。
     * @param string $msgBody
     * @return BaseRequest
     */
    public function setMsgBody($msgBody)
    {
        $this->setParameter('msgBody', $msgBody);
        return $this;
    }

    /**
     * 消息过滤标签。消息标签（用于消息过滤)。标签数量不能超过 5 个，每个标签不超过 16 个字符。与 Subscribe 接口的 filterTag 参数配合使用，规则：
     * （1）1）如果 filterTag 没有设置，则无论 msgTag是 否有设置，订阅接收所有发布到 Topic 的消息；
     * （2）如果 filterTag 数组有值，则只有数组中至少有一个值在 msgTag 数组中也存在时（即 filterTag 和 msgTag 有交集），订阅才接收该发布到 Topic 的消息；
     * （3）如果 filterTag 数组有值，但 msgTag 没设置，则不接收任何发布到 Topic 的消息，可以认为是（2）的一种特例，此时 filterTag 和 msgTag 没有交集。规则整体的设计思想是以订阅者的意愿为主。
     * @param array $tags
     * @return BaseRequest
     */
    public function setMsgTags($tags)
    {
        if (is_array($tags) && !empty($tags)) {
            $n = 1;
            foreach ($tags as $tag) {
                $key = 'msgTag.' . $n;
                $this->setParameter($key, $tag);
                $n += 1;
            }
        }
        return $this;
    }

    /**
     * 长度<=64字节，该字段用于表示发送消息的路由路径，最多含有 15 个“.”，即最多 16 个词组。
     * 消息发送到 topic 类型的 exchange 上时不能随意指定 routingKey。需要符合上面的格式要求，一个由订阅者指定的带有 routingKey 的消息将会推送给所有 BindingKey 能与之匹配的消费者，这种匹配情况有两种关系：
     * 1 *（星号），可以替代一个单词（一串连续的字母串）；
     * 2 #（井号）：可以匹配一个或多个字符。
     * @param string $routingKey
     * @return BaseRequest
     */
    public function setRoutingKey($routingKey)
    {
        $this->setParameter('routingKey', $routingKey);
        return $this;
    }
}
