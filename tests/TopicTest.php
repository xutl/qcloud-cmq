<?php

namespace XuTL\QCloud\Cmq\Tests;

use XuTL\QCloud\Cmq\Client;
use XuTL\QCloud\Cmq\Exception\CMQException;
use XuTL\QCloud\Cmq\Requests\CreateTopicRequest;
use XuTL\QCloud\Cmq\Requests\PublishMessageRequest;
use XuTL\QCloud\Cmq\Requests\SetSubscriptionAttributeRequest;
use XuTL\QCloud\Cmq\Requests\SetTopicAttributeRequest;
use XuTL\QCloud\Cmq\Requests\SubscribeRequest;
use XuTL\QCloud\Cmq\Requests\UnsubscribeRequest;
use XuTL\QCloud\Cmq\Topic;

class TopicTest extends \PHPUnit\Framework\TestCase
{
    private $secretId;
    private $secretKey;
    private $endPoint;

    /**
     * @var Client
     */
    private $client;

    private $topicToDelete;

    public function setUp()
    {
        $ini_array = parse_ini_file(__DIR__ . "/cmq.ini");

        $this->endPoint = $ini_array["endpoint"] != '<endpoint>' ? $ini_array["endpoint"] : 'https://cmq-topic-bj.api.qcloud.com';
        $this->secretId = $ini_array["secretId"] != '<secretId>' ? $ini_array["secretId"] : getenv('SECRET_ID');
        $this->secretKey = $ini_array["secretKey"] != '<secretKey>' ? $ini_array["secretKey"] : getenv('SECRET_KEY');

        $this->topicToDelete = [];
        $this->client = new Client($this->endPoint, $this->secretId, $this->secretKey);
    }

    public function tearDown()
    {
        foreach ($this->topicToDelete as $topicName) {
            try {
                $this->client->deleteTopic($topicName);
            } catch (\Exception $e) {
            }
        }
    }

    private function prepareTopic($topicName)
    {
        $request = new CreateTopicRequest($topicName);
        $this->topicToDelete[] = $topicName;
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        return $this->client->getTopicRef($topicName);
    }

    private function prepareSubscription(Topic $topic, $subscriptionName)
    {
        try {
            $request = new SubscribeRequest();
            $request->setSubscriptionName($subscriptionName);
            $request->setProtocol('http');
            $request->setNotifyStrategy('BACKOFF_RETRY');
            $request->setEndpoint('http://www.baidu.com');
            $request->setBindingKeys(['bb']);
            $topic->subscribe($request);
        } catch (CMQException $e) {
        }
    }

