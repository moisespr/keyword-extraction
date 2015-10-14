<?php
include (dirname(__FILE__) . "/../autoloader.php");

class TFIDFKeywordExtractorTest extends PHPUnit_Framework_TestCase
{

    public function testCorpusSource()
    {
        $corpus_source = new FileDirectoryCorpusSource(dirname(__FILE__) . "/texts");
        $corpus = $corpus_source->getCorpus();
        $this->assertCount(3, $corpus);
        return $corpus_source;
    }

    /**
     * @depends testCorpusSource
     */
    public function testExtractor($corpus_source)
    {
        $extractor = new KeywordExtractor(new TFIDF(), $corpus_source);
        $extraction_result = $extractor->extract();
        $keywords = $extraction_result->getKeywords("post1.txt");
        
        $this->assertCount(365, $keywords);
        $keywords = $extraction_result->getKeywords("post1.txt", 5);
        $this->assertArrayHasKey('PC', $keywords);
        $this->assertArrayHasKey('CPU', $keywords);
        $this->assertArrayHasKey('Part', $keywords);
        $this->assertArrayHasKey('Building', $keywords);
        $this->assertArrayHasKey('SSD', $keywords);
        
        $keywords = $extraction_result->getKeywords("post2.txt");
        
        $this->assertCount(592, $keywords);
        $keywords = $extraction_result->getKeywords("post2.txt", 5);
        $this->assertArrayHasKey('monitor', $keywords);
        $this->assertArrayHasKey('4K', $keywords);
        $this->assertArrayHasKey('monitors', $keywords);
        $this->assertArrayHasKey('It', $keywords);
        $this->assertArrayHasKey('DisplayPort', $keywords);
        
        $keywords = $extraction_result->getKeywords("post3.txt");
        
        $this->assertCount(718, $keywords);
        $keywords = $extraction_result->getKeywords("post3.txt", 5);
        $this->assertArrayHasKey('router', $keywords);
        $this->assertArrayHasKey('HTTPS', $keywords);
        $this->assertArrayHasKey('could', $keywords);
        $this->assertArrayHasKey('right', $keywords);
        $this->assertArrayHasKey('firmware', $keywords);
    }
}