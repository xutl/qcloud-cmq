<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use XuTL\QCloud\Cmq\Exception\Exception;
use XuTL\QCloud\Cmq\Http\BaseResponse;

/**
 * Class CreateQueueResponse
 * @package XuTL\QCloud\Cmq\Responses
 */
class CreateQueueResponse extends BaseResponse
{
    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        $this->statusCode = $response->getStatusCode();
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if ($this->statusCode != 200) {
            $this->succeed = false;
            $this->parseErrorResponse($this->statusCode, $content);
            return;
        } else {
            $this->succeed = true;

        }
    }

    public function parseErrorResponse($statusCode, $content, Exception $exception = null)
    {
        if ($content['code'] == Constants::INVALID_ARGUMENT)
        {
            throw new InvalidArgumentException($statusCode, $result['Message'], $exception, $result['Code'], $result['RequestId'], $result['HostId']);
        }
        if ($content['Code'] == Constants::QUEUE_ALREADY_EXIST)
        {
            throw new QueueAlreadyExistException($statusCode, $result['Message'], $exception, $result['Code'], $result['RequestId'], $result['HostId']);
        }
        throw new MnsException($statusCode, $result['Message'], $exception, $result['Code'], $result['RequestId'], $result['HostId']);
    }
}
