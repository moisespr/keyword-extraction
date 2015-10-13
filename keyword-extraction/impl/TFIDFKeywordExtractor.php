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
class TFIDFKeywordExtractor implements KeywordExtractor
{

    private $keywords = array();

    public function feed($corpus_source)
    {
        // stores extracted terms from the corpus by document
        $corpus_terms = array();
        // stores the calculated tf (term frequency) for each document
        $tfs = array();
        $corpus = $corpus_source->getCorpus();
        foreach ($corpus as $document) {
            $terms = $this->extractTerms($document);
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
            $this->keywords[$corpus[$i]->getName()] = $this->tfidf($corpus_terms[$i], $tfs[$i], $idf);
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
    private function tfidf($terms, $tf, $idf)
    {
        $tfidf = array();
        foreach ($terms as $term)
            $tfidf[$term] = $tf[$term] * $idf[$term];
        arsort($tfidf);
        return $tfidf;
    }

    /**
     * @see KeywordExtractor::getCommonKeywords()
     */
    public function getCommonKeywords($threshold)
    {
        // gather all keywords in the corpus
        $all_keywords = array();
        foreach ($this->keywords as $keywords)
            $all_keywords = array_merge($all_keywords, array_keys($keywords));
            
            // count how many times a keywords appears in the corpus
        $all_keywords = array_count_values($all_keywords);
        arsort($all_keywords);
        
        $common_keywords = array();
        foreach ($all_keywords as $keyword => $frequency)
            if ($frequency >= $threshold)
                $common_keywords[] = $keyword;
        
        return $common_keywords;
    }

    /**
     * @see KeywordExtractor::getDocumentKeywords()
     */
    public function getDocumentKeywords($document_name, $limit = 0)
    {
        return $limit == 0 ? $this->keywords[$document_name] : array_slice($this->keywords[$document_name], 0, $limit);
        
    }
}