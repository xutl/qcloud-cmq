<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * Class ListQueueResponse
 * @package XuTL\QCloud\Cmq\Responses
 */
class ListQueueResponse extends BaseResponse
{
    /**
     * @var int
     */
    public $totalCount;

    /**
     * @var array
     */
    public $queueList;

    /**
     * 获取队列列表
     * @return array
     */
    public function getQueueList()
    {
        return $this->queueList;
    }

    /**
     * 获取队列Id
     * @return array
     */
    public function getQueueIds()
    {
        $queueIds = [];
        foreach ($this->queueList as $queue) {
            $queueIds[] = $queue['queueId'];
        }
        return $queueIds;
    }

    /**
     * 获取队列名称
     * @return array
     */
    public function getQueueNames()
    {
        $queueNames = [];
        foreach ($this->queueList as $queue) {
            $queueNames[] = $queue['queueName'];
        }
        return $queueNames;
    }
}
