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
    public $topicName;

    public $maxMsgSize;

    /**
     * CreateQueueRequest constructor.
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        $this->topicName = $topicName;
    }

    public function getTopicName()
    {
        return $this->topicName;
    }

    public function getMaxMsgSize()
    {
        return $this->maxMsgSize;
    }
}
