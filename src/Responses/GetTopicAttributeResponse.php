<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use XuTL\QCloud\Cmq\Http\BaseResponse;

class GetTopicAttributeResponse extends BaseResponse
{
    /**
     * @var string
     */
    public $topicName;

    /**
     * @var int
     */
    public $maxMsgSize;

    /**
     * CreateQueueRequest constructor.
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        $this->topicName = $topicName;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * @return int
     */
    public function getMaxMsgSize()
    {
        return $this->maxMsgSize;
    }
}
