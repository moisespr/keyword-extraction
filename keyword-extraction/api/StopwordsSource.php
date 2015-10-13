<?php

/**
 *
 * An interface to a list of stopwords to be used in keyword extraction.
 *
 * @author Moisés Rosa
 *
 */
interface StopwordsSource
{

    /**
     * Returns a list of stopwords.
     *
     * @return string[] a list of stopwords
     */
    public function getStopwords();
}