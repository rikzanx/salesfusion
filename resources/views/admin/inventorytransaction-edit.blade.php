@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.company.name', 'Laravel') }} - Transaksi Inventory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Transaksi Inventory</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Produk</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('produk.update',$product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label>Inventory <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-primary">Tambah Inventory</a></label>
                    <select class="form-control" name="inventory_id" id="inventorySelect">
                      @foreach ($inventories as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $inventory_controller->inventory_id)?'selected':'' }}  >{{$item->sku}} - {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tipe Transaksi</label>
                    <select class="form-control" name="type" id="tipeSelect">
                      <option value="masuk" {{ ("masuk" == $inventory_controller->type)?'selected':'' }}>Masuk</option>
                      <option value="keluar" {{ ("keluar" == $inventory_controller->type)?'selected':'' }}>Keluar</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah</label>
                    <input value="{{ $inventory_transaction->quantity }}" type="number" name="quantity" class="form-control" id="exampleInputEmail1" placeholder="Masukkan jumlah" >
                  </div>
                  <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Enter ...">
                    {{ $inventory_transaction->notes }}"
                    </textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-primary">Ganti</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-add-image").click(function(){ 
        var lsthmtl = $(".clone").html();
        $(".increment").after(lsthmtl);
    });
    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".hdtuto").remove();
    });
    $('#categorySelect').select2();
  });
</script>
@endsection