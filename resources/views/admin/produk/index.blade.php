@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    {{-- <style>
        .none {
            display: none;
        }

        .error {
            color: red;
        }

    </style> --}}
    
     {{-- <link href="{{ asset('admin/js/plugin/select2/css/select2.min.css')}}"/> --}}
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
@endpush

@section('admin-content')

  <div class="content">
    <div class="page-inner">
      <div class="page-header">
          <h4 class="page-title">{{ $title }}</h4>
          <ul class="breadcrumbs">
              <li class="nav-home">
                  <a href="#">
                      <i class="flaticon-home"></i>
                  </a>
              </li>
              <li class="separator">
                  <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                  <a href="#">Data Barang</a>
              </li>
          </ul>
      </div>
      <div class="row">
          <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-primary card-round">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-5">
                              <div class="icon-big text-center">
                                  <i class="flaticon-users"></i>
                              </div>
                          </div>
                          <div class="col-7 col-stats">
                              <div class="numbers">
                                  <p class="card-category">Total Produk</p>
                                  <h4 class="card-title">{{ countProduk() }}</h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-info card-round">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-5">
                              <div class="icon-big text-center">
                                  <i class="flaticon-interface-6"></i>
                              </div>
                          </div>
                          <div class="col-7 col-stats">
                              <div class="numbers">
                                  <p class="card-category">Total Kategori</p>
                                  <h4 class="card-title">{{ countKategori() }}</h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-success card-round">
                  <div class="card-body ">
                      <div class="row">
                          <div class="col-5">
                              <div class="icon-big text-center">
                                  <i class="flaticon-analytics"></i>
                              </div>
                          </div>
                          <div class="col-7 col-stats">
                              <div class="numbers">
                                  <p class="card-category">Total Gudang</p>
                                  <h4 class="card-title">{{ countGudang() }}</h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="card shadow animate__animated animate__slideInDown">
                  <div class="card-header">
                      <form action="">
                          <h4 class="judul">Filter</h4>
                          <div class="row">
                              <div class="col-md-5">
                                  <select title="Pilih kategori" data-live-search="true" name="kategori" class="form-control selectpicker filter-kategori">
                                      @foreach ($daftar_kategori as $kategori)
                                          <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-md-4 mt-1">
                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Refresh data"
                                    class="btn btn-sm refresh btn-success btn-flat">
                                  <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                              </div>
                              <div class="col-md-3">
                                <a href="{{ route('produk.create') }}" data-toggle="tooltip" data-placement="top" title="Tambah data" class="btn btn-rounded btn-outline-primary">
                                  <i class="fa fa-plus" aria-hidden="true"></i> Tambah Produk
                                </a>
                              </div>
                          </div>
                      </form>
                  </div>
                  <div class="card-body">
                    <form action="" class="form-kategori">
                      <table id="produk-table" class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Minimal Stok</th>
                            <th>Stok</th>
                            <th>Opsi</th>
                          </tr>
                        </thead>
                      </table>
                    </form>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>

  @includeIf('admin.produk._modal')

