<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKey = $request->get('keyword');
        $data = Toko::paginate(10);

        if ($filterKey) {
            $data = Toko::where('nama_toko', 'LIKE', "%$filterKey%")->get();
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'created_at' => Carbon::now()
        ]);

        try {

            $response = Toko::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses nambah toko',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Kesalahan',
                'errors' => $e->getMessage()

            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Toko::find($id);

        $produk = DB::table('produks')->where('nama_toko_id', $id)->get();

        return response()->json([
            'toko' => $data,
            'produk' => $produk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'created_at' => Carbon::now()
        ]);

        try {
            $response = Toko::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses update toko',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Kesalahan',
                'errors' => $e->getMessage()

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $toko = Toko::find($id);
            $toko->delete();

            return response()->json([
                'success' => true,
                'message' => 'sukses menghapus toko',
                'data' => $toko
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Kesalahan',
                'errors' => $e->getMessage()

            ]);
        }
    }
}
