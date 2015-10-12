<?php
include (dirname(__FILE__) . "/Document.php");

class FileDocument implements Document
{

    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function getName()
    {
        return $this->filename;
    }

    /**
     * Very simple and specific version.
     * Convert encoding from UTF-8 to Cp1252
     *
     * @return the content of the document
     */
    public function getContent()
    {
        $text = file_get_contents($file);
        return mb_convert_encoding($text, "Cp1252", "UTF-8");
    }
}