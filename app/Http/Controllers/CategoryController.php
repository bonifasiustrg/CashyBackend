<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua data dari tabel
     */
    public function index()
    {
        $category = Category::orderBy('id_category', 'ASC')->get();
        $response = [
            'message' => 'Category list',
            'data' => $category
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
            'category_name' => ['required'],
            'desc' => ['required'],
            'category_status' => ['required', 'in:ordinary,unique'],
            'deadline_date' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel category
            $category = Category::create($request->all());
            $response = [
                'message' => 'Category created',
                'data' => $category
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
        $category = Category::findOrFail($id);

        $response = [
            'message' => 'Category details',
            'data' => $category
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // cek datanya ada atau tidak
         $category = Category::findOrFail($id);

         // validator untuk validasi inputan user sudah benar atau belum
        $validator = Validator::make($request->all(), [
            // syaratnya
            'category_name' => ['required'],
            'desc' => ['required'],
            'category_status' => ['required', 'in:ordinary,unique'],
            'deadline_date' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel transaction
            $category->update($request->all());
            $response = [
                'message' => 'Category updated',
                'data' => $category
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
        $category = Category::findOrFail($id);

        // Jika berhasil
        try {
            // Hasil data yang diinput akan disimpan di variabel category
            $category->delete();
            $response = [
                'message' => 'Category deleted'
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
