<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;


class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.toko.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data()
    {
        $toko = Toko::orderBy('id','desc')->get();

        return datatables()
            ->of($toko)//source
            ->addIndexColumn() //untuk nomer
            ->addColumn('aksi', function($toko){ //untuk aksi
                $button = '<div class="btn-group"><button onclick="editForm(`'.route('toko.update', $toko->id).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button><button onclick="deleteData(`'.route('toko.destroy', $toko->id).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button> </div>';

               return $button;
               
            })
            ->rawColumns(['aksi'])//biar kebaca
            ->make(true);
    }

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
            'image' => 'sometimes|file|mimes:png,jpg,jpeg',
        ]);


        $image = $request->file('image');

     
            $fileName = time() . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/toko', $fileName);
            $validasi['image'] = $path;
            
            Toko::create($validasi);

       return response()->json('Data berhasil disimpan',200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $toko = Toko::find($id);
        return response()->json($toko);
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
        $toko = Toko::find($id);
        $validasi = $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'image' => 'sometimes|file|mimes:png,jpg,jpeg',
        ]);
        
        if($image = $request->file('image')){
            Storage::disk('public')->delete($toko->image);
            $fileName = time() . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/toko', $fileName);
            $validasi['image'] = $path;
            $toko->update($validasi);
            return response()->json('Data berhasil disimpan',200);
        }else{
            $toko->update($validasi);
            return response()->json('Data berhasil disimpan',200);
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
        $toko = Toko::find($id);
        Storage::disk('public')->delete($toko->image);
        $toko->delete();

        return response()->json('data berhasil dihapus');
    }
}
