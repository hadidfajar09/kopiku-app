<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Carbon\Carbon;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProduk(Request $request)
    {
        $filterKey = $request->get('keyword');
        $data = Produk::paginate(5);

        if ($filterKey) {
            $data = Produk::where('nama_produk', 'LIKE', "%$filterKey%")->paginate(5);
        }

        return response()->json($data);
    }
    public function index(Request $request)
    {
        // $filterKey = $request->get('keyword');
        // $data = Produk::getProduk()->paginate(5);

        // if ($filterKey) {
        //     $data = Produk::getProduk()->where('nama_produk', 'LIKE', "%$filterKey%")->paginate(5);
        // }

        // return response()->json($data);

        //Query
        $id = $request->input('nama_toko_id');
        $produk = DB::table('produks')->where([
            ['nama_toko_id', $id]
        ])
        ->join('tokos', 'produks.nama_toko_id', 'tokos.id')
        // ->join('subcategories', 'produks.subnama_toko_id', 'subcategories.id')
        ->select('produks.*', 'tokos.nama_toko', 'tokos.image')
        ->orderBy('id','desc')->paginate(20);

        $filterKey = $request->get('keyword');
        

        if ($filterKey) {
            $key = DB::table('produks')->where('nama_produk', 'LIKE', "%$filterKey%")
            ->join('tokos', 'produks.nama_toko_id', 'tokos.id')
            // ->join('subcategories', 'produks.subnama_toko_id', 'subcategories.id')
            ->select('produks.*', 'tokos.nama_toko', 'tokos.image')
            ->orderBy('id','desc')->paginate(20);
            return response()->json([
                'status' => 'ok',
                'reply' => 'List ditemmukan',
                'totalProduk' => DB::table('produks')->count(),
                'totalResults' => $key->count(),
                'produks' => $key
            ], 200);
        }

        

        if ($produk->isEmpty()) {
            return response()->json([
                'status' => 'kosong',
                'reply' => 'Produk tidak ditemukan dengan kategori tersebut'
            ], 200);
        } else {
            return response()->json([
                'status' => 'ok',
                'reply' => 'List ditemmukan',
                'totalProduk' => DB::table('produks')->count(),
                'totalResults' => $produk->count(),
                'produks' => $produk
                
            ], 200);
        }
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
            'created_at' => Carbon::now()
        ]);

        try {
            $fileName = time() . $request->file('thumbnail')->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('uploads/produk', $fileName);
            $validasi['thumbnail'] = $path;
            $response = Produk::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses nambah produk',
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
        $data = Produk::find($id);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
            'created_at' => Carbon::now()
        ]);

        try {
            $response = Produk::find($id);
            if ($request->file('thumbnail')) {
                Storage::disk('public')->delete($response->thumbnail);
                $fileName = time() . $request->file('thumbnail')->getClientOriginalName();
                $path = $request->file('thumbnail')->storeAs('uploads/produk', $fileName);
                $validasi['thumbnail'] = $path;
            }


            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message' => 'sukses nambah produk',
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
            Storage::disk('public')->delete($produk->thumbnail);
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

    function getByToko(Request $request)
    {
        $id = $request->input('nama_toko_id');
        $produk = Produk::where([
            ['nama_toko_id', $id]
        ])->paginate(5);
        if ($produk->isEmpty()) {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Produk tidak ditemukan dengan kategori tersebut'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'msg' => $produk
        ]);
    }
}
