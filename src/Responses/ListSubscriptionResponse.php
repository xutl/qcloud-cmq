<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class ListSubscriptionResponse extends BaseResponse
{
    /**
     * @var string
     */
    public $topicName;

    /**
     * @var int
     */
    public $totalCount;

    /**
     * @var array
     */
    public $subscriptionList;

    /**
     * ListSubscriptionResponse constructor.
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        $this->topicName = $topicName;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * 获取订阅名称列表
     * @return array
     */
    public function getSubscriptionNames()
    {
        $subscriptionNames = [];
        foreach ($this->subscriptionList as $subscription) {
            $subscriptionNames[] = $subscription['subscriptionName'];
        }
        return $subscriptionNames;
    }
}
