<?php
include (dirname(__FILE__) . "../api/Document.php");

/**
 * Very simple and specific file version of a document.
 *
 * Convert encoding from UTF-8 to Cp1252
 *
 * @author Mois�s Rosa
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
        return $this->filename;
    }

    public function getContent()
    {
        $text = file_get_contents($file);
        return mb_convert_encoding($text, "Cp1252", "UTF-8");
    }
}