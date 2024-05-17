<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\ValidationHelper;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index() {
        $sortBy = request('sort_by', 'created_at');
        $sortOrder = request('sort_order', 'desc');
        $locations = Location::orderBy($sortBy, $sortOrder)->paginate(10);
        return ResponseHelper::paginated($locations);
    }

    public function show($id) {
        try {
            $location = Location::with('items')->find($id);
            if (!$location) {
                throw new Exception("Data not found", 404);
            }
            return ResponseHelper::success($location);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $location = new Location();
        $location->name = $request->name;
        $location->description = $request->description ?? null;
        $location->saveOrFail();

        return ResponseHelper::success($location, 'Berhasil menambahkan data');
    }

    public function update(Request $request, $id) {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:255',
        ]);

        if ($validatedData->fails()) {
            return ValidationHelper::validate($validatedData);
        }

        $location = Location::find($id);
        $location->name = $request->name;
        $location->description = $request->description ?? null;
        $location->saveOrFail();

        return ResponseHelper::success($location, 'Berhasil mengubah data');
    }

    public function delete($id) {
        $location = Location::find($id);
        $location->deleteOrFail();

        return ResponseHelper::success($location, 'Berhasil menghapus data');
    }
}
