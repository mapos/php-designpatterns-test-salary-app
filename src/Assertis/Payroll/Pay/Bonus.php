<?php
namespace Assertis\Payroll\Pay;

use DateTime;
use Assertis\Payroll\Date\Date;

/**
 * Bonus Calculation
 * @package Assertis\Payroll\Pay
 */
class Bonus implements PayInterface
{
    /**
     *Day of the Bonus
     */
    const PAYDAY = "15";

    /**
     *Day of bonus if Bonus PAYDAY is on weekend.
     */
    const ALTERNATIVE = "next wednesday";

    /**
     * @param DateTime $date
     * @return DateTime
     */
    public function get(DateTime $date)
    {
        //Set the day for the bonus
        $bonusPayday = Date::changeDay(self::PAYDAY, $date);

        //We check if the bonus day is on weekend
        if (Date::isWeekend($bonusPayday)) {
            //Bonus is on next Wednesday
            $bonusPayday->modify(self::ALTERNATIVE);
        }

        return $bonusPayday;
    }
}
