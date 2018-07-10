<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class ReceiveMessageResponse extends BaseResponse
{

    public $msgId;
    public $receiptHandle;
    public $msgBody;
    public $enqueueTime;
    public $nextVisibleTime;
    public $firstDequeueTime;
    public $dequeueCount;
}
