# qcloud-cmq

这个SDK和阿里云的MNS通用，直接可切换,
支持 同步 异步模式。

[![Build Status](https://travis-ci.org/xutl/qcloud-cmq.svg?branch=master)](https://travis-ci.org/xutl/qcloud-cmq)

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
