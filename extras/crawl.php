<?php
require_once __DIR__ . '/../bootstrap.php';

use Twient\Twitter\V1dot1 as Twitter;

try {
    $flags = new donatj\Flags();
    $flags->parse();
    $screenName = $flags->arg(0);

    $twitter = new Twitter();
    $twitter->oAuth(APP_CONSUMER_KEY, APP_CONSUMER_SECRET, USER_TOKEN, USER_SECRET);

    $messages = array();

    // https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
    $maxId = null;
    $numberOfTweets = 200;

    $loopCount = 0;

    // Requests per rate limit window	180/user, 300/app in 15 minutes
    $maxLoopCount = 180;

    while ($loopCount < $maxLoopCount) {

        $params = array(
            'screen_name' => $screenName,
            'count'       => $numberOfTweets,
        );
        if (isset($maxId)) {
            $params['max-id'] = $maxId;
        }
        $statuses = $twitter->statusesUserTimeline($params);

        foreach ($statuses as $s) {
            $messages[] = $s['text'];
//            echo sprintf('%s %s', $s['id_str'], $s['text']) . PHP_EOL;
        }
        if (count($statuses) < $numberOfTweets) {
            break;
        }

        $s = array_pop($statuses);

        $maxId = $s['id_str'];

        $loopCount++;

        echo '.';
    }

    $messages = array_unique($messages);
    sort($messages);

    $fh = fopen(__DIR__ . "/../data/${$screenName}.txt", 'w');
    foreach ($messages as $m) {
        fwrite($fh, $m . PHP_EOL);
    }
    fclose($fh);

} catch (Exception $e) {
    echo $e . PHP_EOL;
}
