@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ config('app.company.name', 'Laravel') }} - Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Inventory</li>
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
                                <h3 class="card-title">Edit Inventory Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('inventories.update', $inventory->id) }}" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
    <div class="card-body">
        <div class="form-group">
            <label for="exampleInputEmail1">SKU</label>
            <input type="text" name="sku" class="form-control" id="exampleInputEmail1" value="{{ $inventory->sku }}" readonly>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" value="{{ $inventory->name }}" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter the name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" value="{{ $inventory->description }}" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter the description">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Enter ...">
            {{ $inventory->description }}"
            </textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Lokasi</label>
            <input type="text" value="{{ $inventory->lokasi }}" name="lokasi" class="form-control" id="exampleInputEmail1" placeholder="Enter the location">
        </div>
        <div class="form-group">
            @foreach($inventory->images as $item)
            <div class="row mx-2">
                <div class="col-6">
                    <a href="{{ asset($item->image_inventory) }}" data-toggle="lightbox" data-title="{{ $item->name }}">
                        <img src="{{ asset($item->image_inventory) }}" style="width: 100px;height:100px;" alt="" srcset="">
                    </a>
                </div>
                <div class="col-6">
                <button type="button" class="btn btn-danger" onclick="modaldeleteimage({{ $item->id }})"><span class="fas fa-trash"></span></button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Foto Barang</label>
        </div>
        <div class="input-group hdtuto control-group lst increment" >
            <input type="file" name="filenames[]" class="myfrm form-control">
            <div class="input-group-btn"> 
            <button class="btn btn-success btn-add-image" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
            </div>
        </div>
        <div class="clone hide">
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
            <input type="file" name="filenames[]" class="myfrm form-control">
            <div class="input-group-btn"> 
                <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
            </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-success">Update</button>
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
  <div class="modal fade" id="modal-default-image">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Peringatan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin akan menghapus gambar ini&hellip;</p>
        </div>
        <form action="{{ route('imageinventory.destroy', ':id') }}" method="POST" class="delete-form-image">
            @csrf
            @method('DELETE')
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection

@section('js')

<script type="text/javascript">
    function modaldeleteimage(id) {
        var form = $('.delete-form-image');
        form.attr('action', form.attr('action').replace(':id', id));

        $('#modal-default-image').modal('show');
    }
    $(document).ready(function() {
        $(".btn-add-image").click(function(){ 
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click",".btn-hapus-input",function(){ 
            $(this).parents(".hdtuto").remove();
        });
    });
</script>
@endsection
