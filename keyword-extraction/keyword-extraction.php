<?php
/*
 * - ser flexível no source de textos
 * - ser flexível no algoritmo usado pra extrair as keywords
 * - ser flexível nas ações tomadas com os resultados
 */
function extractTerms($file)
{
    $text = file_get_contents($file);
    $text = mb_convert_encoding($text, 'Cp1252', "UTF-8");
    $text = preg_replace("/[^a-zA-Z0-9'\"]/", " ", $text);
    $words = preg_split("/\s/", $text);
    return array_filter($words);
}

function df($tfs)
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

function idf($n, $df)
{
    $idf = array();
    foreach ($df as $term => $frequency)
        $idf[$term] = log($n / $frequency);
    return $idf;
}

function tfidf($terms, $tf, $idf)
{
    $tfidf = array();
    foreach ($terms as $term)
        $tfidf[$term] = $tf[$term] * $idf[$term];
    asort($tfidf);
    return $tfidf;
}

$t1 = extractTerms("texts/post1.txt");
$t2 = extractTerms("texts/post2.txt");
$t3 = extractTerms("texts/post3.txt");

$tf1 = array_count_values($t1);
$tf2 = array_count_values($t2);
$tf3 = array_count_values($t3);

$tfs = [
    $tf1,
    $tf2,
    $tf3
];
$df = df($tfs);

$idf = idf(count($tfs), $df);

print_r(tfidf($t1, $tf1, $idf));
print_r(tfidf($t2, $tf2, $idf));
print_r(tfidf($t3, $tf3, $idf));

//echo $term . " => " . ($tf[$term] * $idf[$term])."\n";