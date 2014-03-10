<?php
namespace Makotokw\TwientBot\Storage;

class TextFileStorage extends Storage
{
    /**
     * @var string
     */
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function readFormFile($path)
    {
        return file($path);
    }

    protected function writeToFile($path, $messages)
    {
        return file_put_contents($path, trim(implode('', $messages)));
    }

    public function read()
    {
        if (file_exists($this->path)) {
            if ($messages = self::validateMessages($this->readFormFile($this->path))) {
                return $messages;
            }
        }
        return false;
    }

    public function write($messages)
    {
        return $this->writeToFile($this->path, $messages);
    }

    public function clear()
    {
        return $this->writeToFile($this->path, array());
    }
}
