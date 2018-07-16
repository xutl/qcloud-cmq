<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class GetQueueAttributeResponse extends BaseResponse
{
    /**
     * @var int
     */
    public $maxMsgHeapNum;

    /**
     * @var int
     */
    public $pollingWaitSeconds;

    /**
     * @var int
     */
    public $visibilityTimeout;
    public $maxMsgSize;
    public $msgRetentionSeconds;
    public $rewindSeconds;
    public $delayMsgNum;
    public $minMsgTime;
    public $rewindMsgNum;
    public $inactiveMsgNum;
    public $activeMsgNum;
    public $lastModifyTime;
    public $createTime;

    /**
     * @var string
     */
    public $queueName;

    /**
     * @var string
     */
    public $queueId;

    /**
     * @return int
     */
    public function getVisibilityTimeout()
    {
        return $this->visibilityTimeout;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @return bool
     */
    public function getRewindEnabled()
    {
        return $this->rewindSeconds > 0;
    }
}
