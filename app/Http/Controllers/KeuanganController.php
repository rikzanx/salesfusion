<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Company;

use Illuminate\Http\Request;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keuangan = Keuangan::orderBy('created_at','ASC')->get();
        $sumPemasukan = Keuangan::where('tipe', 'pemasukan')->sum('amount');
        $sumPengeluaran = Keuangan::where('tipe','!=','pemasukan')->sum('amount');
        // dd($sumPengeluaran);
        $saldo = $sumPemasukan-$sumPengeluaran;
        return view('admin.keuangan',[
            'keuangan' => $keuangan,
            'saldo' => $saldo,
            'sumPemasukan' => $sumPemasukan,
            'sumPengeluaran' => $sumPengeluaran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.keuangan-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'tipe' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("keuangan.create")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);
        DB::beginTransaction();
        try {
            // $wallet = Wallet::findOrFail($request->wallet_id);
            $company = Company::firstOrFail();
            $keuangan = new Keuangan();
            $amount = preg_replace('/[\,\.]/', '', $request->amount);
            $keuangan->amount = $amount;
            $keuangan->tipe = $request->tipe;
            $keuangan->description = nl2br($request->description);

            $balance_after = ($request->tipe == "pemasukan")? $company->saldo + $amount : $company->saldo - $amount;
            $keuangan->balance_after = $balance_after;
            $keuangan->save();

            $company->saldo = $balance_after;
            $company->save();
            DB::commit();
            return redirect()->route("keuangan.index")->with('status', "Sukses menambahkan keuangan");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menambahkan keuangan".$e->message;
            return redirect()->route("keuangan.index")->with('danger', $ea);
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
        DB::beginTransaction();
        try{
            $keuangan = Keuangan::findOrFail($id);
            $company = Company::firstOrFail();
            $balance_after = ($keuangan->tipe == "pemasukan")? $company->saldo - $keuangan->amount : $company->saldo + $keuangan->amount;
            $company->saldo = $balance_after;
            $company->save();
            Keuangan::destroy($id);
            DB::commit();
            return redirect()->route("keuangan.index")->with('status', "Sukses menghapus transaksi");
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menghapus transaksi".$e->message;
            return redirect()->route("keuangan.index")->with('danger', $ea);
        }
    }
}
