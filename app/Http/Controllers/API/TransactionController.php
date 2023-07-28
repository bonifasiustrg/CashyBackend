<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormater;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Transaction::all();

        if ($data){
            return ApiFormater::createApi(200, 'Success', $data);
        } else {
            return ApiFormater::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'nama' => 'required',
                'nim' => 'required',
                'tanggal' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'description' => 'sometimes',
            ]);

            $transaction = Transaction::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'tanggal' => $request->tanggal,
                'category_id' => $request->category_id,
                'image' => $request->image,
                'description' => $request->description,
            ]);

            // $data = Transaction::where('id','=',$transaction->id)->get();
            $data = Transaction::find($transaction->id);

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
        //
        $data = Transaction::find($id);

        if ($data){
            return ApiFormater::createApi(200, 'Success', $data);
        } else {
            return ApiFormater::createApi(400, 'Failed, no data found');
        }
    }

    public function showTransactionByMonth($month, $year)
{
    // Pastikan $month dan $year berupa angka dan dalam rentang yang benar
    if (!is_numeric($month) || $month < 1 || $month > 12 || !is_numeric($year) || $year < 2000) {
        return ApiFormater::createApi(400, 'Bulan atau tahun tidak valid');
    }

    // Konversi tahun dan bulan ke dalam format yang benar
    $formattedDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';

    // Ambil transaksi berdasarkan bulan dan tahun pada tanggalnya
    $transactions = Transaction::whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->get();
        
    if ($transactions->isEmpty()) {
        $monthName = Carbon::createFromDate(null, $month, null)->format('F');
        return ApiFormater::createApi(404, 'Tidak ada transaksi pada bulan ' . $monthName . ' ' . $year);
    }

    return ApiFormater::createApi(200, 'Transaksi pada bulan ' . Carbon::createFromDate(null, $month, null)->format('F') . ' ' . $year, $transactions);
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
        //
        
        try {
            $request->validate([
                'nama' => 'required',
                'nim' => 'required',
                'tanggal' => 'required',
                'category_id' => 'required',
                'image' => 'required',
                'description' => 'sometimes',
            ]);

            $transaction = Transaction::findOrFail($id);

            $transaction->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'tanggal' => $request->tanggal,
                'category_id' => $request->category_id,
                'image' => $request->image,
                'description' => $request->description,
            ]);

            // $data = Transaction::where('id','=',$transaction->id)->get();
            $data = Transaction::find($transaction->id);

            if ($data){
                return ApiFormater::createApi(200, 'Success', $data);
            } else {
                return ApiFormater::createApi(400, 'Failed, no data found');
            }

        } catch (Exception $error) {
            return ApiFormater::createApi(400, 'Failed', $error->getMessage());
        }

    }

    public function changeTransactionStatus(Request $request, string $id)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'status' => 'required|in:accepted,rejected',
    ]);

    if ($validator->fails()) {
        return ApiFormater::createApi(400, 'Validasi gagal', $validator->errors());
    }

    try {
        // Dapatkan transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Perbarui status transaksi
        $transaction->update([
            'status' => $request->status,
        ]);

        // $data = Transaction::where('id','=',$transaction->id)->get();
        $data = Transaction::find($transaction->id);

        if ($data) {
            return ApiFormater::createApi(200, 'Berhasil mengubah status transaksi', $data);
        } else {
            return ApiFormater::createApi(400, 'Gagal mengubah status transaksi, data tidak ditemukan');
        }

    } catch (Exception $error) {
        return ApiFormater::createApi(400, 'Gagal mengubah status transaksi', $error->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $transaction = Transaction::findOrFail($id);
        $data = $transaction->delete();
        // $data = Transaction::find($transaction->id);

        if ($data){
            return ApiFormater::createApi(200, 'Berhasil Menghapus Transaksi');
        } else {
            return ApiFormater::createApi(400, 'Failed, no data found');
        }

    }
}
