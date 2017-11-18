<?php
namespace Assertis\Payroll;

use Assertis\Payroll\Pay\Bonus;
use Assertis\Payroll\Pay\Salary;
use Assertis\Payroll\Pay\Month;

/**
 * Create Payroll objects
 * @package Assertis\Payroll
 */
class PayrollFactory
{

    /**
     * @return PayrollMonth
     */
    public static function getMonth()
    {
        $bonus = new Bonus();
        $salary = new Salary();
        $payrollmonth = new Month($salary, $bonus);

        return $payrollmonth;

    }

    /**
     * @return Payroll
     */
    public static function getPayroll()
    {
        $payrollMonth = self::getMonth();
        $payroll = new Payroll($payrollMonth);
        return $payroll;
    }
}
