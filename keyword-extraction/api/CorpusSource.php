<?php

/**
 * An interface to a source of corpus of documents to be used as the source for keyword extraction.
 * 
 * @author Moisés Rosa
 *
 */
interface CorpusSource
{

    /**
     * Returns a corpus of documents.
     *
     * @return Document[] list of documents to be used as the source for keyword extraction
     */
    public function getCorpus();
}