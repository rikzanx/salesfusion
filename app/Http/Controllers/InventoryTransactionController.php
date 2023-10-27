<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Validator;
use session;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory_transactions = InventoryTransaction::with('inventory')->get();
        return view('admin.inventorytransaction',[
            'inventory_transactions' => $inventory_transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventories = Inventory::get();
        return view('admin.inventorytransaction-create',[
            'inventories' => $inventories
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
            'inventory_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'notes' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("inventorytransaction.index")->with('danger', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $inventory = Inventory::findOrFail($request->inventory_id);
            $inventory->qty = $inventory->qty + $request->quantity;
            $inventory->save();

            $inventory_transaction= new InventoryTransaction();
            $inventory_transaction->inventory_id = $request->inventory_id;
            $inventory_transaction->type = $request->type;
            $inventory_transaction->quantity = $request->quantity;
            $inventory_transaction->notes = $request->notes;
            $inventory_transaction->save();
            //commit
            DB::commit();
            return redirect()->route("inventorytransaction.index")->with('status', "Sukses menambhakan transaksi inventory");
        } catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambahkan kategori".$e->message;
            return redirect()->route("inventorytransaction.index")->with('danger', $ea);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory_transaction = InventoryTransaction::with('inventory')->findOrFail($id);
        $inventories = Inventory::get();
        // dd($category);
        return view('admin.inventorytransaction-edit',[
            'inventory_transaction' => $inventory_transaction,
            'inventories' => $inventories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'inventory_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'notes' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route("inventorytransaction.index")->with('danger', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $inventory_transaction= InventoryTransaction::findOrFail($id);
            $inventory_transaction->inventory_id = $request->inventory_id;
            $inventory_transaction->type = $request->type;
            $inventory_transaction->quantity = $request->quantity;
            $inventory_transaction->notes = $request->notes;
            $inventory_transaction->save();

            $inventory = Inventory::findOrFail($request->inventory_id);
            $inventory->qty = ($inventory->qty - $inventory_transaction->quantity )+ $request->quantity;
            $inventory->save();

            //commit
            DB::commit();
            return redirect()->route("inventorytransaction.index")->with('status', "Sukses merubah transaksi inventory");
        } catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat merubah transaksi inventory".$e->message;
            return redirect()->route("inventorytransaction.index")->with('danger', $ea);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $inventory_transaction= InventoryTransaction::findOrFail($id);
            $inventory_transaction->save();
            
            $inventory = Inventory::findOrFail($request->inventory_id);
            $inventory->qty = ($inventory->qty - $inventory_transaction->quantity);
            $inventory->save();
            
            InventoryTransaction::destroy($id);
            DB::commit();
            return redirect()->route("inventorytransaction.index")->with('status', "Sukses menghapus transaksi inventory");
        }catch (\Exception $e) {
            DB::rollback();
            $ea = "Terjadi Kesalahan saat merubah transaksi inventory".$e->message;
            return redirect()->route("inventorytransaction.index")->with('danger', $ea);
        }
    }
}
