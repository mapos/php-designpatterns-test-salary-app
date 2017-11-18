<?php
use Assertis\Data\Type\File;
use Assertis\Data\Type\Filename;
use Assertis\Storage\Type\Csv;
use Assertis\Storage\Exception\StorageException;


/**
 * Class PayrollCsvTest
 */
class PayrollCsvTest extends PHPUnit_Framework_TestCase
{
    /**
     * @throws StorageException
     */
    public function testDates()
    {

        $csvStorage = new Csv();
        $filename = new Filename("ile.csv", "csv");

        $file = new File($filename);
        $csvStorage->setFile($file);
        $csvStorage->setData($this->dataToStore());
        $csvStorage->persist();

        unlink("ile.csv");

    }

    /**
     * @return array
     */
    private function dataToStore()
    {
        return [
            ["My row 1", "2014", "xxxx", 1223],
            ["My row 2", "2015", "x,x,x", 1223],
            ["My row 3", "2016", "yyyy", "cc,c,cc,c,cc"],
        ];
    }
}
