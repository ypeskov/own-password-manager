<?php


namespace App\Services\Export;


use App\Models\Item;
use App\User;
use Illuminate\Support\Facades\Auth;

abstract class ExportData
{
    public function prepareData(User $user, bool $isEncrypted=true) : array
    {
        $allItems = Item::where('user_id', Auth::user()->id)
            ->orderBy('folder')
            ->orderBy('name')
            ->get();

        $key = session('enckey');

        $items = [];
        $items[] = 'Name,Url,Folder,Username,Password,Comments';

        foreach($allItems as $item) {
            if (!$isEncrypted) {
                $item = $item->decrypt($key);
            }
            $items[] = $item->name.','
                .$item->url.','
                .$item->folder.','
                .$item->username.','
                .$item->password.','
                .$item->comments;
        }

        return  $items;
    }
}
