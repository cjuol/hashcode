<?php
//---------- Processing input file ---------------------
$fileName = 'a_example.txt';
$file = fopen($fileName, 'r');

$data = array();
$data = processingFirstLine($file, $data);
$books = processingSecondLine($file);
$data = processingLibraries($file, $data, $books);
var_dump($data);
fclose($file);
//------------ Input file processed --------------------

//------------------------------------------------------
$excludedBooks = array();

firstLibrary($data['libraries'], $excludedBooks, $books);
compareBooks($data['libraries'][0]['books'], $data['libraries'][1]['books']);
//------------------------------------------------------




function firstLibrary($libraries = null, $excludedBooks = null, $books = null)
{
    if ((NULL === $libraries) || (NULL === $excludedBooks) || (NULL === $books)) return false;

    $aux = 0;
    for ($k = 0; $k < count($libraries) - 1; $k++) {
        if ($libraries[$aux]['totalPoints'] < $libraries[$k]['totalPoints']) $aux = $k;
        if ($libraries[$aux]['totalPoints'] == $libraries[$k]['totalPoints']) {
        }
    }
    var_dump($libraries[$aux]);
    return $aux;
}
function compareBooks($library1 = null, $library2 = null)
{
    if ((NULL === $library1) || (NULL === $library2)) return false;

    return array_diff($library1, $library2);
}
function processingFirstLine($file = null, $data = null)
{
    if (NULL === $file) return null;

    $line = fgets($file);
    $params = explode(' ', $line);
    $data['totalBooks'] = (int) $params[0];
    $data['totalLibraries'] = (int) $params[1];
    $data['totalDays'] = (int) $params[2];
    return $data;
}

function processingSecondLine($file = null)
{
    if (NULL === $file) return false;

    $line = fgets($file);
    $params = explode(' ', $line);
    $return = $params;
    asort($return);
    return $return;
}

function processingLibraries($file = null, $data = null, $books = null)
{
    if (NULL === $file) return false;

    $data['libraries'] = array();
    for ($k = 0; $k < $data['totalLibraries']; $k++) {
        $line = fgets($file);
        $params = explode(' ', $line);

        $data['libraries'][$k] = [
            'numberBooks' => (int) $params[0],
            'timeToLog'   => (int) $params[1],
            'booksPerDay' => (int) $params[2]
        ];

        $line = fgets($file);
        $params = explode(' ', $line);
        $data['libraries'][$k]['books'] = $params;
        $data['libraries'][$k]['totalPoints'] = (int) 0;
        foreach ($params as $book) {
            $data['libraries'][$k]['totalPoints'] = $data['libraries'][$k]['totalPoints'] + (int) $books[(int) $book];
        }
    }
    return $data;
}
