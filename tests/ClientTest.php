<?php

namespace XuTL\QCloud\Cmq\Tests;

use XuTL\QCloud\Cmq\AsyncCallback;
use XuTL\QCloud\Cmq\Client;
use XuTL\QCloud\Cmq\Exception\CMQException;
use XuTL\QCloud\Cmq\Requests\CreateQueueRequest;
use XuTL\QCloud\Cmq\Requests\CreateTopicRequest;
use XuTL\QCloud\Cmq\Requests\ListQueueRequest;
use XuTL\QCloud\Cmq\Requests\ListTopicRequest;

/**
 * Class ClientTest
 * @package XuTL\QCloud\Cmq\Tests
 */
class ClientTest extends \PHPUnit\Framework\TestCase
{
    private $secretId;
    private $secretKey;
    private $endPoint;

    /**
     * @var Client
     */
    private $client;

    private $queueToDelete;
    private $topicToDelete;

    public function setUp()
    {
        $ini_array = parse_ini_file(__DIR__ . "/cmq.ini");

        $this->endPoint = $ini_array["endpoint"] != '<endpoint>' ? $ini_array["endpoint"] : 'https://cmq-topic-bj.api.qcloud.com';
        $this->secretId = $ini_array["secretId"] != '<secretId>' ? $ini_array["secretId"] : getenv('SECRET_ID');
        $this->secretKey = $ini_array["secretKey"] != '<secretKey>' ? $ini_array["secretKey"] : getenv('SECRET_KEY');

        $this->queueToDelete = [];
        $this->topicToDelete = [];

        $this->client = new Client($this->endPoint, $this->secretId, $this->secretKey);
    }

    public function tearDown()
    {
        foreach ($this->queueToDelete as $queueName) {
            try {
                $this->client->deleteQueue($queueName);
            } catch (\Exception $e) {
            }
        }
        foreach ($this->topicToDelete as $topicName) {
            try {
                $this->client->deleteTopic($topicName);
            } catch (\Exception $e) {
            }
        }
    }

