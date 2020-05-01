<?php
namespace App\Services\Export;

Interface ExportDataDownloadableInterface {
    public function getStringData(bool $isEncoded) : string;
}
