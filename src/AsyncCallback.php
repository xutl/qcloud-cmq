<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq;

use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * Class AsyncCallback
 * @package XuTL\QCloud\Cmq
 */
class AsyncCallback
{

    /**
     * @var callable
     */
    protected $succeedCallback;

    /**
     * @var callable
     */
    protected $failedCallback;

    /**
     * AsyncCallback constructor.
     * @param callable $succeedCallback
     * @param callable $failedCallback
     */
    public function __construct(callable $succeedCallback, callable $failedCallback)
    {
        $this->succeedCallback = $succeedCallback;
        $this->failedCallback = $failedCallback;
    }

    public function onSucceed(BaseResponse $result)
    {
        return call_user_func($this->succeedCallback, $result);
    }

    public function onFailed(Exception $e)
    {
        return call_user_func($this->failedCallback, $e);
    }
}
