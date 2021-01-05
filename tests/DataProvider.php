<?php

class DataProvider
{

    /**
     * for processRequest
     *
     * @return array
     */
    public function processRequest(): array
    {
        return [
            [
                [
                    'option1' => 'A',
                    'option2' => 'B',
                    'expected' => [5, 0],
                ],
            ],
            [
                [
                    'option1' => 'A',
                    'option2' => 'C',
                    'expected' => [10, 1],
                ],
            ],
            [
                [
                    'option1' => 'E',
                    'option2' => 'J',
                    'expected' => [30, 2],
                ],
            ],
            [
                [
                    'option1' => 'A',
                    'option2' => 'D',
                    'expected' => [15, 0],
                ],
            ],
            [
                [
                    'option1' => 'A',
                    'option2' => 'J',
                    'expected' => [99999, 0],
                ],
            ],
        ];
    }
}
