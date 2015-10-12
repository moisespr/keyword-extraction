<?php
include (dirname(__FILE__) . "../api/KeywordExtractor.php");

/**
 * Keyword extractor implementing the tf-idf method.
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

    private $keywords = array(
        array()
    );

    public function feed($corpus_source)
    {
        $corpus_terms = array();
        $tfs = array();
        $corpus = $corpus_source->getCorpus();
        foreach ($corpus as $document) {
            $terms = $this->extractTerms($document);
            $tf = array_count_values($terms);
            $corpus_terms[] = $terms;
            $tfs[] = $tf;
        }
        
        $df = $this->df($tfs);
        $tfs_count = count($tfs);
        $idf = $this->idf($tfs_count, $df);
        
        for ($i = 0; $i < $tfs_count; $i ++)
            $this->keywords[$corpus[$i]->getName()] = $this->tfidf($corpus_terms[$i], $tfs[$i], $idf);
    }

    private function extractTerms($document)
    {
        $text = $document->getContent();
        $text = preg_replace("/[^a-zA-Z0-9'\"]/", " ", $text);
        $terms = preg_split("/\s/", $text);
        return array_filter($terms);
    }

    private function df($tfs)
    {
        $idf = array();
        foreach ($tfs as $tf)
            foreach ($tf as $term => $frequency) {
                if (! array_key_exists($term, $idf))
                    $idf[$term] = 0;
                $idf[$term] ++;
            }
        asort($idf);
        return $idf;
    }

    private function idf($n, $df)
    {
        $idf = array();
        foreach ($df as $term => $frequency)
            $idf[$term] = log($n / $frequency);
        return $idf;
    }

    private function tfidf($terms, $tf, $idf)
    {
        $tfidf = array();
        foreach ($terms as $term)
            $tfidf[$term] = $tf[$term] * $idf[$term];
        asort($tfidf);
        return $tfidf;
    }

    public function getCommonKeywords($threshold, $limit = 0)
    {
        $all_keywords = array();
        foreach ($this->keywords as $document => $keywords)
            array_merge($all_keywords, array_keys($keywords));
        
        array_count_values($all_keywords);
        $common_keywords = array();
        foreach ($all_keywords as $keyword) {
            
        }
        return $common_keywords;
    }

    public function getDocumentKeywords($document_name, $limit = 0);
}