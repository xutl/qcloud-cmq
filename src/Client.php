<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;
use XuTL\QCloud\Cmq\Requests\CreateQueueRequest;
use XuTL\QCloud\Cmq\Requests\DeleteQueueRequest;
use XuTL\QCloud\Cmq\Requests\ListQueueRequest;
use XuTL\QCloud\Cmq\Responses\CreateQueueResponse;
use XuTL\QCloud\Cmq\Responses\DeleteQueueResponse;
use XuTL\QCloud\Cmq\Responses\ListQueueResponse;

/**
 * Class Client
 * @package XuTL\QCloud\Cmq
 */
class Client
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * Client constructor.
     * @param string $endPoint
     * @param string $secretId
     * @param string $secretKey
     * @param Config|null $config
     */
    public function __construct($endPoint, $secretId, $secretKey, Config $config = NULL)
    {
        $this->client = new HttpClient($endPoint, $secretId, $secretKey, $config);
    }

    /**
     * @return HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns a queue reference for operating on the queue
     * this function does not create the queue automatically.
     *
     * @param string $queueName :  the queue name
     * @return Queue $queue: the Queue instance
     */
    public function getQueueRef($queueName)
    {
        return new Queue($this->client, $queueName);
    }

    /**
     * Create Queue and Returns the Queue reference
     * @param CreateQueueRequest $request :  the QueueName and QueueAttributes
     * @return Http\BaseResponse|CreateQueueResponse
     */
    public function createQueue(CreateQueueRequest $request)
    {
        $response = new CreateQueueResponse($request->getQueueName());
        return $this->client->sendRequest($request, $response);
    }

    /**
     * Create Queue and Returns the Queue reference
     * The request will not be sent until calling MnsPromise->wait();
     *
     * @param CreateQueueRequest $request :  the QueueName and QueueAttributes
     * @param AsyncCallback $callback :  the Callback when the request finishes
     * @return Http\Promise
     */
    public function createQueueAsync(CreateQueueRequest $request, AsyncCallback $callback = null)
    {
        $response = new CreateQueueResponse($request->getQueueName());
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    /**
     * Query the queues created by current account
     *
     * @param ListQueueRequest $request : define filters for quering queues
     * @return Http\BaseResponse|ListQueueResponse
     */
    public function listQueue(ListQueueRequest $request)
    {
        $response = new ListQueueResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function listQueueAsync(ListQueueRequest $request, AsyncCallback $callback = null)
    {
        $response = new ListQueueResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    /**
     * Delete the specified queue
     * the request will succeed even when the queue does not exist
     *
     * @param $queueName : the queueName
     * @return Http\BaseResponse|DeleteQueueResponse
     */
    public function deleteQueue($queueName)
    {
        $request = new DeleteQueueRequest($queueName);
        $response = new DeleteQueueResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function deleteQueueAsync($queueName, AsyncCallback $callback = NULL)
    {
        $request = new DeleteQueueRequest($queueName);
        $response = new DeleteQueueResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    /**
     * Returns a topic reference for operating on the topic
     * this function does not create the topic automatically.
     *
     * @param string $topicName :  the topic name
     * @return Topic $topic: the Topic instance
     */
    public function getTopicRef($topicName)
    {
        return new Topic($this->client, $topicName);
    }
}
