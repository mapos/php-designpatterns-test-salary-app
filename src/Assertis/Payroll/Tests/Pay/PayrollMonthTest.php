<?php
use Assertis\Payroll\PayrollFactory;
use Assertis\Payroll\PayrollMonth;
use Assertis\Payroll\Exception\PayrollException;

/**
 * Class PayrollMonthTest
 */
class PayrollMonthTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PayrollMonth
     */
    private $payrollMonth;

    /**
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->payrollMonth = (new PayrollFactory())->getMonth();
    }

    /**
     * Incorrect Filename Pass #1
     * @expectedException        PayrollException
     * @expectedExceptionMessage 'ourfilename.xxx' is not valid filename. Please make sure your filename has the 'csv' extension.
     */
    public function checkDatesExcdeption()
    {
        $this->payrollMonth->checkDateProperty();
    }


    /**
     * @param $date
     * @param $salaryDay
     * @param $bonusDay
     * @dataProvider provider
     */
    public function testPayrollMonth($date, $salaryDay, $bonusDay)
    {
        $dateTime = new DateTime($date);
        $this->payrollMonth->setDate($dateTime);
        //Salary
        $payDayDate = $this->payrollMonth->getPayDate();
        $this->assertEquals($salaryDay, $payDayDate->format("Y-m-d"));
        //Bonus
        $bonusDayDate = $this->payrollMonth->getBonusDate();
        $this->assertEquals($bonusDay, $bonusDayDate->format("Y-m-d"));

    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ["2014-10", "2014-10-31", "2014-10-15"],
            ["2014-11", "2014-11-28", "2014-11-19"],
            ["2015-11", "2015-11-30", "2015-11-18"],
            ["2036-10", "2036-10-31", "2036-10-15"],
            ["2014-05", "2014-05-30", "2014-05-15"]
        ];

    }

}