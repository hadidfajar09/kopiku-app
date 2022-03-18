<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Produk::getProduk()->paginate(10);

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
            'nama_produk' => 'required',
            'nama_toko_id' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi_produk' => 'required',
            'thumbnail' => 'required|file|mimes:png,jpg,jpeg',
            'multiple_img' => '',
        ]);

        try {
            $fileName = time() . $request->file('thumbnail')->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('uploads/produk', $fileName);
            $validasi['thumbnail'] = $path;
            $response = Produk::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Produk::find($id);

        return response()->json($data);
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
            'nama_produk' => 'required',
            'nama_toko_id' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi_produk' => 'required',
            'thumbnail' => 'file|mimes:png,jpg,jpeg',
            'multiple_img' => '',
        ]);

        try {
            if ($request->file('thumbnail')) {
                $fileName = time() . $request->file('thumbnail')->getClientOriginalName();
                $path = $request->file('thumbnail')->storeAs('uploads/produk', $fileName);
                $validasi['thumbnail'] = $path;
            }

            $response = Produk::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses',
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
            $produk = Produk::find($id);
            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'sukses',
                'data' => $produk
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Kesalahan',
                'errors' => $e->getMessage()

            ]);
        }
    }
}
