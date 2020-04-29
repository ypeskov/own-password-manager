<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemType;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ItemController extends Controller {
    /**
     * @param Item $item
     * @return Factory|View
     * @throws Exception
     */
    public function view(Item $item) {
        $isEditable = false;
        $viewName = 'views.item';
        $params = array_merge(get_defined_vars(), ['prev_url' => route('board.index')]);

        $item->decrypt(session('enckey'));

        $itemType = ItemType::find($item->item_type_id);
        if ($itemType->name === 'note') {
            $viewName = 'views.item-note';
        }

        return view($viewName, $params);
    }

    /**
     * @param Item $item
     * @return Factory|View
     * @throws Exception
     */
    public function edit(Item $item) {
        $isEditable = true;
        $viewName = 'views.item';
        $params = array_merge(get_defined_vars(), ['prev_url' => route('item.view', $item->id)]);

        $item->decrypt(session('enckey'));

        $itemType = ItemType::find($item->item_type_id);
        if ($itemType->name === 'note') {
            $viewName = 'views.item-note';
        }

        return view($viewName, $params);
    }

    /**
     * @param ItemType $itemType
     * @return Factory|View
     */
    public function newItem(ItemType $itemType) {
        $isEditable = true;
        $item = Item::make();
        $item->item_type_id = $itemType->id;

        $prev_url = url()->previous();

        $viewName = 'views.item';
        switch($itemType->name) {
            case 'note':
                $viewName = 'views.item-note';
                break;
            case 'password':
            default:
                break;
        }

        return view($viewName, get_defined_vars());
    }

    /**
     * @param Item $item
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function delete(Item $item) {
        $item->user_id === Auth::id() || abort(403);

        $item->delete();

        return redirect(url()->previous());
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function save(Request $request) {
        /**
         * @var $item Item
         */
        $item = new Item();

        $fields = $request->only('item_type_id', 'name', 'url', 'folder', 'username', 'password', 'comments');

        //if we are editing the item
        if ($request->has('id') && $request->get('id') !== null) {
            $item = Item::findOrFail($request->get('id'));

            if ($item->user_id !== Auth::id()) {
                abort(403);
            }

            $item->fill($fields);
        } else {
            //otherwise creating the new item
            $item = Item::make($fields);
            $item->fill($fields);
        }

        $item->user_id = Auth::id();

        $valid = $item->validate();
        if (!$valid['isValid']) {
            return Redirect::back()->with('err', $valid['errors']);
        }

        // lets encypt the required fields
        $item->encrypt(session('enckey'));

        try {
            $item->save();
        } catch(QueryException $e) {
            return Redirect::back()->with('err', __('app.Unknown error during saving'));
        }


        return redirect(route('item.view', ['item' => $item->id]));
    }
}
