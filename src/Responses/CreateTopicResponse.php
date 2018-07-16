<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * 创建主题响应
 * @package XuTL\QCloud\Cmq\Responses
 */
class CreateTopicResponse extends BaseResponse
{
    /**
     * @var string
     */
    public $topicId;

    /**
     * @var string
     */
    public $topicName;

    /**
     * CreateTopicResponse constructor.
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
     * @return string
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

}
