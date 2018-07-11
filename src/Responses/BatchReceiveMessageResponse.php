<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use Psr\Http\Message\ResponseInterface;
use XuTL\QCloud\Cmq\Http\BaseResponse;
use XuTL\QCloud\Cmq\Model\Message;

class BatchReceiveMessageResponse extends BaseResponse
{
    protected $messages;
    protected $msgInfoList;

    public function unwrapResponse(ResponseInterface $response)
    {
        parent::unwrapResponse($response);
        foreach ($this->msgInfoList as $msg) {
            $this->messages[] = new Message($msg['msgId'], $msg['msgBody'], $msg['enqueueTime'], $msg['nextVisibleTime'], $msg['firstDequeueTime'], $msg['dequeueCount'], $msg['receiptHandle']);
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
