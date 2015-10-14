<?php
/**
 * The result of a keyword extraction process.
 * 
 * @author Moisés Rosa
 *
 */
interface KeywordExtractionResult {
    
    /**
     * All the documents involved in the keyword extraction
     */
    public function getCorpus();
    
    /**
     * Get the keywords in a given document
     *
     * @param string $document_name
     *            Document that contains the keywords
     * @param number $limit
     *            How many keywords are returned, 0 is the default value and means all keywords
     */
    public function getKeywords($document_name, $limit = 0);
    
}