<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => CategoryResource::collection($categories)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30', 'unique:categories,name', 'alpha:ascii'],
            'description' => ['nullable', 'string']
        ], [
            'name.required' => 'Field name harus diisi',
            'name.max' => 'Field name maksimal 30 karakter',
            'name.unique' => 'Nama kategori sudah terdaftar, silakan gunakan nama lain',
            'name.alpha' => 'Field name hanya boleh berisi huruf'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mencari data berdasarkan ID
        $category = Category::find($id);

        // Validasi jika data tidak ditemukan
        if (!$category) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Mengembalikan data jika ditemukan
        return response()->json([
            'message' => 'Detail Category berhasil diambil',
            'data' => new CategoryResource($category)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30', 'unique:categories,name,' . $id, 'alpha:ascii']
        ], [
            'name.required' => 'Field name harus diisi',
            'name.max' => 'Field name maksimal 30 karakter',
            'name.unique' => 'Nama kategori sudah terdaftar, silakan gunakan nama lain',
            'name.alpha' => 'Field name hanya boleh berisi huruf'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        // PERBAIKAN: Ubah pesan agar sesuai dengan konteks update
        return response()->json([
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }


    }
}
