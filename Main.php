<?php
include 'app/ProcessCSV.php';
include 'app/algorithm.php';

$processCsv = new ProcessCSV();
$options = getopt("f:");
$file = $options['f'] ?? null;

// Step 1: load CSV file in memory
if (empty($file) || !is_file($file)) {
    echo 'Invalid CSV File';
    exit;
}
$data = $processCsv->init($file)->getRawContent();

// Step 2: prompt questions and collect answers
$answerA = $processCsv->question('A');
$answerB = $processCsv->question('B');

list($dist, $path) = $processCsv->processRequest($data, $answerA, $answerB);
echo $processCsv->printMessage($dist, $path, $answerA, $answerB);
exit;
