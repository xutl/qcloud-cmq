<?php

namespace XuTL\QCloud\Cmq\Tests;

use XuTL\QCloud\Cmq\AsyncCallback;
use XuTL\QCloud\Cmq\Client;
use XuTL\QCloud\Cmq\Exception\CMQException;
use XuTL\QCloud\Cmq\Http\BaseResponse;
use XuTL\QCloud\Cmq\Http\Promise;
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

        $this->endPoint = $ini_array["endpoint"];
        $this->secretId = $ini_array["secretId"];
        $this->secretKey = $ini_array["secretKey"];

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

}
