<?php


namespace App\Services\Export;


use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ExportDataDownloadableFile implements ExportDataDownloadableInterface
{
    /**
     * @param bool $isEncoded
     * @return array
     * @throws \Exception
     */
    public function getStringData(bool $isEncoded=true) : string
    {
        $allItems = Item::where('user_id', Auth::user()->id)
            ->orderBy('folder')
            ->orderBy('name')
            ->get();
        $key = session('enckey');
        $items = [];
        $items[] = 'Name,Url,Folder,Username,Password,Comments';
        foreach($allItems as $item) {
            if (!$isEncoded) {
                $item = $item->decrypt($key);
            }
            $items[] = $item->name.','
                .$item->url.','
                .$item->folder.','
                .$item->username.','
                .$item->password.','
                .$item->comments;
        }

        return implode("\n", $items);
    }
}
