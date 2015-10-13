<?php

/**
 * An interface to keyword extractors.
 * 
 * @author Moisés Rosa
 *
 */
interface KeywordExtractor
{

    /**
     * Feed the extractor with a corpus of texts.
     *
     * Implementations should do the keyword computation at this point.
     *
     * @param CorpusSource $corpus_source
     *            The corpus to be analized
     */
    public function feed($corpus_source);

    /**
     * Get a list of keywords that appears in the corpus with a frequency larger than or equal $threshold.
     *
     * @param number $threshold
     *            Threshold to the frequency a keyword appears in the corpus
     * @param number $limit
     *            How many keywords are needed, 0 is the default value and means all keywords
     */
    public function getCommonKeywords($threshold);

    /**
     * Get the keywords in a given document sorted by frequency
     *
     * @param string $document_name
     *            Document that contains the keywords
     * @param number $limit
     *            How many keywords are needed, 0 is the default value and means all keywords
     */
    public function getDocumentKeywords($document_name, $limit = 0);
}