    public function testCreateQueueAsync()
    {
        $queueName = "testCreateQueueAsync";
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;

        // Async Call with callback
        try {
            $res = $this->client->createQueueAsync($request,
                new AsyncCallback(
                    function ($response) {
                        $this->assertTrue($response->isSucceed());
                    },
                    function ($e) {
                        $this->assertTrue(false, $e);
                    }
                )
            );
            $res = $res->wait();
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // Async call without callback
        $queueName = "testCreateQueueAsync1";
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueueAsync($request);
            $res = $res->wait();
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
    }

    public function testCreateQueueSync()
    {
        $queueName = "2testCreateQueueSync";

        // 1. create queue with InvalidArgument
        $request = new CreateQueueRequest($queueName);
        $request->setPollingWaitSeconds(60);
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue(false, "Should throw InvalidArgumentException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }

        // 2. create queue
        $queueName = "testCreateQueueSync";
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 3. create queue with same attributes
        $queueName = "testCreateQueueSync111";
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 4. create same queue with different attributes
        $queueName = "testCreateQueueSync";
        $request = new CreateQueueRequest($queueName);
        $request->setPollingWaitSeconds(20);
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue(false, "Should throw QueueAlreadyExistException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }
    }

    public function testListQueue()
    {
        $queueNamePrefix = 'superMan_' . uniqid();
        $queueName1 = $queueNamePrefix . "testListQueue1";
        $queueName2 = $queueNamePrefix . "testListQueue2";

        // 1. create queue
        $request = new CreateQueueRequest($queueName1);
        $this->queueToDelete[] = $queueName1;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $request = new CreateQueueRequest($queueName2);
        $this->queueToDelete[] = $queueName2;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 2. list queue
        $queueName1Found = false;
        $queueName2Found = false;

        $request = new ListQueueRequest();
        $request->setSearchWord($queueNamePrefix);

        $res = $this->client->listQueue($request);
        $this->assertTrue($res->isSucceed());

        if ($res->totalCount > 0) {
            $this->assertTrue(true, $res->totalCount > 0);
        }
        $queueNames = $res->getQueueNames();

        foreach ($queueNames as $queueName) {
            if ($queueName == $queueName1) {
                $queueName1Found = true;
            } elseif ($queueName == $queueName2) {
                $queueName2Found = true;
            } else {
                $this->assertTrue(false, $queueName . " Should not be here.");
            }
        }

        $this->assertTrue($queueName1Found, $queueName1 . " Not Found!");
        $this->assertTrue($queueName2Found, $queueName2 . " Not Found!");
    }

    public function testListQueueAsync()
    {
        $queueNamePrefix = 'superMan_' . uniqid();
        $queueName1 = $queueNamePrefix . "testListQueue1";
        $queueName2 = $queueNamePrefix . "testListQueue2";

        // 1. create queue
        $request = new CreateQueueRequest($queueName1);
        $this->queueToDelete[] = $queueName1;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $request = new CreateQueueRequest($queueName2);
        $this->queueToDelete[] = $queueName2;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 2. list queue
        $queueName1Found = false;
        $queueName2Found = false;

        $request = new ListQueueRequest();
        $request->setSearchWord($queueNamePrefix);

        try {
            $res = $this->client->listQueueAsync($request,
                new AsyncCallback(
                    function ($response) use (&$request, $queueName1, $queueName2, &$queueName1Found, &$queueName2Found) {
                        $this->assertTrue($response->isSucceed());

                        $queueNames = $response->getQueueNames();
                        foreach ($queueNames as $queueName) {
                            if ($queueName == $queueName1) {
                                $queueName1Found = TRUE;
                            } elseif ($queueName == $queueName2) {
                                $queueName2Found = TRUE;
                            } else {
                                $this->assertTrue(FALSE, $queueName . " Should not be here.");
                            }
                        }
                    },
                    function ($e) {
                        $this->assertTrue(false, $e);
                    }
                )
            );
            $res = $res->wait();

            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $this->assertTrue($queueName1Found, $queueName1 . " Not Found!");
        $this->assertTrue($queueName2Found, $queueName2 . " Not Found!");
    }

    public function testDeleteQueue()
    {
        $queueName = "testDeleteQueue";

        // 1. create queue
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 2. delete queue
        try {
            $res = $this->client->deleteQueue($queueName);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
    }

    public function testDeleteQueueAsync()
    {
        $queueName = "testDeleteQueueAsync";

        // 1. create queue
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(FALSE, $e);
        }

        // 2. delete Queue
        try {
            $res = $this->client->deleteQueueAsync($queueName);
            $res = $res->wait();

            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(FALSE, $e);
        }
    }

    public function testCreateTopicSync()
    {
        $topicName = "2testCreateTopicSync";

        // 1. create topic with InvalidArgument
        $request = new CreateTopicRequest($topicName);
        $request->setMaxMsgSize(65 * 1024);
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue(false, "Should throw InvalidArgumentException");
        } catch (CMQException $e) {
            $this->assertEquals($e->getCode(), 4000);
        }

        // 2. create topic
        $topicName = "testCreateTopicSync";
        $request = new CreateTopicRequest($topicName);
        $this->topicToDelete[] = $topicName;
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 3. create topic with same attributes
        $topicName = "testCreateTopicSync1";
        $request = new CreateTopicRequest($topicName);
        $this->topicToDelete[] = $topicName;
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
    }

    public function testListTopic()
    {
        $topicNamePrefix = 'superMan_' . uniqid();
        $topicName1 = $topicNamePrefix . "testListTopic1";
        $topicName2 = $topicNamePrefix . "testListTopic2";

        // 1. create Topic
        $request = new CreateTopicRequest($topicName1);
        $this->topicToDelete[] = $topicName1;
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $request = new CreateTopicRequest($topicName2);
        $this->topicToDelete[] = $topicName2;
        try {
            $res = $this->client->createTopic($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        // 2. list Topic
        $topicName1Found = false;
        $topicName2Found = false;

        $request = new ListTopicRequest();
        $request->setSearchWord($topicNamePrefix);

        $res = $this->client->listTopic($request);
        $this->assertTrue($res->isSucceed());

        $topicNames = $res->getTopicNames();
        foreach ($topicNames as $topicName) {
            if ($topicName == $topicName1) {
                $topicName1Found = true;
            } elseif ($topicName == $topicName2) {
                $topicName2Found = true;
            } else {
                $this->assertTrue(false, $topicName . " Should not be here.");
            }
        }

        $this->assertTrue($topicName1Found, $topicName1 . " Not Found!");
        $this->assertTrue($topicName2Found, $topicName2 . " Not Found!");
    }
}
