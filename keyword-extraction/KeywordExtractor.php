<?php

interface KeywordExtractor
{

    public function feed($corpus_source);

    public function getAllKeywords($limit = 0);

    public function getDocumentKeywords($document_name, $limit = 0);
}