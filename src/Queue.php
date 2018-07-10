<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;

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

}