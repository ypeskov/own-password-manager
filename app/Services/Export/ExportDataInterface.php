<?php
namespace App\Services\Export;

Interface ExportDataInterface {
    public function getStringData(bool $isEncoded) : string;
}
