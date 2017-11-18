<?php

namespace Assertis\Storage;

use Assertis\Storage\Exception\StorageException;

/**
 * Abstract Storage for storing data
 * @package Assertis\Storage
 */
abstract class Storage
{
    /**
     * Data to save
     *
     * @var array
     */
    private $data;

    /**
     * @return bool Stores the data
     */
    abstract public function persist();

    /**
     * Check if the data has the same  number of rows. It is not MongoDB HA!
     * @param array $data
     * @return bool
     * @throws StorageException
     */
    private function checkDataIntegrity(array $data)
    {
        if (!$this->firstRowExists()) {
            //We don't have data yet, so we accept every kind of array
            return true;
        }
        if (count($data) !== $this->firstColumnCounter()) {
            throw new StorageException(
                "Data Integrity Error. Correct number of values for array."
            );
        }

        return true;
    }

    /**
     * @return bool
     */
    private function firstRowExists()
    {
        return isset($this->data[0]);
    }

    /**
     * Calculate the number of the elements at the first row.
     *
     * @return int
     */
    private function firstColumnCounter()
    {
        return count($this->data[0]);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array &$data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add data as next row.
     *
     * @param $data
     * @return mixed
     */
    public function add(array $data)
    {
        if ($this->checkDataIntegrity($data)) {
            $this->data[] = $data;
        }
        return $this;
    }


    /**
     * @return mixed
     */
    function __toString()
    {
        return print_r($this->getData(), true);
    }
}
