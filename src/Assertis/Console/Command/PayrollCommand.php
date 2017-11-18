<?php

namespace Assertis\Console\Command;

use Assertis\Data\DataException;
use Assertis\Data\Type\File;
use Assertis\Data\Type\Filename;
use Assertis\Data\Type\Year;
use Assertis\Payroll\PayrollFactory;
use Assertis\Storage\Type\Csv;
use Assertis\Storage\Exception\StorageException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Payroll CLI Command
 * @package Assertis\Console\Command
 */
class PayrollCommand extends Command
{
    /**
     * Configure the Symfony Console Command.
     */
    protected function configure()
    {
        $this
            ->setName('payroll:generate')
            ->setDescription('Generate salary payroll')
            ->addOption(
                'year',
                null,
                InputOption::VALUE_REQUIRED,
                'If not set the current year will be used'
            )
            ->addOption(
                'filename',
                null,
                InputOption::VALUE_REQUIRED,
                'If not set the YEAR.csv will be used'
            );
    }

    /**
     * Command execution script
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Set coloring styles
        $this->setStyles($output);

        //If the year is not set, the current will be used.
        if (!$year = $input->getOption('year')) {
            $year = date("Y");
        }

        try {
            $year = new Year($year); //We validate the year
        } catch (DataException $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
            exit;
        }

        //If the filename is not specified, $year with the extension will be used.
        if (!$filename = $input->getOption('filename')) {
            $filename = $year . ".csv";
        }

        try {
            $filename = new Filename($filename, "csv"); //We validate the filename
        } catch (DataException $e) {
            $output->writeln("<error>" . $e->getMessage() . "</error>");
            exit;
        }

        $file = new File($filename);

        $payrollData = $this->generatePayrollByYear($year);

        if ($this->saveToFile($file, $payrollData)) {
            $output->writeln(
                "<ok>Payroll for the year: " . $year . " has been saved in the file: " . $filename . "</ok>"
            );
            return true;
        }

        $output->writeln(
            "<error>Error: Payroll for the year: " . $year .
            " has NOT been saved in the file: " . $filename . "</error>"
        );

        return true;
    }

    /**
     * @param Year $year
     * @return array
     */
    protected function generatePayrollByYear(Year $year)
    {
        $payroll = (new PayrollFactory())->getPayroll();
        $payroll->setYear($year);
        return $payroll->get();
    }

    /**
     * @param File $file
     * @param array $data
     * @return bool
     * @throws StorageException
     */
    protected function saveToFile(File $file, array $data)
    {
        $storage = new Csv();
        $storage->setFile($file);
        $storage->setData($data);

        return $storage->persist();
    }

    /**
     * @param OutputInterface $output
     */
    protected function setStyles(OutputInterface $output)
    {
        $okStyle = new OutputFormatterStyle('green', 'black', array('bold'));
        $output->getFormatter()->setStyle('ok', $okStyle);

        $errorStyle = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('error', $errorStyle);

    }
}
