<?php
use Assertis\Payroll\Pay\Salary;

/**
 * Payroll salary test
 */
class SalaryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Salary
     */
    private $salary;

    /**
     * Create the payroll salary object.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->salary = new Salary();
    }

    /**
     * Test dates with the dataProvider annotation.
     *
     * @param $date
     * @param $resultSalaryDay
     * @dataProvider provider
     */
    public function testSalary($date, $resultSalaryDay)
    {
        $dateTime = new DateTime($date);
        $salary = $this->salary->get($dateTime);
        $result = $salary->format("Y-m-d");

        $this->assertEquals($resultSalaryDay, $result);
    }

    /**
     * Data for the dataProvider annotation.
     *
     * @return array
     */
    public function provider()
    {
        return [
            ["2014-10", "2014-10-31"],
            ["2014-11", "2014-11-28"],
            ["2015-11", "2015-11-30"],
            ["2036-10", "2036-10-31"],
            ["2014-05", "2014-05-30"]
        ];

    }

}