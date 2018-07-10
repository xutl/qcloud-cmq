<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class RewindQueueRequest extends BaseRequest
{
    private $queueName;

    /**
     * CreateQueueRequest constructor.
     * @param string $queueName
     */
    public function __construct($queueName)
    {
        parent::__construct('RewindQueue');
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
     * 设定该时间，则（Batch）receiveMessage 接口，会按照生产消息的先后顺序消费该时间戳以后的消息。
     * @param string $startConsumeTime
     * @return BaseRequest
     */
    public function setStartConsumeTime($startConsumeTime)
    {
        $this->setParameter('startConsumeTime', $startConsumeTime);
        return $this;
    }

}
