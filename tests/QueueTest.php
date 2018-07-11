<?php

namespace XuTL\QCloud\Cmq\Tests;

use XuTL\QCloud\Cmq\Client;
use XuTL\QCloud\Cmq\Exception\CMQException;
use XuTL\QCloud\Cmq\Requests\CreateQueueRequest;
use XuTL\QCloud\Cmq\Requests\SetQueueAttributeRequest;

class QueueTest extends \PHPUnit\Framework\TestCase
{
    private $secretId;
    private $secretKey;
    private $endPoint;

    /**
     * @var Client
     */
    private $client;

    private $queueToDelete;

    public function setUp()
    {
        $ini_array = parse_ini_file(__DIR__ . "/cmq.ini");

        $this->endPoint = $ini_array["endpoint"] != '<endpoint>' ? $ini_array["endpoint"] : 'https://cmq-topic-bj.api.qcloud.com';
        $this->secretId = $ini_array["secretId"] != '<secretId>' ? $ini_array["secretId"] : getenv('SECRET_ID');
        $this->secretKey = $ini_array["secretKey"] != '<secretKey>' ? $ini_array["secretKey"] : getenv('SECRET_KEY');

        $this->queueToDelete = [];

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
    }

    private function prepareQueue($queueName)
    {
        $request = new CreateQueueRequest($queueName);
        $this->queueToDelete[] = $queueName;
        try {
            $res = $this->client->createQueue($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
        return $this->client->getQueueRef($queueName);
    }

    public function testRewindEnabled()
    {
        $queueName = "testRewindEnabled";
        $queue = $this->prepareQueue($queueName);
        try {
            $request = new SetQueueAttributeRequest($queueName);
            $request->setRewindSeconds(90);

            $queue->setAttribute($request);

            $res = $queue->getAttribute();

            $this->assertTrue($res->isSucceed());
            $this->assertEquals(true, $res->getRewindEnabled());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
    }

    public function testQueueAttributes()
    {
        $queueName = "testQueueAttributes";
        $queue = $this->prepareQueue($queueName);

        try {
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($queueName, $res->getQueueName());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }

        $delaySeconds = 3;
        $request = new SetQueueAttributeRequest($queueName);
        $request->setVisibilityTimeout($delaySeconds);

        try {
            $res = $queue->setAttribute($request);
            $this->assertTrue($res->isSucceed());
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
        try {
            $res = $queue->getAttribute();
            $this->assertTrue($res->isSucceed());
            $this->assertEquals($res->getVisibilityTimeout(), $delaySeconds);
        } catch (CMQException $e) {
            $this->assertTrue(false, $e);
        }
    }
}
