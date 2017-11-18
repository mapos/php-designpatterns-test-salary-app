<?php
namespace Assertis\Data\Type;

use Assertis\Data\Data;
use Assertis\Data\DataException;

/**
 * Filename data type
 * @package Assertis\Data\Type
 */
class Filename extends Data
{
    /**
     * Regular expression for validation
     */
    const filenameRegexp = "[a-zA-Z0-9-]+";

    /**
     * @var string
     */
    protected static $message = "'%s' is not valid filename.";
    /**
     * @var $extension Keep extension, if specified, extension will be checked
     */
    private $extension;

    /**
     * @param null $value
     * @param null $extension
     * @throws DataException
     */
    public function __construct($value = null, $extension = null)
    {
        if ($extension) {
            $this->setExtension($extension);
        }

        parent::__construct($value);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return static::$message . " Please make sure your filename has the '" . $this->getExtension() . "' extension.";
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $regularExpression = "/^" . self::filenameRegexp . "$/";
        //I think this can be done much better,
        //for a test I think is ok
        if ($extension = $this->getExtension()) {
            $extension = "\." . $extension;
            $regularExpression = "/^" . self::filenameRegexp . $extension . "$/";
        }

        return 1 === preg_match($regularExpression, $value);
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension)
    {
        $this->extension = (string)$extension;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
