<?php

namespace XuTL\QCloud\Cmq\Tests;

use XuTL\QCloud\Cmq\Client;
use XuTL\QCloud\Cmq\Exception\CMQException;
use XuTL\QCloud\Cmq\Requests\CreateQueueRequest;

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

        $this->endPoint = $ini_array["endpoint"];
        $this->secretId = $ini_array["secretId"];
        $this->secretKey = $ini_array["secretKey"];

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

}
