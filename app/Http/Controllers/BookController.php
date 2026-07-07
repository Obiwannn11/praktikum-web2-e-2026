<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->get();

        return response()->json([
            'status' => 'success',
            'data' => BookResource::collection($books),
            'message' => 'Berhasil mengambil semua buku',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new BookResource($book->load('category')),
            'message' => 'Berhasil menambahkan buku',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json([
            'status' => 'success',
            'data' => new BookResource($book->load('category')),
            'message' => 'Berhasil mengambil detail buku',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new BookResource($book->load('category')),
            'message' => 'Berhasil memperbarui buku',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Berhasil menghapus buku',
        ]);
    }
}
