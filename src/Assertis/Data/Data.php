<?php
namespace Assertis\Data;

/**
 * Base class for data types
 * @package Assertis\Data
 */
/**
 * Class Data
 * @package Assertis\Data
 */
abstract class Data
{

    /**
     * Default error message
     */
    protected static $message = "Data is invalid.";

    /**
     * Keep right data, validated using abstract function validate
     * @var mixed
     */
    protected $value;

    /**
     * @param $value
     * @return bool
     */
    abstract protected function validate($value);

    /**
     * @param null|mixed $value
     * @throws DataException
     */
    public function __construct($value = null)
    {
        if ($value !== null) {
            $this->setValue($value);
        }
    }

    private function error($value)
    {
        $errorMessage = sprintf($this->getMessage(), $value);
        throw new DataException($errorMessage);
    }

    /**
     * @param $value
     * @return $this
     * @throws DataException
     */
    public function setValue($value)
    {
        if (!$this->validate($value)) {
            $this->error($value);
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return static::$message;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        static::$message = (string)$message;

        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}
