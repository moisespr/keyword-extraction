<?php
/**
 * Very simple and specific file version of a document.
 *
 * Convert encoding from UTF-8 to Cp1252.
 *
 * @author Moisés Rosa
 */
class FileDocument implements Document
{

    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function getName()
    {
        return basename($this->filename);
    }

    public function getContent()
    {
        $text = file_get_contents($this->filename);
        return mb_convert_encoding($text, "Cp1252", "UTF-8");
    }
}