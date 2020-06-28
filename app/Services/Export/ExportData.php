<?php


namespace App\Services\Export;


use App\Models\Item;
use App\User;
use Illuminate\Support\Facades\Auth;

abstract class ExportData
{
    /**
     * @var array
     */
    private $exportData = [];

    /**
     * @var string
     */
    private $enckey;

    public function __construct(string $enckey)
    {
        $this->enckey = $enckey;
    }

    /**
     * @param User $user
     * @param bool $isEncrypted
     * @return ExportData
     */
    public function prepareData(User $user, bool $isEncrypted=true) : ExportData
    {
        $allItems = Item::where('user_id', $user->id)
            ->orderBy('folder')
            ->orderBy('name')
            ->get();

        $this->exportData = [];
        $this->exportData[] = 'Name,Url,Folder,Username,Password,Comments';

        foreach($allItems as $item) {
            if (!$isEncrypted) {
                $item = $item->decrypt($this->enckey);
            }
            $this->exportData[] = $item->name.','
                .$item->url.','
                .$item->folder.','
                .$item->username.','
                .$item->password.','
                .$item->comments;
        }

        return  $this;
    }

    /**
     * @return array
     */
    public function getExportData() : array
    {
        return $this->exportData;
    }
}
