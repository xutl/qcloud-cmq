<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Responses;

use Psr\Http\Message\ResponseInterface;
use XuTL\QCloud\Cmq\Exception\CMQMessageNotExistException;
use XuTL\QCloud\Cmq\Exception\CMQServerException;
use XuTL\QCloud\Cmq\Exception\CMQServerNetworkException;
use XuTL\QCloud\Cmq\Http\BaseResponse;
use XuTL\QCloud\Cmq\Model\Message;

/**
 * Class BatchReceiveMessageResponse
 * @package XuTL\QCloud\Cmq\Responses
 */
class BatchReceiveMessageResponse extends BaseResponse
{
    /**
     * @var Message[]
     */
    protected $messages;

    /**
     * @var array
     */
    protected $msgInfoList;


    /**
     * 解析响应
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function unwrapResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() != 200) {
            throw new CMQServerNetworkException($response->getStatusCode(), $response->getHeaders(), $response->getBody()->getContents());
        }
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if ($content['code'] != 0) {
            $this->succeed = false;
            if ($content['code'] == 7000) {
                throw new CMQMessageNotExistException($content['message'],  $content['code'], $content);
            } else {
                throw new CMQServerException($content['message'], $content['requestId'] ?? '', $content['code'], $content);
            }

        }
        $this->succeed = true;
        foreach ($content as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            } else {
                $this->_content[$name] = $value;
            }
        }

        foreach ($this->msgInfoList as $msg) {
            $this->messages[] = new Message($msg['msgId'], $msg['msgBody'], $msg['enqueueTime'], $msg['nextVisibleTime'], $msg['firstDequeueTime'], $msg['dequeueCount'], $msg['receiptHandle']);
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
