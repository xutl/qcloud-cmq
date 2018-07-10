<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class CreateTopicRequest extends BaseRequest
{
    private $topicName;

    /**
     * CreateQueueRequest constructor.
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        parent::__construct('CreateTopic');
        $this->setTopicName($topicName);
        $this->topicName = $topicName;
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
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * 消息最大长度。取值范围 1024-65536 Byte（即1-64K），默认值 65536。
     * @param int $maxMsgSize
     * @return BaseRequest
     */
    public function setMaxMsgSize($maxMsgSize)
    {
        $this->setParameter('maxMsgSize', $maxMsgSize);
        return $this;
    }

    /**
     * 用于指定主题的消息匹配策略：
     * filterType =1 或为空， 表示该主题下所有订阅使用 filterTag 标签过滤；
     * filterType =2 表示用户使用 bindingKey 过滤。
     * 注：该参数设定之后不可更改。
     * @param int $filterType
     * @return BaseRequest
     */
    public function setFilterType($filterType)
    {
        $this->setParameter('filterType', $filterType);
        return $this;
    }
}
