<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;
use Session;

class CustomerController extends Controller
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
        $customers = Customer::get();
        return view('admin.customer',[
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required|string|max:255',
            'address_customer' => 'required',
            'phone_customer' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route("customer.index")->with('danger', $validator->errors()->first());
        }

        // Buat instance Customer
        $customer = new Customer();
        $customer->name_customer = $request->name_customer;
        $customer->address_customer = $request->address_customer;
        $customer->phone_customer = $request->phone_customer;
        if ($customer->save()) {
            return redirect()->route("customer.index")->with('status', "Sukses menambahkan kategori");
        } else {
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan saat menambahkan customer.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        // dd($customer);
        return view('admin.customer-edit',[
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required|string|max:255',
            'address_customer' => 'required',
            'phone_customer' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route("customer.index")->with('danger', $validator->errors()->first());
        }

        // Temukan Customer dengan ID yang sesuai
        $customer = Customer::findOrFail($id);

        // Update atribut model
        $customer->name_customer = $request->name_customer;
        $customer->address_customer = $request->address_customer;
        $customer->phone_customer = $request->phone_customer;

        if ($customer->save()) {
            return redirect()->route("customer.index")->with('status', "Sukses merubah kategori");
        } else {
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Customer::destroy($id)){
            return redirect()->route("customer.index")->with('status', "Sukses menghapus kategori");
        }else {
            return redirect()->route("customer.index")->with('danger', "Terjadi Kesalahan");
        }
    }
}
