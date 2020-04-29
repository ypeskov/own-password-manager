<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class DataSourceController extends Controller
{
    /**
     * @return ItemType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getItemTypes() {
        return ItemType::where('is_enabled', 1)->get();
    }
}
