<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
include 'vendor/autoload.php';

$client = new \XuTL\QCloud\Cmq\Client('https://cmq-queue-bj.api.qcloud.com','AKIDXu3xc146lAKEsHlKyMVcV8UZOwEF8Ysy','1nIZbOvDLErFNGtGOGsKYWFjxvd6JL8f');

$request = new \XuTL\QCloud\Cmq\Requests\CreateQueueRequest('test');

$response = $client->createQueue($request);

print_r($response);
