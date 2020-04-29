<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BoardController extends Controller {

    public function __construct() {
    }

    /**
     * @param Request $request
     * @param string|null $itemType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, string $itemType='') {
        $filter = null;
        if ($request->has('search')) {
            $filter = $request->get('search');
        }

        if (strlen($itemType) > 0) {
            $type = mb_strtolower($itemType);

            switch($type) {
                case 'note':
                    $items = $this->getNotes();
                    break;
                case 'password':
                default:
                    $items = $this->getPasswords();
                    break;
            }
        } else {
            $items = $this->getAllItems($filter);
        }

        $type = ItemType::firstWhere('name', $itemType);
        if ($type === null) {
            $route = route('board.index');
        } else {
            $route = route('board.index', $type->name);
        }

        $items = $this->adjustEmptyFolderName($items);

        return view('views.board', [
            'items' => $items,
            'activeMenu' => $itemType,
            'route' => $route,
        ]);
    }

    private function adjustEmptyFolderName($items) {
        $length = sizeof($items);

        for($i=0; $i<$length; $i++) {
            if ($items[$i]->folder === null || $items[$i]->folder === ''){
                $items[$i]->folder = 'None';
            }
            $items[$i]->show = false;
        }

        return $items;
    }

    public function getAllItems(string $filter=null) {
        if ($filter) {
            $whereStr = '%'.$filter.'%';

            $items = Item::where('name', 'like', $whereStr)
                ->orWhere('username', 'like', $whereStr)
                ->orWhere('url', 'like', $whereStr)
                ->orWhere('folder', 'like', $whereStr)
                ->orWhere('comments', 'like', $whereStr)
                ->Where('user_id', Auth::id())
                ->orderBy('folder')
                ->orderBy('name')
                ->get();
        } else {
            $items = Item::where('user_id', Auth::id())
                ->orderBy('folder')
                ->orderBy('name')
                ->get(['id', 'name', 'folder', 'updated_at']);
        }

        return $items;
    }

    /**
     * @return Collection
     */
    public function getPasswords() {
        $passwordType = ItemType::where('name', 'password')->firstOrFail();

        return Item::where('user_id', Auth::id())
            ->where('item_type_id', $passwordType->id)
            ->orderBy('folder')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection
     */
    public function getNotes() {
        $noteType = ItemType::where('name', 'note')->firstOrFail();

        return Item::where('user_id', Auth::id())
            ->where('item_type_id', $noteType->id)
            ->orderBy('folder')
            ->orderBy('name')
            ->get();
    }
}
