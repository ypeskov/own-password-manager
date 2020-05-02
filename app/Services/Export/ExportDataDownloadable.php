<?php
namespace App\Services\Export;

use App\User;

Interface ExportDataDownloadable {
    /**
     * @param User $user
     * @param bool $isEncrypted
     * @return string
     */
    public function getStringData( User $user, bool $isEncrypted) : string;
}
