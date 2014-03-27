<?php
$loader = require_once __DIR__ . '/vendor/autoload.php';

foreach (array(
             'APP_CONSUMER_KEY',
             'APP_CONSUMER_SECRET',
             'USER_TOKEN',
             'USER_SECRET'
         ) as $key) {
    if (!defined($key)) {
        define($key, getenv($key));
    }
}

if (empty(APP_CONSUMER_KEY)) {
    die ('APP_CONSUMER_KEY is undefined');
}
if (empty(APP_CONSUMER_SECRET)) {
    die ('APP_CONSUMER_SECRET is undefined');
}

if (!defined('REDIS_URL')) {
    if (getenv('REDIS_URL')) {
        define('REDIS_URL', getenv('REDIS_URL'));
    } elseif (getenv('REDISTOGO_URL')) {
        define('REDIS_URL', getenv('REDISTOGO_URL'));
    } elseif (getenv('REDISCLOUD_URL')) {
        define('REDIS_URL', getenv('REDISCLOUD_URL'));
    } else {
        define('REDIS_URL', '');
    }
}
