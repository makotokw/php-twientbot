<?php
require_once __DIR__ . '/bootstrap.php';

use Makotokw\TwientBot\Bot;

try {
    $flags = new donatj\Flags();

    $flags->string('executed-at', '');
    $flags->string('timezone', '');
    $flags->parse();

    $command = $flags->arg(0);
    switch ($command) {
        case 'tweet':
        case 'post':
            $screenName = $flags->arg(1);
            if (empty($screenName)) {
                throw new \Exception("Usage: bot.php tweet screen-name");
            }
            $bot = createBot($screenName);

            $option = $flags->longs();
            if ($option['executed-at'] != '') {
                $executedOn = explode(',', $option['executed-at']);
                $timeZone = ($option['timezone'] != '') ? new DateTimeZone($option['timezone']) : null;
                $now = new DateTime('now', $timeZone);
                $nowHour = $now->format('H');

                if (!in_array($nowHour, $executedOn) && !in_array(intval($nowHour), $executedOn)) {
                    exit;
                }
            }

            $s = $bot->randomPost();
            if (is_array($s)) {
                echo sprintf('https://twitter.com/%s/status/%s', $s['user']['screen_name'], $s['id_str']) . PHP_EOL;
            }
            break;

        case 'cache:clear':
            $screenName = $flags->arg(1);
            if (empty($screenName)) {
                throw new \Exception("Usage: bot.php cache:clear screen-name");
            }
            $bot = createBot($screenName);
            $bot->clearCache();
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

function createBot($screenName)
{
    $upperScreenName = strtoupper($screenName);
    $userToken = getenv($upperScreenName . '_TOKEN');
    $userSecret = getenv($upperScreenName . '_SECRET');

    if (empty($userToken) || empty($userSecret)) {
        throw new \Exception("undefined {$upperScreenName}_TOKEN or {$upperScreenName}_SECRET");
    }

    $bot = new Bot(APP_CONSUMER_KEY, APP_CONSUMER_SECRET);
    $bot->setDataDir(__DIR__ . '/data/');
    if (defined('REDIS_URL')) {
        $bot->setRedisUrl(REDIS_URL);
    }
    $bot->setUser($screenName, $userToken, $userSecret);

    return $bot;
}
