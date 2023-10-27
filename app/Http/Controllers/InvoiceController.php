<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Inventory;
use Validator;
use session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('items','customer')->get();
        
        foreach($invoices as $inv){
            $inv->total=0;
            foreach($inv->items as $item){
                $inv->total += $item->total;
            }
        }
        return view('admin.invoice',[
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        $inventories = Inventory::get();
        return view('admin.invoice-create',[
            "customers" => $customers,
            "inventories" => $inventories
        ]);
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
            'customer_id' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required',
            'dp' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);
        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $now = Carbon::parse($request->duedate);
            // dd($now->startOfMonth()->toDateTimeString());
            $latestInvoice = Invoice::where('created_at','>=',$now->startOfMonth()->toDateTimeString())->where('created_at','<=',$now->endOfMonth()->toDateTimeString())->orderBy('id','DESC')->first();
            if($latestInvoice === null){
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/0001";
                $invoice->id_inv = 1;
            }else{
                $invoice->no_invoice = $now->year."/INV/".$now->isoformat('MM')."/".sprintf('%04d', $latestInvoice->id_inv+1);
                $invoice->id_inv = $latestInvoice->id_inv+1;
            }
            $invoice->duedate = $request->duedate;
            $invoice->tanggal_pengiriman = $request->tanggal_pengiriman;
            $invoice->customer_id = $request->customer_id;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            $invoice->dp = $request->dp;
            if($request->has('comment')){
                
                $invoice->comment = $request->comment;
            }
            $invoice->save();
            for($i=0;$i<count($request->inventory_id);$i++){
                $item = new Item();
                $item->duedate = $request->duedate;
                $item->invoice_id = $invoice->id;
                $item->item_of = "pcs";
                $item->inventory_id = $request->inventory_id[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses menambahkan invoice");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menambahkan invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
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
        $invoice = Invoice::with('items','customer')->where('id',$id)->firstOrFail();
        // dd($invoice);

        return view('admin.invoice-show',[
            'invoice' => $invoice,
            'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
        ]);
    }

    public function surat_jalan($id)
    {
        $invoice = Invoice::with('items','customer')->where('id',$id)->firstOrFail();
        // dd($invoice);
        return view('admin.surat-jalan',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->format('Y-m-d'),
        'tanggal_pengiriman' => Carbon::createFromFormat('Y-m-d', $invoice->tanggal_pengiriman)->format('Y-m-d'),
        ]);
    }

    public function show_proform($id)
    {
        $invoice = Invoice::with('items','customer')->where('id',$id)->firstOrFail();
        // dd($invoice);
        return view('admin.invoice-show-proform',[
            'invoice' => $invoice,
        'date_inv' => Carbon::createFromFormat('Y-m-d', $invoice->duedate)->addDays(7)->format('Y-m-d'),
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
        $customers = Customer::get();
        $inventories = Inventory::get();
        $invoice = Invoice::with('items','customer')->where('id',$id)->firstOrFail();
        return view('admin.invoice-edit',[
            "invoice" => $invoice,
            "customers" => $customers,
            "inventories" => $inventories
        ]);
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
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'item_price' => 'required',
            'diskon_rate' => 'required',
            'tax_rate' => 'required',
            'profit' => 'required',
            'dp' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("invoice.index")->with('danger', $validator->errors()->first());
        }
        // dd($request->comment);

        // foreach($invoices as $a){
        //     Item::where('invoice_id', $a->id)
        //     ->update([
        //         'duedate' => $a->duedate
        //         ]);
        // }
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->duedate = $request->duedate;
            $invoice->tanggal_pengiriman = $request->tanggal_pengiriman;
            $invoice->customer_id = $request->customer_id;
            $invoice->diskon_rate = $request->diskon_rate;
            $invoice->tax_rate = $request->tax_rate;
            $invoice->profit = $request->profit;
            $invoice->dp = $request->dp;
            if($request->has('comment')){
                $invoice->comment = $request->comment;
            }
            $invoice->save();
            $delete = Item::where('invoice_id',$id)->delete();
            for($i=0;$i<count($request->inventory_id);$i++){
                $item = new Item();
                $item->duedate = $request->duedate;
                $item->invoice_id = $invoice->id;
                $item->item_of = "pcs";
                $item->inventory_id = $request->inventory_id[$i];
                $item->qty = $request->qty[$i];
                $item->item_price = $request->item_price[$i];
                $item->save();
            }
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses merubah invoice");
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat merubah invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
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
            Invoice::destroy($id);
            Item::where("invoice_id",'=',$id)->delete();
            DB::commit();
            return redirect()->route("invoice.index")->with('status', "Sukses menghapus invoice");
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            $ea = "Terjadi Kesalahan saat menghapus invoice".$e->message;
            return redirect()->route("invoice.index")->with('danger', $ea);
        }
    }
}
