# qcloud-cmq

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xutl/qcloud-cmq
```

or add

```
"xutl/qcloud-cmq": "~1.0"
```

to the require section of your `composer.json` file.

## Use

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
