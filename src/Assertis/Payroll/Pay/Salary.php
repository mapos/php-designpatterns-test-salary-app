<?php
namespace Assertis\Payroll\Pay;

use DateTime;
use Assertis\Payroll\Date\Date;

/**
 * Salary calculation
 * @package Assertis\Payroll\Pay
 */
class Salary implements PayInterface
{
    /**
     *Day of salary if BONUSDAY is on weekend.
     */
    const ALTERNATIVE = "previous friday";

    /**
     * @param DateTime $date
     * @return DateTime
     */
    public function get(DateTime $date)
    {
        $payDay = Date::getLastDay($date);

        if (Date::isWeekend($payDay)) {
            //Salary is on last weekday
            $date->modify(self::ALTERNATIVE);
        }

        return $payDay;
    }
}
