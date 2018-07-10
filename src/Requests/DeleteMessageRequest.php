<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class DeleteMessageRequest extends BaseRequest
{
    /**
     * CreateQueueRequest constructor.
     * @param string $queueName
     * @param string $receiptHandle
     */
    public function __construct($queueName, $receiptHandle)
    {
        parent::__construct('DeleteMessage');
        $this->setParameter('queueName', $queueName);
        $this->setParameter('receiptHandle', $receiptHandle);
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

    public function setReceiptHandle($receiptHandle)
    {
        $this->setParameter('receiptHandle', $receiptHandle);
        return $this;
    }
}
