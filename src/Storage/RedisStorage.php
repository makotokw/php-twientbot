<?php
namespace Makotokw\TwientBot\Storage;

class RedisStorage extends Storage
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * @param string $redisUrl
     * @param string $key
     */
    public function __construct($redisUrl, $key)
    {
        $this->host = parse_url($redisUrl, PHP_URL_HOST);
        $this->port = parse_url($redisUrl, PHP_URL_PORT);
        $this->password = parse_url($redisUrl, PHP_URL_PASS);
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function connect()
    {
        $ret = false;
        if (class_exists('Redis')) {
            $this->redis = new \Redis();
            if ($this->redis->connect($this->host, $this->port)) {
                if (empty($this->password)) {
                    $ret = true;
                } else {
                    $ret = $this->redis->auth($this->password);
                }
            }
        }
        return $ret;
    }

    public function read()
    {
        if ($messages = self::validateMessages(@unserialize($this->redis->get($this->key)))) {
            return $messages;
        }
        return false;
    }

    public function write($messages)
    {
        $this->redis->set($this->key, serialize($messages));
        return true;
    }

    public function clear()
    {
        $this->redis->set($this->key, null);
    }
}
