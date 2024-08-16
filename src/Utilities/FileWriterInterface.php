<?php

namespace App\Utilities;

interface FileWriterInterface
{
    /**
     * @param string $filePath
     * @param array<mixed> $data
     *
     * @return void
     */
    public function write(string $filePath, iterable $data): void;
}
