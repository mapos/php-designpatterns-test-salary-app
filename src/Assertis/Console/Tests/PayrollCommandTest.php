<?php

namespace Assertis\Console\Command;

use Symfony\Component\Process\Process;

/**
 * Testing CLI commands for payroll
 * @package Assertis\Console\Command
 */
class PayrollCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testWrongYearErrorMessage()
    {
        $output = $this->commandTest("bin/console payroll:generate --year=noyear");
        $this->assertEquals("'noyear' is invalid year." . PHP_EOL, $output);
    }

    public function testWrongFilenameErrorMessage()
    {
        $output = $this->commandTest("bin/console payroll:generate --filename=myfile.txt");
        $this->assertEquals("'myfile.txt' is not valid filename. Please make sure your filename has the 'csv' extension." . PHP_EOL, $output);
    }

    public function testNoOptions()
    {
        $output = $this->commandTest("bin/console payroll:generate");

        //TODO: Better handling for no generated file
        unlink("2014.csv");
        $this->assertEquals("Payroll for the year: 2014 has been saved in the file: 2014.csv" . PHP_EOL, $output);
    }

    public function testYearOption()
    {
        $output = $this->commandTest("bin/console payroll:generate --year=2012");

        //TODO: Better handling for no generated file
        unlink("2012.csv");
        $this->assertEquals("Payroll for the year: 2012 has been saved in the file: 2012.csv" . PHP_EOL, $output);
    }

    public function testFilenameOption()
    {
        $output = $this->commandTest("bin/console payroll:generate --filename=testing-filename.csv");

        //TODO: Better handling for no generated file
        unlink("testing-filename.csv");
        $this->assertEquals("Payroll for the year: 2014 has been saved in the file: testing-filename.csv" . PHP_EOL, $output);
    }

    public function testYearAndFilenameOptions()
    {
        $output = $this->commandTest("bin/console payroll:generate --year=2015 --filename=testing-year-and-filename.csv");

        //TODO: Better handling for no generated file
        unlink("testing-year-and-filename.csv");
        $this->assertEquals("Payroll for the year: 2015 has been saved in the file: testing-year-and-filename.csv" . PHP_EOL, $output);
    }

    /**
     * Run a command and returns output of it.
     * @param $command
     * @return string
     */
    private function commandTest($command)
    {
        $process = new Process($command);
        $process->run();
        return $process->getOutput();
    }
}
