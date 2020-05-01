<?php


namespace App\Services\Export;

use \Exception;

class ExportDataFactory
{
    static public $availableMethods = [
        'file' => ExportDataFile::class,
    ];

    /**
     * @param string $method
     * @return ExportDataInterface
     * @throws Exception
     */
    static public function getExportIntance(string $method) : ExportDataInterface {
        if (isset(static::$availableMethods[$method])) {
            return new static::$availableMethods[$method];
        }

        throw new Exception('Unknown export method');
    }
}
