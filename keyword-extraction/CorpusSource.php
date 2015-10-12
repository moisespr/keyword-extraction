<?php

interface CorpusSource
{

    /**
     * Returns
     *
     * @return Document[] list of documents to be used as the source for keyword extraction
     */
    public function getCorpus();
}