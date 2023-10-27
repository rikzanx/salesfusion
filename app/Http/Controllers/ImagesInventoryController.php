<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImagesInventory;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImagesInventoryController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            ImagesInventory::destroy($id);
            DB::commit();
            return redirect()->route("inventory.index")->with('status', "Sukses menghapus gambar product");
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menghapus gambar product".$e->message;
            return redirect()->route("inventory.index")->with('danger', $ea);
        }
    }
}
