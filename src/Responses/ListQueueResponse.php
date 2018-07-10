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
    public $totalCount;

    public $queueList;
}
