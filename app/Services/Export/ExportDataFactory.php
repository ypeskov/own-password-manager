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
     * @param string $enckey
     * @return mixed
     * @throws Exception
     */
    static public function getExportIntance(string $method, string $enckey='') : ExportData  {
        if (isset(static::$availableMethods[$method])) {
            return new static::$availableMethods[$method]($enckey);
        }

        throw new Exception('Unknown export method');
    }
}
