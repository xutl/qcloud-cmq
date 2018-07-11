<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;
use XuTL\QCloud\Cmq\Requests\ClearSubscriptionFilterTagsRequest;
use XuTL\QCloud\Cmq\Requests\GetSubscriptionAttributeRequest;
use XuTL\QCloud\Cmq\Requests\GetTopicAttributeRequest;
use XuTL\QCloud\Cmq\Requests\ListSubscriptionRequest;
use XuTL\QCloud\Cmq\Requests\PublishMessageRequest;
use XuTL\QCloud\Cmq\Requests\SetSubscriptionAttributeRequest;
use XuTL\QCloud\Cmq\Requests\SetTopicAttributeRequest;
use XuTL\QCloud\Cmq\Requests\SubscribeRequest;
use XuTL\QCloud\Cmq\Requests\UnsubscribeRequest;
use XuTL\QCloud\Cmq\Responses\ClearSubscriptionFilterTagsResponse;
use XuTL\QCloud\Cmq\Responses\GetSubscriptionAttributeResponse;
use XuTL\QCloud\Cmq\Responses\GetTopicAttributeResponse;
use XuTL\QCloud\Cmq\Responses\ListSubscriptionResponse;
use XuTL\QCloud\Cmq\Responses\PublishMessageResponse;
use XuTL\QCloud\Cmq\Responses\SetSubscriptionAttributeResponse;
use XuTL\QCloud\Cmq\Responses\SetTopicAttributeResponse;
use XuTL\QCloud\Cmq\Responses\SubscribeResponse;
use XuTL\QCloud\Cmq\Responses\UnsubscribeResponse;

/**
 * Class Topic
 * @package XuTL\QCloud\Cmq
 */
class Topic
{
    /**
     * @var string
     */
    private $topicName;

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * Topic constructor.
     * @param HttpClient $client
     * @param string $topicName
     */
    public function __construct(HttpClient $client, $topicName)
    {
        $this->client = $client;
        $this->topicName = $topicName;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    public function setAttribute(SetTopicAttributeRequest $request)
    {
        $request->setTopicName($this->topicName);
        $response = new SetTopicAttributeResponse($this->topicName);
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @return Http\BaseResponse|GetTopicAttributeResponse
     */
    public function getAttribute()
    {
        $request = new GetTopicAttributeRequest($this->topicName);
        $response = new GetTopicAttributeResponse($this->topicName);
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @param PublishMessageRequest $request
     * @return Http\BaseResponse|PublishMessageResponse
     */
    public function publishMessage(PublishMessageRequest $request)
    {
        $request->setTopicName($this->topicName);
        $response = new PublishMessageResponse();
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @param SubscribeRequest $request
     * @return Http\BaseResponse
     */
    public function subscribe(SubscribeRequest $request)
    {
        $request->setTopicName($this->topicName);
        $response = new SubscribeResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function unsubscribe($subscriptionName)
    {
        $request = new UnsubscribeRequest($this->topicName, $subscriptionName);
        $response = new UnsubscribeResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function ClearSubscriptionFilterTags($subscriptionName)
    {
        $request = new ClearSubscriptionFilterTagsRequest($this->topicName, $subscriptionName);
        $response = new ClearSubscriptionFilterTagsResponse();
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @param $subscriptionName
     * @return Http\BaseResponse|GetSubscriptionAttributeResponse
     */
    public function getSubscriptionAttribute($subscriptionName)
    {
        $request = new GetSubscriptionAttributeRequest($this->topicName, $subscriptionName);
        $response = new GetSubscriptionAttributeResponse($this->topicName,$subscriptionName);
        return $this->client->sendRequest($request, $response);
    }

    public function setSubscriptionAttribute(SetSubscriptionAttributeRequest $request)
    {
        $request->setTopicName($this->topicName);
        $response = new SetSubscriptionAttributeResponse();
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @param null $retNum
     * @param null $prefix
     * @param null $marker
     * @return Http\BaseResponse|ListSubscriptionResponse
     */
    public function listSubscription($retNum = null, $prefix = null, $marker = null)
    {
        $request = new ListSubscriptionRequest($this->topicName, $retNum, $prefix, $marker);
        $response = new ListSubscriptionResponse();
        return $this->client->sendRequest($request, $response);
    }
}
