<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;

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
