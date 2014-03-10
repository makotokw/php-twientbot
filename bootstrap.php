<?php
$loader = require_once __DIR__ . '/vendor/autoload.php';

define('APP_CONSUMER_KEY', getenv('APP_CONSUMER_KEY'));
define('APP_CONSUMER_SECRET', getenv('APP_CONSUMER_SECRET'));

define('USER_TOKEN', getenv('USER_TOKEN'));
define('USER_SECRET', getenv('USER_SECRET'));

if (empty(APP_CONSUMER_KEY)) {
    die ('APP_CONSUMER_KEY is undefined');
}
if (empty(APP_CONSUMER_SECRET)) {
    die ('APP_CONSUMER_SECRET is undefined');
}

if (getenv('REDIS_URL')) {
    define('REDIS_URL', getenv('REDIS_URL'));
} elseif (getenv('REDISTOGO_URL')) {
    define('REDIS_URL', getenv('REDISTOGO_URL'));
} elseif (getenv('REDISCLOUD_URL')) {
    define('REDIS_URL', getenv('REDISCLOUD_URL'));
} else {
    define('REDIS_URL', '');
}
