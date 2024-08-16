<?php

namespace App\Service;

class SalaryCalculator
{
    /**
     * @param int $year
     * @param int $startMonth
     *
     * @return array<mixed>
     */
    public function calculateForYear(int $year, int $startMonth = 1): iterable
    {
        $dates = [];

        for ($month = $startMonth; $month <= 12; $month++) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));

            $salaryPaymentDate = $this->getSalaryPaymentDate($year, $month);
            $bonusPaymentDate = $this->getBonusPaymentDate($year, $month);

            $dates[] = [$monthName, $salaryPaymentDate, $bonusPaymentDate];
        }

        return $dates;
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return string
     */
    public function getSalaryPaymentDate(int $year, int $month): string
    {
        $lastDay = date('Y-m-t', strtotime("$year-$month-01"));

        if (date('N', strtotime($lastDay)) >= 6) { // Saturday or Sunday
            return date('Y-m-d', strtotime('last Friday', strtotime($lastDay)));
        }

        return $lastDay;
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return string
     */
    public function getBonusPaymentDate(int $year, int $month): string
    {
        // Calculate the 15th day of the next month for the previous month's bonus
        $bonusDate = date('Y-m-d', strtotime("$year-$month-15"));

        if (date('N', strtotime($bonusDate)) >= 6) { // Saturday or Sunday
            return date('Y-m-d', strtotime('next Wednesday', strtotime($bonusDate)));
        }

        return $bonusDate;
    }
}
