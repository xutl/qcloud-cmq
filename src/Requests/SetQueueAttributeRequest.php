<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

/**
 * Class SetQueueAttributeRequest
 * @package XuTL\QCloud\Cmq\Requests
 */
class SetQueueAttributeRequest extends BaseRequest
{
    private $queueName;

    /**
     * CreateQueueRequest constructor.
     * @param string $queueName
     */
    public function __construct($queueName)
    {
        parent::__construct('CreateQueue');
        $this->setQueueName($queueName);
        $this->queueName = $queueName;
    }

    /**
     * 设置队列名称
     * @param string $queueName
     * @return BaseRequest
     */
    public function setQueueName($queueName)
    {
        $this->setParameter('queueName', $queueName);
        return $this;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * 最大堆积消息数。取值范围在公测期间为 1,000,000 - 10,000,000，正式上线后范围可达到 1000,000-1000,000,000。默认取值在公测期间为 10,000,000，正式上线后为 100,000,000。
     * @param int $maxMsgHeapNum
     * @return BaseRequest
     */
    public function setMaxMsgHeapNum($maxMsgHeapNum)
    {
        $this->setParameter('maxMsgHeapNum', $maxMsgHeapNum);
        return $this;
    }

    /**
     * 消息接收长轮询等待时间。取值范围 0-30 秒，默认值 0。
     * @param int $pollingWaitSeconds
     * @return BaseRequest
     */
    public function setPollingWaitSeconds($pollingWaitSeconds)
    {
        $this->setParameter('pollingWaitSeconds', $pollingWaitSeconds);
        return $this;
    }

    /**
     * 消息可见性超时。取值范围 1-43200 秒（即 12 小时内），默认值 30。
     * @param int $visibilityTimeout
     * @return BaseRequest
     */
    public function setVisibilityTimeout($visibilityTimeout)
    {
        $this->setParameter('visibilityTimeout', $visibilityTimeout);
        return $this;
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
     * 消息保留周期。取值范围 60-1296000 秒（1min-15 天），默认值 345600 (4 天)。
     * @param int $msgRetentionSeconds
     * @return BaseRequest
     */
    public function setMsgRetentionSeconds($msgRetentionSeconds)
    {
        $this->setParameter('msgRetentionSeconds', $msgRetentionSeconds);
        return $this;
    }

    /**
     * 消息最长回溯时间，取值范围 0-msgRetentionSeconds，消息的最大回溯之间为消息在队列中的保存周期，0 表示不开启消息回溯。
     * @param int $rewindSeconds
     * @return BaseRequest
     */
    public function setRewindSeconds($rewindSeconds)
    {
        $this->setParameter('rewindSeconds', $rewindSeconds);
        return $this;
    }
}
