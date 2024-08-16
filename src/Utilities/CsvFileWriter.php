<?php

namespace App\Utilities;

use RuntimeException;

class CsvFileWriter implements FileWriterInterface
{
    /**
     * @param string $filePath
     * @param array<mixed> $data
     *
     * @return void
     */
    public function write(string $filePath, iterable $data): void
    {
        $file = fopen($filePath, 'w');

        if ($file === false) {
            throw new RuntimeException('Unable to open file for writing: ' . $filePath);
        }

        fputcsv($file, ['Month', 'Salary Payment Date', 'Bonus Payment Date']);

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}
