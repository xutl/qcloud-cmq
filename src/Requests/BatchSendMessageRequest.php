<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class BatchSendMessageRequest extends BaseRequest
{
    /**
     * BatchPublishMessageRequest constructor.
     */
    public function __construct()
    {
        parent::__construct('BatchSendMessage');
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
     * 为方便用户使用，n 从 0 开始或者从 1 开始都可以，但必须连续，例如发送两条消息，可以是(msgBody.0, msgBody.1)，或者(msgBody.1, msgBody.2)。
     * 注意：由于目前限制所有消息大小总和（不包含消息头和其他参数，仅msgBody）不超过 64k，所以建议提前规划好批量发送的数量。
     * @param array $msgBodys
     * @return BaseRequest
     */
    public function setMsgBodys($msgBodys)
    {
        if (is_array($msgBodys) && !empty($msgBodys)) {
            $n = 1;
            foreach ($msgBodys as $msgBody) {
                $key = 'msgBody.' . $n;
                $this->setParameter($key, $msgBody);
                $n += 1;
            }
        }
        return $this;
    }

    /**
     * 单位为秒，表示该消息发送到队列后，需要延时多久用户才可见该消息。
     * @param string $delaySeconds
     * @return BaseRequest
     */
    public function setDelaySeconds($delaySeconds)
    {
        $this->setParameter('delaySeconds', $delaySeconds);
        return $this;
    }
}
