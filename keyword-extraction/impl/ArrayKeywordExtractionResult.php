<?php
/**
 * An implementation of KeywordExtractionResult that stores the results in an associative array.
 * 
 * @author Moisés Rosa
 *
 */
class ArrayKeywordExtractionResult implements KeywordExtractionResult {
    
    private $keywords = array();
    
    /**
     * The corpus that was analyzed
     *
     * @var CorpusSource
     */
    private $corpus_source;
    
    /**
     * Constructs an array based keyword extraction result.
     *
     * @param CorpusSource $corpus_source
     *            The corpus to be analized
     * @param string[][]string $keywords
     *            An array with document name as key and a list of keywords for that document as value
     */
    public function __construct($corpus_source, $keywords) {
        $this->corpus_source = $corpus_source;
        $this->keywords = $keywords;
    }

    /**
     * @see KeywordExtractionResult::getDocuments()
     */
    public function getCorpus() {
        return $this->corpus_source->getCorpus()->getCorpus();
    }
    
    /**
     * @see KeywordExtractionResult::getKeywords()
     */
    public function getKeywords($document_name, $limit = 0) {
        return $limit == 0 ? $this->keywords[$document_name] : array_slice($this->keywords[$document_name], 0, $limit);        
    }
}