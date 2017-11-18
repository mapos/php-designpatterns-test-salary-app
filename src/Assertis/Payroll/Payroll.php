<?php
namespace Assertis\Payroll;

/**
 * Class Payroll
 * Description of Test task:
 * Sales staff get a regular monthly fixed base salary and a monthly bonus.
 * The base salaries are paid on the last day of the month unless that day is a Saturday or a
 * Sunday (weekend).
 * On the 15th of every month bonuses are paid for the previous month,unless that day is a
 * weekend. In that case,they are paid the first Wednesday after the 15th.
 */
use Assertis\Data\Type\Year;
use Assertis\Payroll\Date\Date;
use Assertis\Payroll\Pay\Month;

/**
 * Payroll - Generates full payroll for specified year
 * @package Assertis\Payroll
 */
class Payroll
{

    /**
     * @var array Keep data
     */
    private $data;

    /**
     * @var Month
     */
    private $payrollMonth;

    /**
     * @var integer
     */
    private $startMonth = 1;

    /**
     * @var integer
     */
    private $endMonth = 12;


    /**
     * @var Year
     */
    private $year;

    /**
     * @param Month $payrollMonth
     */
    public function __construct(Month $payrollMonth)
    {
        $this->payrollMonth = $payrollMonth;
    }

    /**
     * @return DatePeriod
     */
    public function getPeriod()
    {
        $startMonth = $this->getStartMonth();
        $endMonth = $this->getEndMonth();
        $year = $this->getYear();

        return Date::getPeriod($startMonth, $endMonth, $year);
    }

    /**
     * @param $date
     * @return array
     */
    private function getRow($date)
    {
        return $this->payrollMonth->getRow($date);
    }

    /**
     * returns array of data produced for a year
     * @return array
     */
    public function get()
    {
        $period = $this->getPeriod();

        foreach ($period as $date) {
            $row = $this->getRow($date);

            $this->addData($row);
        }
        return $this->data;

    }

    /**
     * @param $date
     * @return $this
     */
    public function addData($date)
    {
        $this->data[] = $date;

        return $this;
    }

    /**
     * @param Year $year
     * @return $this
     */
    public function setYear(Year $year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getEndMonth()
    {
        return $this->endMonth;
    }

    /**
     * @param int $endMonth
     */
    public function setEndMonth($endMonth)
    {
        $this->endMonth = $endMonth;
    }

    /**
     * @return int
     */
    public function getStartMonth()
    {
        return $this->startMonth;
    }

    /**
     * @param int $startMonth
     */
    public function setStartMonth($startMonth)
    {
        $this->startMonth = $startMonth;
    }
}
