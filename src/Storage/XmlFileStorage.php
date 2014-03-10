<?php
namespace Makotokw\TwientBot\Storage;

class XmlFileStorage extends TextFileStorage
{
    protected function readFormFile($path)
    {
        $messages = array();
        $xml = new \SimpleXMLElement(file_get_contents($path));
        if ($result = $xml->xpath('/list/item')) {
            while (list(, $node) = each($result)) {
                $text = trim((string)$node);
                if (!empty($text)) {
                    $messages[] = $text;
                }
            }
        }

        return $messages;
    }

    protected function writeToFile($path, $messages)
    {
        $dom = new \DomDocument('1.0', 'UTF-8');
        $list = $dom->appendChild($dom->createElement('list'));
        foreach ($messages as $message) {
            $item = $list->appendChild($dom->createElement('item'));
            $item->appendChild($dom->createTextNode($message));
        }
        $dom->formatOutput = true;
        $dom->save($path);
    }
}
