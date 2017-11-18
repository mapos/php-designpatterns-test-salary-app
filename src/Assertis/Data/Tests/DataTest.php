<?php

/**
 * Data Abstract test
 */
class AbstractDataTest extends PHPUnit_Framework_TestCase
{
    public function testValidateMethod()
    {
        $mock = $this->getMyMock();
        $mock->method('validate')
            ->will($this->returnValue(true));

        $result = $mock->setValue('some value');

        $this->assertSame($mock, $result);

    }

    /**
     * Incorrect Data Exception
     * @expectedException        Assertis\Data\DataException
     * @expectedExceptionMessage Data is invalid.
     */
    public function testWongValidationMethod()
    {
        $mock = $this->getMyMock();
        $mock->method('validate')
            ->will($this->returnValue(false));

        $mock->setValue('some value');
    }

    private function getMyMock()
    {
        return $this->getMockForAbstractClass(
            'Assertis\Data\Data'

//            [], //No parameters to the constructor
//            '',
//            //Class has the same name
//            TRUE, //call original constructor,
//            TRUE, //Call original clone,
//            TRUE, //Call autoload
//            array('persist')
        );
    }
}
