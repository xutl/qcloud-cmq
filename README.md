# qcloud-cmq

```php
use XuTL\QCloud\Cmq\Client;

$client = new Client('https://cmq-queue-bj.api.qcloud.com','abcdedgasdf','abcdedgasdf');
$request = new \XuTL\QCloud\Cmq\Requests\ListTopicRequest();
try {
    $response = $client->listTopic($request);
    print_r($response);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```
