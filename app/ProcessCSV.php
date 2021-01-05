<?php

class ProcessCSV
{
    /**
     * initialize csv file
     *
     * @param string $fileName
     * @return ProcessCSV
     */
    public function init(string $fileName): ProcessCSV
    {

        $this->file = $fileName;

        return $this;
    }

    /**
     * Get Raw Content of CSV File
     *
     * @return array
     */
    public function getRawContent(): array
    {
        $csvData = file_get_contents($this->file);
        $lines = explode(PHP_EOL, $csvData);
        $response = [];

        foreach ($lines as $line) {
            $response[] = str_getcsv($line);
        }

        return $response ?? [];
    }

    /**
     * prepare graph from csv file
     *
     * @param array $data
     * @return void
     */
    public function processRequest(array $data, $answerA, $answerB)
    {
        $graphKey = [];
        $inf = 99999; // Define Infinite as a large enough value

        foreach ($data as $value) {
            $graphKey[$value[0]] = $value[0];
            $graphKey[$value[1]] = $value[1];
        }
        sort($graphKey);

        $graphData = [];
        foreach ($graphKey as $ind => $key) {
            foreach ($graphKey as $i => $value) {
                $route = $this->mapRoute($data, $key, $value);

                if (!empty($route)) {
                    $graphData[$ind][$key . $value] = $route[2];
                } elseif ($key == $value) {
                    $graphData[$ind][$key . $value] = 0;
                } else {
                    $graphData[$ind][$key . $value] = $inf;
                }
            }
        }

        $mappedData = array_flip($graphKey);
        $fromIndex = $mappedData[$answerA];
        $toIndex = $mappedData[$answerB];

        foreach ($graphData as $key => $value) {
            $graph[] = array_values($value);
        }

        list($dist, $path) = floydWarshall($graph, count($graphKey), $inf);
        $path = $path[$fromIndex][$toIndex] ?? 0;

        return [$dist[$fromIndex][$toIndex] ?? 0, max(0, $path - 1)];

    }

    public function printMessage($distance, $path, $from, $to)
    {
        if ($distance !== 99999) {
            return sprintf(
                'Your trip form %s to %s includes %d stops and will takes %s minutes',
                $from,
                $to,
                $path,
                $distance
            );
        }

        return sprintf('No routes from %s to %s', $from, $to);
    }

    public function mapRoute(array $data, string $from, string $to): array
    {
        foreach ($data as $key => $value) {
            if ($from == $value[0] && $to == $value[1]) {
                return $value;
            }
        }

        return [];
    }

    public function searchRoute(array $graph, string $key)
    {
        foreach ($graph as $value) {
            if (array_key_exists($key, $value)) {
                return $value[$key];
            }
            return false;
        }
    }

    /**
     * Ask questions
     *
     * @param string $question
     * @return void|string
     */
    public function question(string $question)
    {
        switch ($question) {
            case 'A':
                echo 'What station are you getting on the train? : ';
                break;

            case 'B':
                echo 'What station are you getting off the train? : ';
                break;
        }

        return $this->handlePrompt();
    }

    /**
     * handle prompt
     *
     * @return void|string
     */
    private function handlePrompt()
    {

        $handle = fopen("php://stdin", "r");
        $answer = fgets($handle);

        if (empty(trim($answer))) {
            echo "ABORTING!\n";
            exit;
        }

        return trim($answer);
    }
}
