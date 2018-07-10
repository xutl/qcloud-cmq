<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;
use XuTL\QCloud\Cmq\Requests\GetQueueAttributeRequest;
use XuTL\QCloud\Cmq\Requests\PeekMessageRequest;
use XuTL\QCloud\Cmq\Requests\ReceiveMessageRequest;
use XuTL\QCloud\Cmq\Requests\SendMessageRequest;
use XuTL\QCloud\Cmq\Requests\SetQueueAttributeRequest;
use XuTL\QCloud\Cmq\Responses\GetQueueAttributeResponse;
use XuTL\QCloud\Cmq\Responses\ReceiveMessageResponse;
use XuTL\QCloud\Cmq\Responses\SendMessageResponse;
use XuTL\QCloud\Cmq\Responses\SetQueueAttributeResponse;

/**
 * Class Queue
 * @package XuTL\QCloud\Cmq
 */
class Queue
{
    /**
     * @var string
     */
    private $queueName;

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * Queue constructor.
     * @param HttpClient $client
     * @param string $queueName
     */
    public function __construct(HttpClient $client, $queueName)
    {
        $this->queueName = $queueName;
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @param SetQueueAttributeRequest $request
     * @return Http\BaseResponse
     */
    public function setAttribute(SetQueueAttributeRequest $request)
    {
        $request->setQueueName($this->queueName);
        $response = new SetQueueAttributeResponse();
        return $this->client->sendRequest($request, $response);
    }

    /**
     * @param SetQueueAttributeRequest $request
     * @param AsyncCallback|null $callback
     * @return Http\Promise
     */
    public function setAttributeAsync(SetQueueAttributeRequest $request, AsyncCallback $callback = null)
    {
        $request->setQueueName($this->queueName);
        $response = new SetQueueAttributeResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    /**
     * @return Http\BaseResponse
     */
    public function getAttribute()
    {
        $request = new GetQueueAttributeRequest($this->queueName);
        $response = new GetQueueAttributeResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function getAttributeAsync(AsyncCallback $callback = null)
    {
        $request = new GetQueueAttributeRequest($this->queueName);
        $response = new GetQueueAttributeResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    /**
     * 向队列推送消息
     * @param SendMessageRequest $request
     * @return Http\BaseResponse
     */
    public function sendMessage(SendMessageRequest $request)
    {
        $request->setQueueName($this->queueName);
        $response = new SendMessageResponse();
        return $this->client->sendRequest($request, $response);
    }

    /**
     * 异步推送消息
     * @param SendMessageRequest $request
     * @param AsyncCallback|null $callback
     * @return Http\Promise
     */
    public function sendMessageAsync(SendMessageRequest $request, AsyncCallback $callback = null)
    {
        $request->setQueueName($this->queueName);
        $response = new SendMessageResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    public function peekMessage()
    {
        $request = new PeekMessageRequest($this->queueName);
        return $this->client->sendRequest($request, $response);
    }

    public function peekMessageAsync(AsyncCallback $callback = NULL)
    {
        $request = new PeekMessageRequest($this->queueName);
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    public function receiveMessage($waitSeconds = NULL)
    {
        $request = new ReceiveMessageRequest($this->queueName, $waitSeconds);
        $response = new ReceiveMessageResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function receiveMessageAsync(AsyncCallback $callback = NULL)
    {
        $request = new ReceiveMessageRequest($this->queueName);
        $response = new ReceiveMessageResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    public function deleteMessage($receiptHandle)
    {
        $request = new DeleteMessageRequest($this->queueName, $receiptHandle);
        $response = new DeleteMessageResponse();
        return $this->client->sendRequest($request, $response);
    }

    public function deleteMessageAsync($receiptHandle, AsyncCallback $callback = NULL)
    {
        $request = new DeleteMessageRequest($this->queueName, $receiptHandle);
        $response = new DeleteMessageResponse();
        return $this->client->sendRequestAsync($request, $response, $callback);
    }

    public function changeMessageVisibility($receiptHandle, $visibilityTimeout)
    {
        $request = new ChangeMessageVisibilityRequest($this->queueName, $receiptHandle, $visibilityTimeout);
        $response = new ChangeMessageVisibilityResponse();
        return $this->client->sendRequest($request, $response);
    }
}
