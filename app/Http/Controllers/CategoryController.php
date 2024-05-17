<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ValidationHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {
        $sortBy = request('sort_by', 'created_at');
        $sortOrder = request('sort_order', 'desc');
        $categories = Category::orderBy($sortBy, $sortOrder)->paginate(10);
        return ResponseHelper::paginated($categories);
    }

    public function show($id) {
        $category = Category::with('items')->find($id);
        return ResponseHelper::success($category);
    }

    public function store(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description ?? null;
        $category->saveOrFail();

        return ResponseHelper::success($category, 'Berhasil menambahkan data');
    }

    public function update(Request $request, $id) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description ?? null;
        $category->saveOrFail();

        return ResponseHelper::success($category, 'Berhasil mengubah data');
    }

    public function delete($id) {
        $category = Category::find($id);
        $category->deleteOrFail();

        return ResponseHelper::success($category, 'Berhasil menghapus data');
    }
}
