<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\HttpClient;

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
}