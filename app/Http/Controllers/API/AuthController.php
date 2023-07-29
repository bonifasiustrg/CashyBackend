<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormater;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = User::all();

        if ($data){
            return ApiFormater::createApi(200, 'Success', $data);
        } else {
            return ApiFormater::createApi(400, 'Failed');
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = User::find($id);

        if ($data){
            return ApiFormater::createApi(200, 'Success', $data);
        } else {
            return ApiFormater::createApi(400, 'Failed, no data found');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nim' => 'required|numeric',
            'divisi' => 'required',
            'role' => 'sometimes',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        // Set nilai default untuk 'role' jika kosong
        if (empty($input['role'])) {
            $input['role'] = 'anggota';
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;
        $success['nim'] = $user->nim;
        $success['divisi'] = $user->divisi;
        $success['role'] = $user->role;

        return response()->json([
            'success' => true,
            'message' => 'Sukses membuat akun',
            'data' => $success
        ]);
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['nim' => $request->nim, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['user_id'] = $auth->id;
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['divisi'] = $auth->divisi;
            $success['role'] = $auth->role;
            $success['nim'] = $auth->nim;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => $success
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Login gagal, cek nim dan password',
                'data' => null
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        //
        
        try {
            $request->validate([
                'name' => 'required',
                // 'nim' => 'required|numeric',
                'divisi' => 'required',
                'role' => 'sometimes',
                // 'password' => 'required',
                // 'confirm_password' => 'required|same:password'
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                // 'nim' => $request->nim,
                'divisi' => $request->divisi,
                'role' => $request->role
            ]);

            // $data = Transaction::where('id','=',$transaction->id)->get();
            $data = User::find($user->id);

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
        $user = User::findOrFail($id);
        $data = $user->delete();
        // $data = Transaction::find($transaction->id);

        if ($data){
            return ApiFormater::createApi(200, 'Berhasil Menghapus Akun');
        } else {
            return ApiFormater::createApi(400, 'Failed, no data found');
        }

    }
}
