<?php


namespace App\Services\Export;


class ExportDataGoogleDrive extends ExportData implements ExportDataSendable
{
    public function sendExportData(): bool
    {
        dump('Sending to Google Drive');
        ddd($this->getExportData());
    }
}
