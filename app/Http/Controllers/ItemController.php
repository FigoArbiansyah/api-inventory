<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {
        $items = Item::with('category', 'location', 'supplier')->paginate(10);
        return ResponseHelper::paginated($items);
    }
}
