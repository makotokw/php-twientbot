<?php
namespace Makotokw\TwientBot\Storage;

/**
 * Class Storage
 * @package Makotokw\TwientBot\Storage
 */
abstract class Storage
{
    /**
     * @return mixed
     */
    abstract public function read();

    /**
     * @param array $messages
     * @return mixed
     */
    abstract public function write($messages);

    /**
     * @return mixed
     */
    abstract public function clear();

    public function dump()
    {
        echo json_encode($this->read());
    }

    /**
     * @param array $messages
     * @return array
     */
    public static function optimizeMessages(array $messages)
    {
        return array_filter(
            $messages,
            function ($s) {
                return !empty(trim($s));
            }
        );
    }

    /**
     * @param $messages
     * @return array|bool
     */
    public static function validateMessages($messages)
    {
        if (!is_array($messages)) {
            return false;
        }
        $messages = self::optimizeMessages($messages);
        if (empty($messages)) {
            return false;
        }
        return $messages;
    }
}
