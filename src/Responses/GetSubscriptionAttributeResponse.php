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
    /**
     * @var string
     */
    public $topicName;

    /**
     * @var string
     */
    public $subscriptionName;

    /**
     * @var string
     */
    public $notifyStrategy;

    /**
     * GetSubscriptionAttributeResponse constructor.
     * @param string $topicName
     * @param string $subscriptionName
     */
    public function __construct($topicName, $subscriptionName)
    {
        $this->topicName = $topicName;
        $this->subscriptionName = $subscriptionName;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * @return string
     */
    public function getNotifyStrategy()
    {
        return $this->notifyStrategy;
    }
}
