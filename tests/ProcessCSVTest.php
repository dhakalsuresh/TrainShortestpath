<?php

use DataProvider;
use PHPUnit\Framework\TestCase;

include 'app/ProcessCSV.php';
include 'app/algorithm.php';

class ProcessCSVText extends TestCase
{

    public function setUp(): void
    {
        $this->csvData = [
            ['A', 'B', 5],
            ['B', 'C', 5],
            ['C', 'D', 7],
            ['A', 'D', 15],
            ['E', 'F', 5],
            ['F', 'G', 5],
            ['G', 'H', 10],
            ['H', 'I', 10],
            ['I', 'J', 5],
            ['G', 'J', 20],
        ];
        $this->processCsv = new ProcessCSV();
        parent::setUp();
    }

    /**
     * @test
     * @covers \ProcessCSV::processRequest()
     * @dataProvider \DataProvider::processRequest()
     *
     * @return void
     */
    public function test_processRequest(array $data): void
    {
        $response = $this->processCsv->processRequest($this->csvData, $data['option1'], $data['option2']);
        $this->assertEquals($response, $data['expected']);
    }
}
