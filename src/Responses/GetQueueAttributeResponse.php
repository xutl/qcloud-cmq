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
    public $maxMsgHeapNum;
    public $pollingWaitSeconds;
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
    public $queueName;
    public $queueId;
}
