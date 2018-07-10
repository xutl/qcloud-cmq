<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;

use XuTL\QCloud\Cmq\Http\BaseRequest;

/**
 * 创建队列
 * @package XuTL\QCloud\Cmq\Requests
 */
class CreateQueueRequest extends BaseRequest
{

    /**
     * CreateQueueRequest constructor.
     */
    public function __construct()
    {
        parent::__construct('CreateQueue');
    }

    /**
     * 设置队列名称
     * @param string $queueName
     * @return BaseRequest
     */
    public function setQueueName($queueName)
    {
        $this->setBizContent('queueName', $queueName);
        return $this;
    }

    /**
     * 最大堆积消息数。取值范围在公测期间为 1,000,000 - 10,000,000，正式上线后范围可达到 1000,000-1000,000,000。默认取值在公测期间为 10,000,000，正式上线后为 100,000,000。
     * @param int $maxMsgHeapNum
     * @return BaseRequest
     */
    public function setMaxMsgHeapNum($maxMsgHeapNum)
    {
        $this->setBizContent('maxMsgHeapNum', $maxMsgHeapNum);
        return $this;
    }

    /**
     * 消息接收长轮询等待时间。取值范围 0-30 秒，默认值 0。
     * @param int $pollingWaitSeconds
     * @return BaseRequest
     */
    public function setPollingWaitSeconds($pollingWaitSeconds)
    {
        $this->setBizContent('pollingWaitSeconds', $pollingWaitSeconds);
        return $this;
    }

    /**
     * 消息可见性超时。取值范围 1-43200 秒（即12小时内），默认值 30。
     * @param int $visibilityTimeout
     * @return BaseRequest
     */
    public function setVisibilityTimeout($visibilityTimeout)
    {
        $this->setBizContent('visibilityTimeout', $visibilityTimeout);
        return $this;
    }

    /**
     * 消息最大长度。取值范围 1024-65536 Byte（即1-64K），默认值 65536。
     * @param int $maxMsgSize
     * @return BaseRequest
     */
    public function setMaxMsgSize($maxMsgSize)
    {
        $this->setBizContent('maxMsgSize', $maxMsgSize);
        return $this;
    }

    /**
     * 消息保留周期。取值范围 60-1296000 秒（1min-15天），默认值 345600 (4 天)。
     * @param int $msgRetentionSeconds
     * @return BaseRequest
     */
    public function setMsgRetentionSeconds($msgRetentionSeconds)
    {
        $this->setBizContent('msgRetentionSeconds', $msgRetentionSeconds);
        return $this;
    }

    /**
     * 队列是否开启回溯消息能力，该参数取值范围 0-msgRetentionSeconds,即最大的回溯时间为消息在队列中的保留周期，0 表示不开启。
     * @param int $rewindSeconds
     * @return BaseRequest
     */
    public function setRewindSeconds($rewindSeconds)
    {
        $this->setBizContent('rewindSeconds', $rewindSeconds);
        return $this;
    }

}
