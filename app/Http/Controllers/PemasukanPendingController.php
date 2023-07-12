<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan_pending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PemasukanPendingController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua data dari tabel
     */
    public function index()
    {
        $pemasukanPending = Pemasukan_pending::orderBy('id_pemasukan', 'ASC')->get();
        $response = [
            'message' => 'Pemasukan pending list',
            'data' => $pemasukanPending
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
            'desc' => ['required'],
            'nominal' => ['required', 'numeric'],
            'status' => ['required', 'in:overdue,ontime']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pemasukanPending
            $pemasukanPending = Pemasukan_pending::create($request->all());
            $response = [
                'message' => 'Pemasukan created',
                'data' => $pemasukanPending
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
        $pemasukanPending = Pemasukan_pending::findOrFail($id);

        $response = [
            'message' => 'Pemasukan details',
            'data' => $pemasukanPending
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // cek datanya ada atau tidak
        $pemasukanPending = Pemasukan_pending::findOrFail($id);

        // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'desc' => ['required'],
            'nominal' => ['required', 'numeric'],
            'status' => ['required', 'in:overdue,ontime']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel transaction
            $pemasukanPending->update($request->all());
            $response = [
                'message' => 'Pemasukan updated',
                'data' => $pemasukanPending
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
        $pemasukanPending = Pemasukan_pending::findOrFail($id);

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel pemasukanPending
            $pemasukanPending->delete();
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
