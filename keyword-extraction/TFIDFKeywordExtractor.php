<?php
include (dirname(__FILE__) . "/KeywordExtractor.php");

/**
 * Keyword extractor implementing the tf-idf method.
 *
 * This implementation is based on the wikipedia article.
 *
 * @link https://en.wikipedia.org/wiki/Tf-idf
 *      
 * @author Moises
 *        
 */
class TFIDFKeywordExtractor implements KeywordExtractor
{
	private $keywords = array(array());
	
	public function feed($corpus_source) {
		$corpus = $corpus_source->getCorpus();
		$tfs = array();
		foreach($corpus as $document) {
			$terms = extractTerms($document);
			
			$tf = array_count_values($terms);
			
			$tfs[] = $tf;
		}

		$df = df($tfs);
			
		$idf = idf(count($tfs), $df);
			
		print_r(tfidf($t1, $tf1, $idf));
	}
	
	private function extractTerms($document) {
        $text = $document->getContent();
        $text = preg_replace("/[^a-zA-Z0-9'\"]/", " ", $text);
        $terms = preg_split("/\s/", $text);
        return array_filter($terms);
	}
	
	public function getAllKeywords($limit = 0) {
		return $keywords;
	}
	
	public function getDocumentKeywords($document_name, $limit = 0);
}