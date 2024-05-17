<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ValidationHelper;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index() {
        $sortBy = request('sort_by', 'created_at');
        $sortOrder = request('sort_order', 'desc');
        $suppliers = Supplier::orderBy($sortBy, $sortOrder)->paginate(10);
        return ResponseHelper::paginated($suppliers);
    }

    public function show($id) {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) {
                throw new Exception("Data not found", 404);
            }
            return ResponseHelper::success($supplier);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'contact_person' => 'nullable|string|min:3|max:255',
            'email' => 'nullable|email|min:3|max:255',
            'phone' => 'nullable|number|min:10|max:15',
            'address' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->contact_person = $request->contact_person ?? null;
        $supplier->email = $request->email ?? null;
        $supplier->phone = $request->phone ?? null;
        $supplier->address = $request->address ?? null;
        $supplier->saveOrFail();

        return ResponseHelper::success($supplier, 'Berhasil menambahkan data');
    }

    public function update(Request $request, $id) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'contact_person' => 'nullable|string|min:3|max:255',
            'email' => 'nullable|email|min:3|max:255',
            'phone' => 'nullable|number|min:10|max:15',
            'address' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->contact_person = $request->contact_person ?? null;
        $supplier->email = $request->email ?? null;
        $supplier->phone = $request->phone ?? null;
        $supplier->address = $request->address ?? null;
        $supplier->saveOrFail();

        return ResponseHelper::success($supplier, 'Berhasil mengubah data');
    }

    public function delete($id) {
        $supplier = Supplier::find($id);
        $supplier->deleteOrFail();

        return ResponseHelper::success($supplier, 'Berhasil menghapus data');
    }
}
