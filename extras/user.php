<?php
require_once __DIR__ . '/../bootstrap.php';

use Twient\Twitter\V1dot1 as Twitter;

ini_set('xdebug.var_display_max_depth', 10);

try {
    $flags = new donatj\Flags();
    $flags->parse();
    $screenName = $flags->arg(0);

    $twitter = new Twitter();
    $twitter->oAuth(APP_CONSUMER_KEY, APP_CONSUMER_SECRET, USER_TOKEN, USER_SECRET);

    $user = $twitter->usersShow(array('screen_name' => $screenName));

    var_dump($user);

} catch (Exception $e) {
    echo $e . PHP_EOL;
}
