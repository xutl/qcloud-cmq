<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * Class ListTopicResponse
 * @package XuTL\QCloud\Cmq\Responses
 */
class ListTopicResponse extends BaseResponse
{
    /**
     * @var int
     */
    public $totalCount;

    /**
     * @var array
     */
    public $topicList;

    /**
     * 获取主题列表
     * @return array
     */
    public function getTopicList()
    {
        return $this->topicList;
    }

    /**
     * 获取队列Id
     * @return array
     */
    public function getTopicIds()
    {
        $topicIds = [];
        foreach ($this->topicList as $topic) {
            $topicIds[] = $topic['topicId'];
        }
        return $topicIds;
    }

    /**
     * 获取队列名称
     * @return array
     */
    public function getTopicNames()
    {
        $topicNames = [];
        foreach ($this->topicList as $topic) {
            $topicNames[] = $topic['topicName'];
        }
        return $topicNames;
    }
}
