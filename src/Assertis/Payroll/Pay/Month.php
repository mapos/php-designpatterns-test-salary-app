<?php
namespace Assertis\Payroll\Pay;

use Assertis\Payroll\Date\Date;
use Assertis\Payroll\Pay\PayInterface;
use Assertis\Payroll\Exception\PayrollException;

use DateTime;


/**
 * Calculate Salary and Bonus for a month
 * @package Assertis\Payroll
 */
class Month
{

    /**
     * @var DateTime Keep the Payroll month
     */
    private $date;

    /**
     * @var PayInterface
     */
    private $bonus;
    /**
     * @var PayInterface
     */
    private $salary;

    /**
     * @param PayInterface $bonus
     * @param PayInterface $salary
     */
    public function __construct(PayInterface $salary, PayInterface $bonus)
    {
        $this->bonus = $bonus;
        $this->salary = $salary;
    }

    /**
     * @throws PayrollException
     */
    private function checkDateProperty()
    {
        if (!$this->getDate()) {
            throw new PayrollException(
                "Payroll months needs to have date setup. " .
                "Please use ->setDate(DateTime) function."
            );
        }
    }

    /**
     * Get salary pay date for the specified date
     * @return DateTime
     */
    public function getPayDate()
    {
        $this->checkDateProperty();
        $date = $this->salary->get($this->getDate());
        return $date;
    }

    /**
     * Get bonus pay date for the specified date
     * @return DateTime
     */
    public function getBonusDate()
    {
        $this->checkDateProperty();
        $date = $this->bonus->get($this->getDate());
        return $date;
    }

    /**
     * Returns month name.
     * @return string
     */
    private function getMonthName()
    {
        return Date::getMonthName($this->getDate());
    }

    /**
     * @return DateTime
     */
    private function getDate()
    {
        return $this->date;
    }

    /**
     * Set the month date.
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns data row for the particular month.
     * @param $date
     * @return array
     */
    public function getRow($date)
    {

        $this->setDate($date);

        $monthName = $this->getMonthName();
        //Salary
        $salaryDay = $this->getPayDate();
        $salaryDayString = $salaryDay->format("Y-m-d");
        //Bonus
        $bonusDay = $this->getBonusDate();
        $bonusDayString = $bonusDay->format("Y-m-d");

        return [$monthName, $salaryDayString, $bonusDayString];
    }
}
