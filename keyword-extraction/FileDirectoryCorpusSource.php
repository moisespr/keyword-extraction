<?php
include (dirname(__FILE__) . "/CorpusSource.php");

class FileDirectoryCorpusSource implements CorpusSource
{

    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function getCorpus()
    {
        $scanned_directory = array_diff(scandir($this->directory), array(
            '..',
            '.'
        ));
        $corpus = array();
        foreach ($scanned_directory as $file)
            $corpus[] = new FileDocument($file);
        return $corpus;
    }
}