<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Requests;

use XuTL\QCloud\Cmq\Http\BaseRequest;

/**
 * Class DeleteQueueRequest
 * @package XuTL\QCloud\Cmq\Requests
 */
class DeleteQueueRequest extends BaseRequest
{
    /**
     * CreateQueueRequest constructor.
     * @param string $queueName
     */
    public function __construct($queueName)
    {
        parent::__construct('DeleteQueue');
        $this->setQueueName($queueName);
    }

    /**
     * 设置队列名称
     * @param string $queueName
     * @return BaseRequest
     */
    public function setQueueName($queueName)
    {
        $this->setParameter('queueName', $queueName);
        return $this;
    }
}
