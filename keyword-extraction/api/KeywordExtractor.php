<?php

/**
 * An utility class to perform keyword extraction.
 * 
 * @author Moisés Rosa
 *
 */
class KeywordExtractor
{

    /**
     * Which algorithm will be used to extract the keywords
     *
     * @var KeywordExtractionAlgorithm
     */
    private $algorithm;

    /**
     * The corpus to be analized
     *
     * @var CorpusSource
     */
    private $corpus_source;

    /**
     * A stopwords source to be used by the keyword extractor
     *
     * @var StopwordsSource
     */
    private $stopwords_source;

    /**
     * Constructs the keyword extractor.
     *
     * @param KeywordExtractionAlgorithm $algorithm
     *            Which algorithm will be used to extract the keywords
     * @param CorpusSource $corpus_source
     *            The corpus to be analized
     * @param StopwordsSource $stopwords_source
     *            A stopwords source to be used by the keyword extractor
     */
    public function __construct($algorithm, $corpus_source, $stopwords_source = NULL)
    {
        $this->algorithm = $algorithm;
        $this->corpus_source = $corpus_source;
        $this->stopwords_source = $stopwords_source;
    }

    /**
     * Performs the extraction operation and returns its results.
     * 
     * @return KeywordExtractionResult The result of the extraction
     */
    public function extract()
    {
        return $this->algorithm->extract($this->corpus_source, $this->stopwords_source);
    }
    
}