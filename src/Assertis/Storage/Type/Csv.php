<?php

namespace Assertis\Storage\Type;
use Assertis\Storage\Storage;
use Assertis\Data\Type\File;

/**
 * Csv storage
 * @package Assertis\Storage
 */
class Csv extends Storage
{
    /**
     * @var
     */
    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @param File $file
     * @return $this
     */
    public function setFile(File $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return $this
     * @throws StorageException
     */
    public function persist()
    {
        if ($file = $this->getFile()) {
            $data = $this->getData();
            if (!$data) {
                throw new StorageException(
                    "No data to persist."
                );
            }
            $file->writeCsv($data);
            return $this;
        }

        throw new StorageException(
            "Specify file using setFile function."
        );
    }

}