    public function testTopicAttributes()
    {
        $topicName = "testTopicAttributes";
        $topic = $this->prepareTopic($topicName);

        try {
            $res = $topic->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($topicName, $res->getTopicName());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $maximumMessageSize = 10 * 1024;
        $request = new SetTopicAttributeRequest();
        $request->setTopicName($topicName);
        $request->setMaxMsgSize($maximumMessageSize);
        try {
            $res = $topic->setAttribute($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        try {
            $res = $topic->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($res->getMaxMsgSize(), $maximumMessageSize);
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $this->client->deleteTopic($topicName);

        try {
            $res = $topic->getAttribute();
            $this->assertTrue(false, "Should throw TopicNotExistException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }

        try {
            $res = $topic->setAttribute($request);
            $this->assertTrue(False, "Should throw TopicNotExistException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }
    }

    public function testSubscribe()
    {
        $topicName = 'testSubscribeTopic' . uniqid();
        $topic = $this->prepareTopic($topicName);

        $subscriptionName = 'testSubscribeSubscription' . uniqid();
        $request = new SubscribeRequest();
        $request->setTopicName($topicName);
        $request->setSubscriptionName($subscriptionName);
        $request->setProtocol('http');
        $request->setEndpoint('http://www.baidu.com');
        $request->setBindingKeys(['bb']);

        try {
            $topic->subscribe($request);
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        try {
            $request->setNotifyContentFormat('SIMPLIFIED');
            $res = $topic->subscribe($request);
            $this->assertTrue(False, "Should throw SubscriptionAlreadyExist");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }

        $topic->unsubscribe($subscriptionName);
    }

    public function testPublishMessage()
    {
        $topicName = "testPublishMessage" . uniqid();
        $topic = $this->prepareTopic($topicName);

        $subscriptionName = 'testSubscribeSubscription' . uniqid();
        $request = new SubscribeRequest();
        $request->setTopicName($topicName);
        $request->setSubscriptionName($subscriptionName);
        $request->setProtocol('http');
        $request->setEndpoint('http://www.baidu.com');
        $request->setBindingKeys(['bb']);

        try {
            $topic->subscribe($request);
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $messageBody = "test";
        $request = new PublishMessageRequest();
        $request->setTopicName($topicName);
        $request->setMsgBody($messageBody);

        try {
            $res = $topic->publishMessage($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $topic->unsubscribe($subscriptionName);
        $this->client->deleteTopic($topic->getTopicName());

        try {
            $res = $topic->publishMessage($request);
            $this->assertTrue(false, "Should throw SubscriptionAlreadyExist");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4440);
        }
    }

    public function testSubscriptionAttributes()
    {
        $topicName = "testSubscriptionAttributes" . uniqid();
        $subscriptionName = "testSubscriptionAttributes" . uniqid();
        $topic = $this->prepareTopic($topicName);
        $this->prepareSubscription($topic, $subscriptionName);

        try {
            $res = $topic->getSubscriptionAttribute($subscriptionName);
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($topicName, $res->getTopicName());
            $this->assertEquals('BACKOFF_RETRY', $res->getNotifyStrategy());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $strategy = 'EXPONENTIAL_DECAY_RETRY';
        $request = new SetSubscriptionAttributeRequest();
        $request->setTopicName($topicName);
        $request->setSubscriptionName($subscriptionName);
        $request->setNotifyStrategy($strategy);
        try {
            $res = $topic->setSubscriptionAttribute($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        try {
            $res = $topic->getSubscriptionAttribute($subscriptionName);
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($res->getNotifyStrategy(), $strategy);
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $topic->unsubscribe($subscriptionName);

        try {
            $res = $topic->getSubscriptionAttribute($subscriptionName);
            $this->assertTrue(false, "Should throw SubscriptionNotExistException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }

        try {
            $res = $topic->setSubscriptionAttribute($request);
            $this->assertTrue(false, "Should throw SubscriptionNotExistException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }
    }

    public function testListSubscriptions()
    {
        $topicName = "testListSubscriptionsTopic" . uniqid();
        $subscriptionNamePrefix = uniqid();
        $subscriptionName1 = $subscriptionNamePrefix . "testListTopic1";
        $subscriptionName2 = $subscriptionNamePrefix . "testListTopic2";

        // 1. create Topic and Subscriptions
        $topic = $this->prepareTopic($topicName);
        $this->prepareSubscription($topic, $subscriptionName1);
        $this->prepareSubscription($topic, $subscriptionName2);

        // 2. list subscriptions
        $subscriptionName1Found = false;
        $subscriptionName2Found = false;

        $res = $topic->listSubscription();
        $this->assertTrue($res->isSucceed());

        $subscriptionNames = $res->getSubscriptionNames();
        foreach ($subscriptionNames as $subscriptionName) {
            if ($subscriptionName == $subscriptionName1) {
                $subscriptionName1Found = true;
            } elseif ($subscriptionName == $subscriptionName2) {
                $subscriptionName2Found = true;
            } else {
                $this->assertTrue(false, $subscriptionName . " Should not be here.");
            }
        }

        $this->assertTrue($subscriptionName1Found, $subscriptionName1 . " Not Found!");
        $this->assertTrue($subscriptionName2Found, $subscriptionName2 . " Not Found!");

        $topic->unsubscribe($subscriptionName1);
        $topic->unsubscribe($subscriptionName2);

    }
}
