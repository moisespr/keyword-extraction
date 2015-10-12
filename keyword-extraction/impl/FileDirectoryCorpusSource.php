<?php
include (dirname(__FILE__) . "../api/CorpusSource.php");

/**
 * A corpus source that reads documents from files in a directory.
 *
 * The Documents are instances of FileDocument.
 *
 * @author Moisés Rosa
 *        
 */
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