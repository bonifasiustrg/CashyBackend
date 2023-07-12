<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua data dari tabel
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::orderBy('id_pengeluaran', 'ASC')->get();
        $response = [
            'message' => 'Pengeluaran list',
            'data' => $pengeluaran
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data baru
     */
    public function store(Request $request)
    {
        // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'title' => ['required'],
            'desc' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pengeluaran
            $pengeluaran = Pengeluaran::create($request->all());
            $response = [
                'message' => 'Pengeluaran created',
                'data' => $pengeluaran
            ];
            return response()->json($response, Response::HTTP_CREATED);
        // Jika gagal, $e adalah sebagai objek menyimpan data gagal
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // cek datanya ada atau tidak
        $pengeluaran = Pengeluaran::findOrFail($id);

        $response = [
            'message' => 'Pengeluaran details',
            'data' => $pengeluaran
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // cek datanya ada atau tidak
        $pengeluaran = Pengeluaran::findOrFail($id);

        // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'title' => ['required'],
            'desc' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }       
        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel transaction
            $pengeluaran->update($request->all());
            $response = [
                'message' => 'Pengeluaran updated',
                'data' => $pengeluaran
            ];
            return response()->json($response, Response::HTTP_OK);
        // Jika gagal, $e adalah sebagai objek menyimpan data gagal
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cek datanya ada atau tidak
        $pengeluaran = Pengeluaran::findOrFail($id);

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pengeluaran
            $pengeluaran->delete();
            $response = [
                'message' => 'Pengeluaran deleted'
            ];
            return response()->json($response, Response::HTTP_OK);
        // Jika gagal, $e adalah sebagai objek menyimpan data gagal
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
