<?php

namespace App\Services\Export;

Interface ExportDataSendable
{
    public function sendExportData() : bool;
}
