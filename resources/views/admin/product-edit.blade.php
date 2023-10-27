@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ config('app.company.name', 'Laravel') }} - Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Produk</li>
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
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Masukkan nama: Gate valve" value="{{ $product->name }}">
                  </div>
                  <div class="form-group">
                    <label>Kategori Produk <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-primary">Tambah Kategori</a></label>
                    <select class="form-control" name="category_id" id="categorySelect">
                      @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == $product->category_id)?'selected':'' }}>{{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Material Produk</label> --}}
                    <input type="hidden" name="material" class="form-control" id="exampleInputEmail1" placeholder="Cast Iron,Carbon Steel, Steinless Steel" value="{{ $product->material }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Size Produk</label>
                    <input type="text" name="size" class="form-control" id="exampleInputEmail1" placeholder="2,3,4,5,6,8,10" value="{{ $product->size }}">
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Rating Produk</label> --}}
                    <input type="hidden" name="rating" class="form-control" id="exampleInputEmail1" placeholder="jis 10k, jis 20k, jis 30k, ansi 150, ansi 300, ansi 600" value="{{ $product->rating }}">
                  </div>
                  <div class="form-group">
                    {{-- <label for="exampleInputEmail1">Connection Produk</label> --}}
                    <input type="hidden" name="connection" class="form-control" id="exampleInputEmail1" placeholder="flange-end, screw" value="{{ $product->connection }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Brand Produk</label>
                    <input type="text" name="brand" class="form-control" id="exampleInputEmail1" placeholder="Kitz, GLT, Toyo dll." value="{{ $product->brand }}">
                  </div>
                  <div class="form-group">
                    <label>Deskripsi produk</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter ...">{{ $product->description }}</textarea>
                  </div>

                  <div class="form-group">
                    @foreach($product->images as $item)
                    <div class="row mx-2">
                      <div class="col-6">
                          <a href="{{ asset($item->image_product) }}" data-toggle="lightbox" data-title="{{ $item->name }}">
                                <img src="{{ asset($item->image_product) }}" style="width: 100px;height:100px;" alt="" srcset="">
                          </a>
                      </div>
                      <div class="col-6">
                        <button class="btn btn-danger" onclick="modaldeleteimages({{ $item->id }})"><span class="fas fa-trash"></span></button>
                      </div>
                    </div>
                    @endforeach
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Upload/Ganti Foto Produk Baru</label>
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
        <form action="{{ route('imageproduk.destroy', ':id') }}" method="POST" class="delete-form-image">
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
  function modaldeleteimage(id){
        // alert(id);
        var url = $('.delete-form-image').attr('action');
        $('.delete-form-image').attr('action',url.replace(':id',id));
        $('#modal-default-image').modal('show');
    }
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