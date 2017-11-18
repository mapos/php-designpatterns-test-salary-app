<?php
use Assertis\Payroll\Payroll;
use Assertis\Payroll\PayrollFactory;
use Assertis\Data\Type\Year;

/**
 * Payroll test
 */
class PayrollTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testPayroll()
    {
        $payrollFactory = new PayrollFactory();
        $payrollMonth = $payrollFactory->getMonth();

        $payroll = (new Payroll($payrollMonth))->setYear(new Year(2014));
        $data = $payroll->get();

        //var_dump($data);

    }

}