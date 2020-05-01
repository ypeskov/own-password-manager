<?php

namespace App\Services\Export;

Interface ExportDataSendableInterface
{
    public function sendExportData() : bool;
}
