<?php


namespace App\Services\Export;


use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\User;

class ExportDataFile extends ExportData implements ExportDataDownloadable
{
    /**
     * @param bool $isEncrypted
     * @param User $user
     * @return string
     */
    public function getStringData(User $user, bool $isEncrypted=true) : string
    {
        return implode("\n", $this->prepareData($user, $isEncrypted)->getExportData());
    }
}
