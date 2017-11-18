<?php
namespace Assertis\Payroll\Date;

use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Handy date operations for payroll calculations
 * @package Assertis\Payroll
 */
class Date
{

    /**
     * @param DateTime $date
     * @return bool
     */
    public static function isWeekend(DateTime $date)
    {
        $dayNumber = $date->format("N");
        return $dayNumber >= 6;
    }

    /**
     * Change a day for selected date
     * @param $day
     * @param DateTime $date
     * @return DateTime
     */
    public static function changeDay($day, DateTime $date)
    {
        $year = $date->format("Y");
        $month = $date->format("m");

        //TODO: THIS DOESN'T WORK SOMETIMES PROPERLY (PHP 5.6.2 BUG?)! LATER TO CHECK IT!! BELOW WORKAROUND
        //$date->setDate($year, $month, $day);

        $format = "Y-m-d H:i:s";
        $date = DateTime::createFromFormat($format, $year . '-' . $month . '-' . $day . ' 00:00:00');

        return $date;
    }

    /**
     * @param DateTime $date
     * @return string
     */
    public static function getMonthName(DateTime $date)
    {
        $monthName = $date->format("F");
        return $monthName;
    }

    /**
     * @param DateTime $date
     * @return DateTime
     */
    public static function getLastDay(DateTime $date)
    {
        $date->modify("last day of this month");
        return $date;
    }

    /**
     * Returns DatePeriod which implements Traversable interface.
     * @param integer $startMonth
     * @param integer $endMonth
     * @param integer $year
     * @param string $interval
     * @return DatePeriod
     */
    public static function getPeriod($startMonth, $endMonth, $year, $interval = "P1M")
    {
        //TODO: Move DateTime?
        $begin = new DateTime($year . '-' . $startMonth);
        $end = new DateTime($year . '-' . $endMonth);
        //1 Month interval
        $end->modify("+1 day");
        $interval = new DateInterval($interval);

        return new DatePeriod($begin, $interval, $end);
    }
}
