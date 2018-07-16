<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * 创建队列响应
 * @package XuTL\QCloud\Cmq\Responses
 */
class CreateQueueResponse extends BaseResponse
{
    /**
     * @var string
     */
    public $queueName;

    /**
     * @var string
     */
    public $queueId;

    /**
     * CreateQueueResponse constructor.
     * @param string $queueName
     */
    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @return string
     */
    public function getQueueId()
    {
        return $this->queueId;
    }
}
