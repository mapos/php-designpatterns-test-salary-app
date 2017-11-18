<?php

use Assertis\Data\Type\File;
use Assertis\Data\Type\Filename;

/**
 * Class FileTest
 */
class FileTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testWrite()
    {
        $file = $this->getFile();

        $result = $file->write($this->getData());
        //We can close file by close(), unset() or destructor will be automatically run
        $file->close();

        $this->assertInstanceOf("Assertis\Data\Type\File", $result);
    }

    /**
     * @depends testWrite
     */
    public function testRead()
    {
        $file = $this->getFile();
        $data = $file->read();
        $this->assertEquals($this->getData(), $data);

        unlink("test.csv");
    }

    /**
     * @return File
     */
    private function getFile()
    {
        $filename = new Filename("test.csv", "csv");
        $file = new File($filename);
        return $file;
    }

    /**
     * @return string
     */
    private function getData()
    {
        return 'This is my data for test of writing';
    }
}
