<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Http\Resources\BorrowResource;
use App\Models\Borrow;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = Borrow::with(['book', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => BorrowResource::collection($borrows),
            'message' => 'Berhasil mengambil semua data peminjaman',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {
        $borrow = Borrow::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new BorrowResource($borrow->load(['book', 'user'])),
            'message' => 'Berhasil menambahkan data peminjaman',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        return response()->json([
            'status' => 'success',
            'data' => new BorrowResource($borrow->load(['book', 'user'])),
            'message' => 'Berhasil mengambil detail peminjaman',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        $borrow->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new BorrowResource($borrow->load(['book', 'user'])),
            'message' => 'Berhasil memperbarui data peminjaman',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();

        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Berhasil menghapus data peminjaman',
        ]);
    }
}
