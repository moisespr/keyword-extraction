<?php
/**
 * A keyword extraction algorithm. 
 * 
 * @author Moisés Rosa
 *
 */
interface KeywordExtractionAlgorithm {

    /**
     * Extracts the keywords from the provided corpus
     * 
     * @param CorpusSource $corpus_source
     * @param StopwordsSource $stopwords_source
     * 
     * @return KeywordExtractionResult The result of the extraction
     */
    public function extract($corpus_source, $stopwords_source = NULL);
    
}