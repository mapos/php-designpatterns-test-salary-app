<?php

/**
 * Datasets for storage tests
 */
class StorageData
{
    /**
     * @return array
     */
    public function dataToStore()
    {
        return [
            ["My row 1", "2014", "xxxx", 1223],
            ["My row 2", "2015", "x,x,x", 3433],
            ["My row 3", "2016", "yyyy", "cc,c,cc,c,cc"],
        ];
    }

    /**
     * @return array
     */
    public function row1()
    {
        return [1, 2, 3, 4];
    }

    /**
     * @return array
     */
    public function row2()
    {
        return [5, 6, 7, 8];
    }

    /**
     * @return array
     */
    public function row3()
    {
        return [9, 0, 1, 2];
    }

    /**
     * Bad row for data integration tests.
     * @return array
     */
    public function rowBad()
    {
        return [1, 2, 3];
    }
}
