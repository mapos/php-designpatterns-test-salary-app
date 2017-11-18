<?php
use Assertis\Payroll\Pay\Bonus;

/**
 * Payroll bonus test
 */
class PayrollBonusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PayrollPayBonus
     */
    private $payrollPayBonus;

    /**
     * Create the payroll bonus object.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->payrollPayBonus = new Bonus();
    }

    /**
     * Test dates with the dataProvider annotation.
     *
     * @param $date
     * @param $resultBonus
     * @dataProvider provider
     */
    public function testBonus($date, $resultBonus)
    {
        $dateTime = new DateTime($date);
        $payrollPayBonus = $this->payrollPayBonus->get($dateTime);
        $result = $payrollPayBonus->format("Y-m-d");

        $this->assertEquals($resultBonus, $result);
    }

    /**
     * Data for the dataProvider annotation.
     *
     * @return array
     */
    public function provider()
    {
        return [
            ["2014-10", "2014-10-15"],
            ["2014-11", "2014-11-19"],
            ["2015-11", "2015-11-18"],
            ["2036-10", "2036-10-15"],
            ["2014-05", "2014-05-15"]
        ];

    }

}
