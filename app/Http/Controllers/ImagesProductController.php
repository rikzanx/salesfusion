<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImagesProduct;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImagesProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreSuratPenawaranItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuratPenawaranItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratPenawaranItem  $suratPenawaranItem
     * @return \Illuminate\Http\Response
     */
    public function show(SuratPenawaranItem $suratPenawaranItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratPenawaranItem  $suratPenawaranItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratPenawaranItem $suratPenawaranItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratPenawaranItemRequest  $request
     * @param  \App\Models\SuratPenawaranItem  $suratPenawaranItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratPenawaranItemRequest $request, SuratPenawaranItem $suratPenawaranItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratPenawaranItem  $suratPenawaranItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            ImagesProduct::destroy($id);
            DB::commit();
            return redirect()->route("produk.index")->with('status', "Sukses menghapus gambar product");
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menghapus gambar product".$e->message;
            return redirect()->route("produk.index")->with('danger', $ea);
        }
    }
}
