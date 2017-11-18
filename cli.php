#!/usr/bin/env php
<?php

if (!file_exists($file = 'vendor/autoload.php')) {
    $message = 'Install dependencies to run this script. "composer update"';
    throw new \RuntimeException($message);
}

include $file;

//File just for quick testing

use Assertis\Storage\StorageCsv;
use Assertis\Data\Type\Filename;


//$test = new StorageCsv();
//
//$test->setFilename(new Filename("test.csv","csv"));
//$test->add([1,2,3,4]);
//$test->add([1,2,3,5]);
//
//$test->persist();

use Assertis\Data\Type\File;
$file = new File(new Filename("test.csv"));


echo $file->getSize();