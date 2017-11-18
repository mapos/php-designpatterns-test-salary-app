<?php
namespace Assertis\Data\Type;

use Assertis\Data\DataException;

/**
 * File handling - small data - just for a test
 * @package Assertis\Data\Type
 */
class File
{
    /**
     * @var resource a file pointer resource
     */
    private $filePointer;

    /**
     * @var Filename
     */
    private $filename;

    /**
     * @var string a mode to open a file. default r
     * r - Open for reading only; place the file pointer at the beginning of the file.
     * @link http://php.net/manual/en/function.fopen.php
     */
    private $mode = 'r';

    /**
     * @param Filename $filename
     */
    public function __construct(Filename $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Open file. It is automatically triggered when read or write.
     * @return $this
     * @throws DataException
     */
    public function open()
    {
        if (!$filePointer = $this->filePointer) {

            try {
                $this->filePointer = fopen($this->filename, $this->mode);

                if (!$this->filePointer) {
                    throw new DataException("Could not open the file!");
                }
            } catch (Exception $e) {
                throw new DataException("Error (File: " . $e->getFile() . ", line " .
                    $e->getLine() . "): " . $e->getMessage());
            }
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function close()
    {
        fclose($this->filePointer);
        $this->filePointer = null;

        return $this;
    }

    /**
     * Write data. Open file is automatically triggered when read or write.
     * @param string $data
     * @return $this
     */
    public function write($data)
    {
        $this->makeSureMode('w');
        fwrite($this->filePointer, (string)$data);

        return $this;
    }

    /**
     * Write CSV data from array
     * @param array $data
     * @return $this
     */
    public function writeCsv(array $data)
    {
        $this->makeSureMode('w');
        foreach ($data as $row) {
            fputcsv($this->filePointer, $row);
        }

        return $this;
    }

    /**
     * for small files
     * @return string
     */
    public function read()
    {
        $this->makeSureMode('r');

        return file_get_contents($this->filename);
    }

    /**
     * Make sure the mode of open file is right
     * @param string $mode
     * @return $this
     */
    private function makeSureMode($mode)
    {
        if (!$this->filePointer || $this->mode != $mode) {
            //If mode is different we change the
            //mode for writing OR reading files.

            if ($this->filePointer) {
                $this->close();
            }
            $this->mode = $mode;
            $this->open();
        }

        return $this;
    }

    /**
     * @return int
     * @link http://php.net/manual/en/function.filesize.php
     * @throws DataException
     */
    public function getSize()
    {
        $this->makeSureMode('r');

        if ($this->filePointer) {
            $size = fstat($this->filePointer)['size'];
        }

        if (!isset($size) || $size === false) {
            throw new DataException("Can't get file size. File " . $this->filename . " does not exist?");
        }

        return $size;
    }

    /**
     * @return resource
     */
    public function getFilePointer()
    {
        return $this->filePointer;
    }

    /**
     * @param resource $filePointer
     * @return $this
     */
    public function setFilePointer($filePointer)
    {
        $this->filePointer = $filePointer;

        return $this;
    }

    /**
     * @return Filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param Filename $filename
     * @return $this
     */
    public function setFilename(Filename $filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->filename;
    }

    /**
     * We close file pointer, if it is still open.
     */
    public function __destruct()
    {
        if ($this->filePointer) {
            $this->close();
        }
    }
}
