<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan_verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PemasukanVerifiedController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua data dari tabel
     */
    public function index()
    {
        $pemasukanVerified = Pemasukan_verified::orderBy('id_pemasukan', 'ASC')->get();
        $response = [
            'message' => 'Pemasukan verified list',
            'data' => $pemasukanVerified
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * Menambah data baru
     */
    public function store(Request $request)
    {
        // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'desc' => ['required'],
            'nominal' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pemasukanVerified
            $pemasukanVerified = Pemasukan_verified::create($request->all());
            $response = [
                'message' => 'Pemasukan created',
                'data' => $pemasukanVerified
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
        $pemasukanVerified = Pemasukan_verified::findOrFail($id);

        $response = [
            'message' => 'Pemasukan details',
            'data' => $pemasukanVerified
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cek datanya ada atau tidak
        $pemasukanVerified = Pemasukan_verified::findOrFail($id);

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pemasukanVerified
            $pemasukanVerified->delete();
            $response = [
                'message' => 'Pemasukan deleted'
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
