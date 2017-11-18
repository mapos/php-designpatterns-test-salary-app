<?php

use Assertis\Data\Type\Filename;

/**
 * Filename Test
 */
class FilenameTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test function for dataProvider.
     *
     * @param $filename
     * @param $extension
     * @dataProvider provider
     */
    public function testFilenames($filename, $extension)
    {
        $filenameReady = (string)new Filename($filename, $extension);
        $this->assertEquals($filename, $filenameReady);
    }

    /**
     * Incorrect Filename Pass #1
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage 'ourfilename.xxx' is not valid filename. Please make sure your filename has the 'csv' extension.
     */
    public function testWrong2()
    {
        new Filename("ourfilename.xxx", "csv");
    }

    /**
     * Incorrect Filename Pass #1
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage '';';';.xxx' is not valid filename. Please make sure your filename has the 'csv' extension.
     */
    public function testWrong()
    {
        new Filename("';';';.xxx", "csv");
    }


    /**
     * Data for dataProvider annotation.
     *
     * @return array
     */
    public function provider()
    {
        return [
            ["2014.csv", "csv"],
            ["test.jpg", "jpg"],
            ["anotherone.test", "test"],
            ["noextension", ""],
            ["noextension2", null]
        ];

    }
}
