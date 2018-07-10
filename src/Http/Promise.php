<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace XuTL\QCloud\Cmq\Http;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Promise
 * @package XuTL\QCloud\Cmq\Http
 */
class Promise
{
    /**
     * @var BaseResponse
     */
    private $response;

    /**
     * @var PromiseInterface
     */
    private $promise;

    private $httpClient;

    /**
     * Promise constructor.
     * @param PromiseInterface $promise
     * @param BaseResponse $response
     */
    public function __construct(PromiseInterface &$promise, BaseResponse &$response)
    {
        $this->promise = $promise;
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->promise->getState() != 'pending';
    }

    /**
     * @return BaseResponse
     */
    public function getResponse()
    {
        return $this->response;
    }


    public function wait()
    {
        try {
            $res = $this->promise->wait();
            if ($res instanceof ResponseInterface) {
                $this->response->parseResponse($res->getStatusCode(), $res->getBody());
            }
        } catch (TransferException $e) {
            $message = $e->getMessage();
            if ($e->hasResponse()) {
                $message = $e->getResponse()->getBody();
            }
            $this->response->parseErrorResponse($e->getCode(), $message);
        }
        return $this->response;
    }
}
