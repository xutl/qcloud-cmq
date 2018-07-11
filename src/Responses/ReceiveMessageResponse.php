<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use XuTL\QCloud\Cmq\Http\BaseResponse;
use XuTL\QCloud\Cmq\Traits\MessagePropertiesForReceive;

/**
 * Class ReceiveMessageResponse
 * @package XuTL\QCloud\Cmq\Responses
 */
class ReceiveMessageResponse extends BaseResponse
{
    use MessagePropertiesForReceive;
}
