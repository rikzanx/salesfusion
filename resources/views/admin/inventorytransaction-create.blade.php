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
                <h3 class="card-title">Create Transaksi Inventory</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('inventorytransaction.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Inventory <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-primary">Tambah Inventory</a></label>
                    <select class="form-control" name="inventory_id" id="inventorySelect">
                      @foreach ($inventories as $item)
                        <option value="{{ $item->id }}">{{$item->sku}} - {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tipe Transaksi</label>
                    <select class="form-control" name="tipe" id="tipeSelect">
                      <option value="masuk">Masuk</option>
                      <option value="keluar">Keluar</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah</label>
                    <input type="number" name="quantity" class="form-control" id="exampleInputEmail1" placeholder="Masukkan jumlah" value="">
                  </div>
                  <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-success">Tambah</button>
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
    $('#inventorySelect').select2();
  });
</script>
@endsection