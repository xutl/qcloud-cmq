<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Traits;


trait MessagePropertiesForReceive
{
    protected $msgId;
    protected $msgBody;
    protected $enqueueTime;
    protected $nextVisibleTime;
    protected $firstDequeueTime;
    protected $dequeueCount;
    protected $receiptHandle;

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