@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('admin/js/plugin/select2/js/select2.min.js')}}"></script> --}}
<script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/themes/fa/theme.js') }}"></script>
<script>
  $(".input-fa").fileinput({
    theme: "fa",
    uploadUrl: "/file-upload-batch/2"
  });  

  // Datatables load data
  load_data();

  // Function datatables
  function load_data(kategori=''){
    $('#produk-table').DataTable({
      serverSide  : true,
      processing  : true,
      ajax        : {
        url   : "{{ route('produk.index') }}",
        data  : {kategori : kategori}
      }, 
      columns : [
        {data : "DT_RowIndex",name : "DT_RowIndex", searchable:false, sortable:false},
        {data : "nama_produk",name : "nama_produk"},
        {data : "kategori",name : "kategori"},
        {data : "minimal_stok",name : "minimal_stok"},
        {data : "stok",name : "stok"},
        {data : "aksi",name : "aksi", searchable:false, sortable:false},
      ], 
      pageLength : 15,
      "lengthMenu": [ 15, 25, 50, 75, 100 ],
      "language": {
        "emptyTable": "Data tidak ada"
      },
    });
  }

  // Refresh data
  function refresh_data(){
    $('#produk-table').DataTable().destroy();
    load_data();
  }

  // Filter data berdasarkan option
  $('form').on('change','.filter-kategori', function(e){
    e.preventDefault();
    var kategori = $('form .filter-kategori [name=kategori]').val();

    if(kategori != ''){
        $('#produk-table').DataTable().destroy();
        load_data(kategori);
        $('.card-header .judul').text('Filter data berdasarkan kategori');
    }else{
        Swal.fire('Oops...', 'Opsi kategori harus dipilih!', 'error')
        return;
    }
  });

  // Refresh Datatables
  $('form').on('click','.refresh', function(e){
    e.preventDefault();
    var kategori = $('form .filter-kategori').val('');
    $('#produk-table').DataTable().destroy();
    load_data();
  });

  $(function() {
      $('.modal-form').on('submit', function(e) {
          if (!e.preventDefault()) {

              var form = $('.modal-form form');
              form.find('.help-block').remove();
              form.find('.form-group').removeClass('has-error');

              $.ajax({
                  url: $('.modal-form form').attr('action'),
                  type: $('.modal-form input[name=_method]').val(),
                  beforeSend: function() {
                      $('.modal-footer .btn-save').addClass('d-none');
                      $('.modal-footer .loader').removeClass('d-none');
                  },
                  complete: function() {
                      $('.modal-footer .loader').addClass('d-none');
                      $('.modal-footer .submit').removeClass('d-none');
                  },
                  data: $('.modal-form form').serialize(),
                  success: function(response) {
                      $('.modal-form').modal('hide');
                      alert_success('success',  response.text)
                      $('#produk-table').DataTable().destroy();
                      load_data();
                  },
                  error: function(xhr) {
                      var res = xhr.responseJSON;
                      if ($.isEmptyObject(res) == false) {
                          $.each(res.errors, function(key, value) {
                              console.log(res);
                              $('.' + key)
                                  .closest('.form-group')
                                  .addClass('has-error')
                                  .append(`<span class="help-block">` + value +
                                      `</span>`)
                          });
                      }
                  }
              });
          }
      });
  });

  function editForm(url) {
      event.preventDefault();
      var me = $(this),
      id = $('.btn-edit').data('id');
      $('.modal-form').modal('show');
      $('.modal-form .modal-title').text('Ubah Produk');
      $('.modal-form .container-fluid').append(`<div class="row"><input type="hidden" name="id" value="`+id+`"></div>`);
      $('.modal-form form').attr('action', url);
      $('.modal-form [name=_method]').val('put');
      $.get(url+'/edit')
          .done((response) => {
              var nama = response.data.nama_produk,
              kategori_id = response.data.kategori_id,
              gudang_id = response.data.gudang_id,
              merek = response.data.merek,
              satuan = response.data.satuan,
              minimal_stok = response.data.minimal_stok,
              stok = response.data.stok,
              keterangan = response.data.keterangan;
              $('.modal-form .nama_produk').val(nama);
              $('.modal-form .kategori_id').val(kategori_id).change();
              $('.modal-form .gudang_id').val(gudang_id).change();
              $('.modal-form .merek').val(merek);
              $('.modal-form .satuan').val(satuan).change();
              $('.modal-form .minimal_stok').val(minimal_stok);
              $('.modal-form .stok').val(stok);
              $('.modal-form .keterangan').val(keterangan);
          })
          .fail((errors) => {
              Swal.fire('Oops...', 'Ada yang salah!', 'error')
              return;
          })
  }

 // Hapus Data
    $('body').on('click','.btn-delete', function(event){
        event.preventDefault();
        var me = $(this),
        url = me.attr('href'),
        csrf_token = $('meta[name=csrf-token]').attr('content');

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "menghapus data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url : url,
            type : "POST",
            data : {
                '_method' : 'DELETE',
                '_token' : csrf_token
            }, 
            success : function(response){
                alert_success('success',  response.text)
                refresh_data();
            },
            error : function(xhr){
                Swal.fire('Oops...', 'Data ini tidak bisa dihapus, karena produk ini terdapat data di barang masuk dan barang keluar', 'error')
                return;
            }
            });
        }
        });
    });

</script>

@endpush
