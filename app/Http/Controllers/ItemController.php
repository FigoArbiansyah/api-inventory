<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ValidationHelper;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index() {
        $sortBy = request('sort_by', 'created_at');
        $sortOrder = request('sort_order', 'desc');
        $items = Item::with('category', 'location', 'supplier')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);
        return ResponseHelper::paginated($items);
    }

    public function show($id) {
        try {
            $item = Item::find($id);
            if (!$item) {
                throw new Exception("Data not found", 404);
            }
            return ResponseHelper::success($item);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name'          => 'required|string|min:3|max:255',
            'sku'           => 'required|unique:items,sku|string|min:3|max:255',
            'description'   => 'nullable|string|min:3|max:255',
            'quantity'      => 'required|integer',
            'price'         => 'required|integer',
            'reorder_level' => 'required|integer',
            'image'         => 'nullable|image|mimes:png,jpg,jpeg|max:2096',
            'category_id'   => 'required',
            'location_id'   => 'required',
            'supplier_id'   => 'required',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        // Path for uploaded image
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Save image
            // Simpan gambar ke direktori public
            $imageName = 'item-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $imagePath = $imageName;
        }

        $item = new Item();
        $item->name = $request->name;
        $item->sku = $request->sku ?? md5($request->name);
        $item->description = $request->description ?? null;
        $item->quantity = $request->quantity ?? 0;
        $item->price = $request->price;
        $item->reorder_level = $request->reorder_level ?? 0;
        $item->category_id = $request->category_id;
        $item->location_id = $request->location_id;
        $item->supplier_id = $request->supplier_id;
        $item->image = $imagePath;
        $item->saveOrFail();

        return ResponseHelper::success($item, 'Berhasil menambahkan data');
    }

    public function update(Request $request, $id) {
        $validatedData = Validator::make($request->all(), [
            'name'          => 'required|string|min:3|max:255',
            'sku'           => 'nullable|string|min:3|max:255',
            'description'   => 'nullable|string|min:3|max:255',
            'quantity'      => 'required|integer',
            'price'         => 'required|integer',
            'reorder_level' => 'required|integer',
            'image'         => 'nullable|image|mimes:png,jpg,jpeg|max:2096',
            'category_id'   => 'required',
            'location_id'   => 'required',
            'supplier_id'   => 'required',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $item = Item::find($id);

        // Path for uploaded image
        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            // Delete past image
            $_image = public_path('uploads/' . $item->image);
            if (file_exists($_image)) {
                unlink($_image); // Hapus gambar dari folder public
            }
            // Save image
            // Simpan gambar ke direktori public
            $imageName = 'item-update-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $imagePath = $imageName;
        }

        $item->name = $request->name;
        $item->sku = ($request->sku !== $item->sku ? $request->sku : $item->sku) ?? md5($request->name);
        $item->description = $request->description ?? null;
        $item->quantity = $request->quantity ?? 0;
        $item->price = $request->price;
        $item->reorder_level = $request->reorder_level ?? 0;
        $item->category_id = $request->category_id;
        $item->location_id = $request->location_id;
        $item->supplier_id = $request->supplier_id;
        $item->image = $imagePath;
        $item->saveOrFail();

        return ResponseHelper::success($item, 'Berhasil mengubah data');
    }

    public function delete($id) {
        $item = Item::find($id);
        // Hapus gambar terkait jika ada
        if ($item->image) {
            $imagePath = public_path('uploads/' . $item->image);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Hapus gambar dari folder public
            }
        }
        $item->deleteOrFail();

        return ResponseHelper::success($item, 'Berhasil menghapus data');
    }
}
