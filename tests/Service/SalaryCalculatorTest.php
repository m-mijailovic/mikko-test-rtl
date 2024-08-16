<?php

namespace Service;

use App\Service\SalaryCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SalaryCalculatorTest extends TestCase
{
    private SalaryCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new SalaryCalculator();
    }

    #[DataProvider('salaryPaymentDateProvider')]
    #[Test]
    public function testGetSalaryPaymentDate(int $year, int $month, string $expectedDate): void
    {
        $salaryPaymentDate = $this->calculator->getSalaryPaymentDate($year, $month);
        $this->assertEquals($expectedDate, $salaryPaymentDate);
    }

    #[DataProvider('bonusPaymentDateProvider')]
    #[Test]
    public function testGetBonusPaymentDate(int $year, int $month, string $expectedDate): void
    {
        $bonusPaymentDate = $this->calculator->getBonusPaymentDate($year, $month);
        $this->assertEquals($expectedDate, $bonusPaymentDate);
    }

    public static function salaryPaymentDateProvider(): array
    {
        return [
            // Last day is a weekday
            'January 2024' => [2024, 1, '2024-01-31'], // Wednesday
            'May 2024' => [2024, 5, '2024-05-31'], // Friday

            // Last day is a weekend
            'February 2024' => [2024, 2, '2024-02-29'], // Leap year, Thursday
            'June 2024' => [2024, 6, '2024-06-28'], // Friday (June 30 is Sunday)
            'November 2024' => [2024, 11, '2024-11-29'], // Friday (November 30 is Saturday)
            'December 2024' => [2024, 12, '2024-12-31'], // Tuesday
        ];
    }

    public static function bonusPaymentDateProvider(): array
    {
        return [
            // 15th is a weekday
            'January 2024 (Bonus for December 2023)' => [2024, 1, '2024-01-15'], // Monday
            'February 2024 (Bonus for January 2024)' => [2024, 2, '2024-02-15'], // Thursday

            // 15th is a weekend
            'June 2024 (Bonus for May 2024)' => [2024, 6, '2024-06-19'], // 15th is Saturday, paid on Wednesday 19th
            'September 2024 (Bonus for August 2024)' => [2024, 9, '2024-09-18'], // 15th is Sunday, paid on Wednesday 18th

            // Edge cases for different months
            'March 2024 (Bonus for February 2024)' => [2024, 3, '2024-03-15'], // Friday
            'July 2024 (Bonus for June 2024)' => [2024, 7, '2024-07-15'], // Monday
            'December 2024 (Bonus for November 2024)' => [2024, 12, '2024-12-18'], // 15th is Sunday, paid on Wednesday 18th
        ];
    }
}