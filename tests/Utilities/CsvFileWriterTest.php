<?php

namespace Utilities;

use App\Utilities\CsvFileWriter;
use PHPUnit\Framework\TestCase;

class CsvFileWriterTest extends TestCase
{
    public function testCanWriteCsv(): void
    {
        $csvWriter = new CsvFileWriter();

        $filePath = __DIR__ . '/../out/salary_dates_test.csv';
        $data = [
            ['January', '2024-01-31', '2024-01-17'],
            ['February', '2024-02-29', '2024-02-15'],
        ];

        $csvWriter->write($filePath, $data);

        $this->assertFileExists($filePath);

        $fileContents = file($filePath);
        $this->assertCount(3, $fileContents); // Including header row

        // Clean up
        unlink($filePath);
    }
}