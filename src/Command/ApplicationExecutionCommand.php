<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\SalaryCalculator;
use App\Utilities\FileWriterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:mikko', description: 'Generates the salary dates for the remainder of the current year')]
class ApplicationExecutionCommand extends Command
{
    public function __construct(
        private readonly SalaryCalculator $calculator,
        private readonly FileWriterInterface $fileWriter
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (int) date('Y');
        $currentMonth = (int) date('m');
        $dates = $this->calculator->calculateForYear($year, $currentMonth);

        $filePath = __DIR__ . '/../../out/salary_dates.csv';
        $this->fileWriter->write($filePath, $dates);

        $output->writeln('Salary dates generated in `out` folder!');

        return Command::SUCCESS;
    }
}
