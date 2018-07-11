<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;

use XuTL\QCloud\Cmq\Http\BaseRequest;

/**
 * Class SetTopicAttributeRequest
 * @package XuTL\QCloud\Cmq\Requests
 */
class SetTopicAttributeRequest extends BaseRequest
{
    /**
     * SetTopicAttributeRequest constructor.
     */
    public function __construct()
    {
        parent::__construct('SetTopicAttributes');
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

    /**
     * 消息最大长度。取值范围1024-65536 Byte（即 1-64K），默认值 65536。
     * @param int $maxMsgSize
     * @return BaseRequest
     */
    public function setMaxMsgSize($maxMsgSize)
    {
        $this->setParameter('maxMsgSize', $maxMsgSize);
        return $this;
    }


}
