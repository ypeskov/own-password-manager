<?php


namespace App\Services\Export;

use \Exception;

class ExportDataFactory
{
    static public $availableMethods = [
        'file' => ExportDataFile::class,
        'google-drive' => ExportDataGoogleDrive::class,
    ];

    /**
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    static public function getExportIntance(string $method)  {
        if (isset(static::$availableMethods[$method])) {
            return new static::$availableMethods[$method];
        }

        throw new Exception('Unknown export method');
    }
}
