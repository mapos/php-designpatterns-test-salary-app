<?php
use Assertis\Data\Type\Year;

/**
 * Year test
 */
class YearTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test correct values based on Year class settings
     */
    public function testCorrectValues()
    {
        for ($year = Year::YEAR_START; $year <= Year::YEAR_END; $year++) {
            $test = new Year($year);
            $this->assertEquals($year, $test->getValue());
        }

        //We also check if the Year was passed as string, which is also valid year.

        $test2 = new Year("2014");
        $this->assertEquals(2014, $test2->getValue());
    }

    /**
     * Incorrect Year Pass #1
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage 'X2014' is invalid year.
     */
    public function testIncorrectValues1()
    {
        new Year("X2014");
    }

    /**
     * Incorrect Year Pass #2
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage '-1050' is invalid year.
     */
    public function testIncorrectValues2()
    {
        new Year("-1050");
    }

    /**
     * Incorrect Year Pass #3
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage '2014Z' is invalid year.
     */
    public function testIncorrectValues3()
    {
        new Year("2014Z");
    }

}