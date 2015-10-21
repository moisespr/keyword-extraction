<?php

/**
 * Keyword extractor implementing the tf-idf (term frequency-inverse document frequency) method.
 *
 * This implementation is based on the wikipedia article.
 *
 * @link https://en.wikipedia.org/wiki/Tf-idf
 *      
 * @author Moisés Rosa
 *        
 */
class TFIDF implements KeywordExtractionAlgorithm
{

    /**
     * The result of this extraction will be an ArrayKeywordExtractionResult
     *
     * @see KeywordExtractionAlgorithm::extract()
     */
    public function extract($corpus_source, $stopwords_source = NULL)
    {
        $keywords = array();
        // stores extracted terms from the corpus by document
        $corpus_terms = array();
        // stores the calculated tf (term frequency) for each document
        $tfs = array();
        $corpus = $corpus_source->getCorpus();
        foreach ($corpus as $document) {
            $terms = $this->extractTerms($document);
            // remove all stopwords if a source is provided
            if ($stopwords_source != NULL)
                $terms = $this->removeStopwords($terms, $stopwords_source->getStopwords());
                // do the counting
            $tf = array_count_values($terms);
            $corpus_terms[] = $terms;
            $tfs[] = $tf;
        }
        // calculate the df (document frequency)
        $df = $this->df($tfs);
        // N - how many documents are we dealing with?
        $tfs_count = count($tfs);
        // calcualtes de idf (inverse document frequency)
        $idf = $this->idf($tfs_count, $df);
        
        // for each document lets calculate the tf-idf and store the keywords by document name
        for ($i = 0; $i < $tfs_count; $i ++)
            $keywords[$corpus[$i]->getName()] = $this->calcTfidf($corpus_terms[$i], $tfs[$i], $idf);
        
        return new ArrayKeywordExtractionResult($corpus_source, $keywords);
    }

    private function removeStopwords($terms, $stopwords)
    {
        return array_filter(array_map(function ($term) use($stopwords)
        {
            return in_array(strtolower($term), $stopwords) ? "" : $term;
        }, $terms));
    }

    /**
     * Extracts the terms from this document.
     *
     * @param Document $document            
     * @return string[] The terms extracted from the document
     */
    private function extractTerms($document)
    {
        $text = $document->getContent();
        // replace everything that is not a letter, a number or quotes for a whitespace
        $text = preg_replace("/[^a-zA-Z0-9'\"]/", " ", $text);
        // tokenize separating terms by whitespaces
        $terms = preg_split("/\s/", $text);
        // do an array_filter to get rid of blank words
        return array_filter($terms);
    }

    /**
     * Counts how many times a term appears in the corpus.
     *
     * @param string[]string[]number $tfs
     *            All terms frequencies by document
     * @return string[]number How many times a term appears in the corpus.
     */
    private function df($tfs)
    {
        $idf = array();
        foreach ($tfs as $tf)
            foreach ($tf as $term => $frequency) {
                if (! array_key_exists($term, $idf))
                    $idf[$term] = 0;
                $idf[$term] ++;
            }
        arsort($idf);
        return $idf;
    }

    /**
     * Calculates the idf (inverse document frequency) for each term.
     *
     * The formula is: log(N/frequency)
     *
     * @param number $n
     *            The number of documents in the corpus
     * @param string[]number $df
     *            How many times a term appears in the corpus.
     * @return string[]number All terms of the corpus with its calculated idf.
     */
    private function idf($n, $df)
    {
        $idf = array();
        foreach ($df as $term => $frequency)
            $idf[$term] = log($n / $frequency);
        return $idf;
    }

    /**
     * Calculates the td-idf (term frequency-inverse document frequency) for each term.
     *
     * @param string[] $terms
     *            List of terms in a given document.
     * @param string[]number $tf
     *            Term frequency, how many times a term appears in the document.
     * @param string[]number $idf
     *            All terms of the corpus with its calculated idf.
     * @return string[]number All terms of the corpus with its calculated tf-idf sorted by the score.
     */
    private function calcTfidf($terms, $tf, $idf)
    {
        $tfidf = array();
        foreach ($terms as $term)
            $tfidf[$term] = $tf[$term] * $idf[$term];
        arsort($tfidf);
        return $tfidf;
    }
}