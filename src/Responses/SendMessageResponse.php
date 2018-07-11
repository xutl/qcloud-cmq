<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class SendMessageResponse extends BaseResponse
{

    /**
     * @var string
     */
    public $msgId;

    /**
     * @var string
     */
    public $clientRequestId;

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->msgId;
    }
}
