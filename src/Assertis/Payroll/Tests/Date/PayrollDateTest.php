<?php
use Assertis\Payroll\Date\Date;

/**
 * Payroll date test
 */
class PayrollDateTest extends PHPUnit_Framework_TestCase
{

    /**
     * main test
     */
    public function testPayrollDate()
    {
        $monthName = Date::getMonthName(new DateTime("2014-10-1"));
        $this->assertEquals("October", $monthName);

        $isWeekend = Date::isWeekend(new DateTime("2014-10-12"));
        $this->assertTrue($isWeekend);

        $changedDay = Date::changeDay(15, new DateTime("2014-10-12"));
        $this->assertEquals("2014-10-15", $changedDay->format("Y-m-d"));

        $changedDay = Date::getLastDay(new DateTime("2014-10-12"));
        $this->assertEquals("2014-10-31", $changedDay->format("Y-m-d"));

    }

}