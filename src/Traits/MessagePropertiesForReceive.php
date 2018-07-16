<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Traits;

/**
 * Trait MessagePropertiesForReceive
 * @package XuTL\QCloud\Cmq\Traits
 */
trait MessagePropertiesForReceive
{
    /**
     * @var string
     */
    protected $msgId;

    /**
     * @var string
     */
    protected $msgBody;

    /**
     * @var int
     */
    protected $enqueueTime;

    /**
     * @var int
     */
    protected $nextVisibleTime;

    /**
     * @var int
     */
    protected $firstDequeueTime;

    /**
     * @var int
     */
    protected $dequeueCount;

    /**
     * @var string
     */
    protected $receiptHandle;

    /**
     * 本次消费的消息唯一标识 Id。
     * @return string
     */
    public function getMessageId()
    {
        return $this->msgId;
    }

    /**
     * 本次消费的消息正文。
     * @return string
     */
    public function getMessageBody()
    {
        return $this->msgBody;
    }

    /**
     * 消息内容MD5
     * @return string
     */
    public function getMessageBodyMD5()
    {
        return md5($this->msgBody);
    }

    /**
     * 本次消费的消息唯一标识 Id。
     * @return string
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * 本次消费的消息正文。
     * @return string
     */
    public function getMsgBody()
    {
        return $this->msgBody;
    }

    /**
     * 消费被生产出来，进入队列的时间。返回 Unix 时间戳，精确到秒。
     * @return int
     */
    public function getEnqueueTime()
    {
        return $this->enqueueTime;
    }

    /**
     * 消息的下次可见（可再次被消费）时间。返回 Unix 时间戳，精确到秒。
     * @return int
     */
    public function getNextVisibleTime()
    {
        return $this->nextVisibleTime;
    }

    /**
     * 第一次消费该消息的时间。返回 Unix 时间戳，精确到秒。
     * @return int
     */
    public function getFirstDequeueTime()
    {
        return $this->firstDequeueTime;
    }

    /**
     * 消息被消费的次数。
     * @return int
     */
    public function getDequeueCount()
    {
        return $this->dequeueCount;
    }

    /**
     * 每次消费返回唯一的消息句柄。用于删除该消息，仅上一次消费时产生的消息句柄能用于删除消息。
     * @return string
     */
    public function getReceiptHandle()
    {
        return $this->receiptHandle;
    }
}
