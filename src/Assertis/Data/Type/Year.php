<?php
namespace Assertis\Data\Type;

use Assertis\Data\Data;

/**
 * Year data type
 * @package Assertis\Data
 */
class Year extends Data
{
    /**
     * Valid year start value
     * It is just for a test so, I didn't worry about it.
     */
    const YEAR_START = 1901;

    /**
     * Valid year end value
     */
    const YEAR_END = 2099;

    /**
     * @var string
     */
    protected static $message = "'%s' is invalid year.";

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (!preg_match("/^[0-9]{4}$/", $value)) {

            return false;
        }
        return $value >= self::YEAR_START && $value <= self::YEAR_END;
    }
}
