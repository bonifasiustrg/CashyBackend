<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormater;
use App\Models\Category;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Category::orderBy('id', 'ASC')->get();

        if ($data){
            return ApiFormater::createApi(200, 'Success', $data);
        } else {
            return ApiFormater::createApi(400, 'Failed');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'category_name' => 'required',
                'desc' => 'sometimes',
                'category_status' => 'required',
                'deadline_date' => 'required'
            ]);

            $category = Category::create([
                'category_name' => $request->category_name,
                'desc' => $request->desc,
                'category_status' => $request->category_status,
                'deadline_date' => $request->deadline_date
            ]);

            $data = Category::find($category->id);

            if ($data){
                return ApiFormater::createApi(200, 'Success', $data);
            } else {
                return ApiFormater::createApi(400, 'Failed, no data found');
            }

        } catch (Exception $error) {
            return ApiFormater::createApi(400, 'Failed', $error->getMessage());
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
        //
        
        try {
            $request->validate([
                'category_name' => 'required',
                'desc' => 'sometimes',
                'category_status' => 'required',
                'deadline_date' => 'required'
            ]);

            $transaction = Category::findOrFail($id);

            $transaction->update([
                'category_name' => $request->category_name,
                'desc' => $request->desc,
                'category_status' => $request->category_status,
                'deadline_date' => $request->deadline_date
            ]);

            // $data = Transaction::where('id','=',$transaction->id)->get();
            $data = Category::find($transaction->id);

            if ($data){
                return ApiFormater::createApi(200, 'Success', $data);
            } else {
                return ApiFormater::createApi(400, 'Failed, no data found');
            }

        } catch (Exception $error) {
            return ApiFormater::createApi(400, 'Failed', $error->getMessage());
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $data = $category->delete();
        // $data = Transaction::find($transaction->id);

        if ($data){
            return ApiFormater::createApi(200, 'Berhasil Menghapus Kategori');
        } else {
            return ApiFormater::createApi(400, 'Failed, no data found');
        }

    }
}
