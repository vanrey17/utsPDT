<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Http\Resources\BooksResource;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Daftar buku berhasil diambil',
            'data' => BooksResource::collection(Book::all())
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
            //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['string', 'max:255'],
            'isbn' => [ 'string', 'max:20', 'unique:books,isbn'],
            'publish_year' => [ 'integer', 'digits:4'],
            'publisher' => [ 'string', 'max:255'],
            'category_id' => [ 'exists:categories,id']
        ], [
            'title.required' => 'Field title harus diisi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->publish_year = $request->publish_year;
        $book->publisher = $request->publisher;
        $book->category_id = $request->category_id;
        $book->save();

        return response()->json([
            'message' => 'Buku berhasil dibuat',
            'data' => new BooksResource($book)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail buku berhasil diambil',
            'data' => new BooksResource($book)
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
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:20', 'unique:books,isbn,' . $id],
            'publish_year' => ['required', 'integer', 'digits:4'],
            'publisher' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id']
        ], [
            'title.required' => 'Field title harus diisi',
            'author.required' => 'Field author harus diisi',
            'isbn.required' => 'Field isbn harus diisi',
            'isbn.unique' => 'ISBN sudah terdaftar, silakan gunakan ISBN lain',
            'publish_year.required' => 'Field publish_year harus diisi',
            'publish_year.integer' => 'Field publish_year harus berupa angka',
            'publish_year.digits' => 'Field publish_year harus terdiri dari 4 digit',
            'publisher.required' => 'Field publisher harus diisi',
            'category_id.required' => 'Field category_id harus diisi',
            'category_id.exists' => 'Kategori tidak ditemukan, pastikan category_id valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
    }

        $book->update($request->all());

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => new BooksResource($book)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}
