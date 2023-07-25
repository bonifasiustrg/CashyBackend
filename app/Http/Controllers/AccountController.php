<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua data dari tabel
     */
    public function index()
    {
        $account = Account::orderBy('id_account', 'ASC')->get();
        $response = [
            'message' => 'Account list',
            'data' => $account
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
            'username' => ['required'],
            'password' => ['required'],
            'nim' => ['required', 'numeric'],
            'id_role' => ['required', 'in:1,2']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel account
            $account = Account::create($request->all());
            $response = [
                'message' => 'Account created',
                'data' => $account
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
        $account = Account::findOrFail($id);

        $response = [
            'message' => 'Account details',
            'data' => $account
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // cek datanya ada atau tidak
        $account = Account::findOrFail($id);

        // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'username' => ['required'],
            'password' => ['required'],
            'nim' => ['required', 'numeric'],
            'id_role' => ['required', 'in:1,2']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel transaction
            $account->update($request->all());
            $response = [
                'message' => 'Account updated',
                'data' => $account
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
        $account = Account::findOrFail($id);

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel account
            $account->delete();
            $response = [
                'message' => 'Account deleted'
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
