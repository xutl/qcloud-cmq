<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Model;

use XuTL\QCloud\Cmq\Traits\MessagePropertiesForReceive;

/**
 * Class Message
 * @package XuTL\QCloud\Cmq\Model
 */
class Message
{
    use MessagePropertiesForReceive;

    /**
     * Message constructor.
     * @param string $msgId
     * @param string $msgBody
     * @param int $enqueueTime
     * @param int $nextVisibleTime
     * @param int $firstDequeueTime
     * @param int $dequeueCount
     * @param string $receiptHandle
     */
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
}
