<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class GetSubscriptionAttributeResponse extends BaseResponse
{
    public $topicName;
    public $subscriptionName;
    public $notifyStrategy;

    public function __construct($topicName, $subscriptionName)
    {
        $this->topicName = $topicName;
        $this->subscriptionName = $subscriptionName;
    }

    public function getTopicName()
    {
        return $this->topicName;
    }

    public function getNotifyStrategy()
    {
        return $this->notifyStrategy;
    }
}
