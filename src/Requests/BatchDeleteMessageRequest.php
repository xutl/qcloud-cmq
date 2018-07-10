<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class BatchDeleteMessageRequest extends BaseRequest
{
    /**
     * BatchDeleteMessageRequest constructor.
     * @param string $queueName
     * @param array $receiptHandles
     */
    public function __construct($queueName, $receiptHandles)
    {
        parent::__construct('BatchDeleteMessage');
        $this->setQueueName($queueName);
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
     * 上次消费消息时返回的消息句柄。为方便用户使用，n 从 0 开始或者从 1 开始都可以，但必须连续，例如删除两条消息，可以是(receiptHandle.0,receiptHandle.1)，或者(receiptHandle.1, receiptHandle.2)。
     * @param array $receiptHandles
     * @return BaseRequest
     */
    public function setReceiptHandles($receiptHandles)
    {
        if (is_array($receiptHandles) && !empty($receiptHandles)) {
            $n = 1;
            foreach ($receiptHandles as $receiptHandle) {
                $key = 'receiptHandle.' . $n;
                $this->setParameter($key, $receiptHandle);
                $n += 1;
            }
        }
        return $this;
    }

}
