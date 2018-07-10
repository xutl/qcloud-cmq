<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;


use XuTL\QCloud\Cmq\Http\BaseRequest;

class GetTopicAttributeRequest extends BaseRequest
{
    /**
     * BatchPublishMessageRequest constructor.
     * @param string $topicName
     */
    public function __construct($topicName)
    {
        parent::__construct('GetTopicAttributes');
        $this->setTopicName($topicName);
    }

    /**
     * 设置主题名称
     * @param string $topicName
     * @return BaseRequest
     */
    public function setTopicName($topicName)
    {
        $this->setParameter('topicName', $topicName);
        return $this;
    }

}
