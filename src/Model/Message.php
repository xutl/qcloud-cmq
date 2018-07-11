<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Model;

/**
 * Class Message
 * @package XuTL\QCloud\Cmq\Model
 */
class Message
{
    protected $enqueueTime;
    protected $nextVisibleTime;
    protected $firstDequeueTime;
    protected $dequeueCount;
    protected $msgId;
    protected $msgBody;
    protected $receiptHandle;

    public function __construct($msgId, $msgBody, $enqueueTime, $nextVisibleTime, $firstDequeueTime, $dequeueCount, $receiptHandle)
    {
        $this->msgId = $msgId;
        $this->msgBody = $msgBody;
        $this->enqueueTime = $enqueueTime;
        $this->nextVisibleTime = $nextVisibleTime;
        $this->firstDequeueTime = $firstDequeueTime;
        $this->dequeueCount = $dequeueCount;
        $this->receiptHandle = $receiptHandle;
    }

    public function getMsgBody()
    {
        return $this->msgBody;
    }

    public function getEnqueueTime()
    {
        return $this->enqueueTime;
    }

    public function getNextVisibleTime()
    {
        return $this->nextVisibleTime;
    }

    public function getFirstDequeueTime()
    {
        return $this->firstDequeueTime;
    }

    public function getDequeueCount()
    {
        return $this->dequeueCount;
    }

    public function getReceiptHandle()
    {
        return $this->receiptHandle;
    }

}
