<?php
use Assertis\Data\Type\Filename;
use Assertis\Data\Type\File;
use Assertis\Storage\Exception\StorageException;
require_once "StorageData.php";

/**
 * Storage Abstract test
 */
class AbstractStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StorageData
     */
    private $storageData;

    /**
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->storageData = new StorageData();
    }

    public function testDataMethods()
    {
        $mock = $this->getMyMock();

        $data = $this->storageData->dataToStore();
        $result = $mock->setData($data);

        $this->assertSame($mock, $result);

        //getData
        $dataFromMock = $result->getData();

        $this->assertEquals($data, $dataFromMock);

        //add
        $array = array();
        $result = $mock->setData($array);

        $result->add($this->storageData->row1())
            ->add($this->storageData->row2())
            ->add($this->storageData->row3());

        $testArray = [$this->storageData->row1(), $this->storageData->row2(), $this->storageData->row3()];

        $dataMock = $mock->getData();
        $this->assertEquals($testArray, $dataMock);

    }

    /**
     * Incorrect Filename Pass #1
     * @expectedException        Assertis\Storage\Exception\StorageException
     * @expectedExceptionMessage Data Integrity Error. Correct number of values for array.
     */
    public function testDataIntegrationMethods()
    {
        $mock = $this->getMyMock();

        $mock->add($this->storageData->row1())
            ->add($this->storageData->row2())
            ->add($this->storageData->row3())
            ->add($this->storageData->rowBad());
    }

    public function testAbstractPersistMethod()
    {
        //So we know still has this method
        $mock = $this->getMyMock();

        $mock->method('persist')
            ->will($this->returnValue(true));
        $persistResult = $mock->persist();
        $this->assertEquals(true, $persistResult);
    }

    private function getMyMock()
    {
        return $this->getMockForAbstractClass(
            'Assertis\Storage\Storage'

//            [], //No parameters to the constructor
//            '',
//            //Class has the same name
//            TRUE, //call original constructor,
//            TRUE, //Call orginal clone,
//            TRUE, //Call autoload
//            array('persist')
        );
    }

}
