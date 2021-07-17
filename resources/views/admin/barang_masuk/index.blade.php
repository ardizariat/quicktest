@extends('layouts.admin.master')
@section('title')
    {{ $title }}
@endsection

@push('css')
    <style>
        .none {
            display: none;
        }

        .error {
            color: red;
        }

    </style>
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/selectpicker/css/bootstrap-select.min.css') }}">
     <link rel="stylesheet" href="{{ asset('admin/js/plugin/file-input/css/fileinput.min.css') }}">
     <link href="{{ asset('admin/js/plugin/date-time-pickers/css/flatpicker-airbnb.css')}}" rel="stylesheet" type="text/css" />
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
                  <a href="#">Data Barang Masuk</a>
              </li>
          </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow animate__animated animate__jackInTheBox">
            <div class="card-header">
              <form action="">
                <h4><i class="fas fa-filter"></i> Filter</h4>
                <div class="row">
                  <div class="col-md-3">
                      <input name="from_date" type="text" autocomplete="off" class="from_date form-control max-date">
                  </div>
                  <div class="col-md-3">
                      <input name="to_date" type="text" autocomplete="off" class="to_date form-control max-date">
                  </div>
                  <div class="col-md-3 mt-1">
                      <div class="btn-group">
                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Filter data"
                        class="btn btn-sm filter btn-success btn-flat">
                        <i class="fas fa-filter"></i> Filter
                        </button>
                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Refresh data"
                        class="btn btn-sm refresh btn-danger btn-flat">
                        <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <a data-toggle="tooltip" data-placement="top" title="Tambah data" class="btn btn-rounded btn-outline-primary"
                  onclick="addForm('{{ route('barang-masuk.store') }}')">
                  <i class="fa fa-plus" aria-hidden="true"></i> Tambah Barang Masuk
                      </a>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="" class="form-kategori">
                  <table id="barangmasuk-table" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Option</th>
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
</div>

@includeIf('admin.barang_masuk._modal_input')
@includeIf('admin.barang_masuk._modal_show')

@endsection

@push('js')
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/selectpicker/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/file-input/themes/fa/theme.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/flatpickr.js') }}"></script>
<script src="{{ asset('admin/js/plugin/date-time-pickers/js/date-time-picker-script.js') }}"></script>

<script>
  $('.selectpicker').selectpicker();

  // File input images
  $(".input-fa").fileinput({
      theme: "fa",
      uploadUrl: "/file-upload-batch/2"
  });

  // Datatables load data
  load_data();

  // Function datatables
  function load_data(from_date = '', to_date = ''){
    $('#barangmasuk-table').DataTable({
      processing  : true,
      serverSide  : true,
      ajax        : {
          url : "{{ route('barang-masuk.index') }}",
          data : { from_date : from_date, to_date : to_date}
      },
      columns     : [
        {
            data : "DT_RowIndex",name : "DT_RowIndex"
        },
        {
            data: 'produk', name: 'produk'
        },
        {
            data: 'kategori', name: 'kategori'
        },
        {
            data: 'tanggal', name: 'tanggal'
        },
        {
            data: 'jumlah', name: 'jumlah'
        },
        {
            data: 'aksi', name: 'aksi'
        },
      ],
      pageLength : 15,
      "lengthMenu": [ 15, 25, 50, 75, 100 ],
      "language": {
        "emptyTable": "Data tidak ada"
      },
    });
  }

  // Filter data berdasarkan tanggal
  $('form').on('click','.filter', function(e){
    e.preventDefault();
    var from_date = $('form .from_date').val(),
    to_date = $('form .to_date').val();

    if(from_date != '' && to_date != ''){
        $('#barangmasuk-table').DataTable().destroy();
        load_data(from_date, to_date);
    }else{
        Swal.fire('Oops...', 'Filter tanggal harus diisi semua!', 'error')
        return;
    }
  });

  // Refresh Datatables
  $('form').on('click','.refresh', function(e){
    e.preventDefault();
    var from_date = $('form .from_date').val(''),
    to_date = $('form .to_date').val('');
    $('#barangmasuk-table').DataTable().destroy();
    load_data();
  });

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
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: response.text,
            showConfirmButton: false,
            timer: 2000,
            showClass: {
                popup: 'animate__animated animate__lightSpeedInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__lightSpeedOutRight'
            }
            })
            $('#barangmasuk-table').DataTable().destroy();
            load_data();
        }
      });
    }
    });

  });

  // Insert dan Update data
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
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.text,
                showConfirmButton: false,
                timer: 2000,
                showClass: {
                    popup: 'animate__animated animate__lightSpeedInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__lightSpeedOutRight'
                }
                })
                $('#barangmasuk-table').DataTable().destroy();
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

  // Show modal create
  function addForm(url) {
      event.preventDefault();
      $('.modal-form').modal('show');
      $('.modal-form .modal-title').text('Tambah Barang Masuk');
      $('.modal-form form')[0].reset();
      $('.modal-form form').attr('action', url);
      $('.modal-form [name=_method]').val('post');
  }
  // Show data produk
  function changeData(url){
      var id = $('.produk_id select[name=produk_id]').val();
      $.ajax({
          url : url,
          type : 'post',
          dataType : 'json',
          data : {
              '_token' : '{{ csrf_token() }}',
              'id' : id
          },
          success : function(res){
              var stok = parseInt(res.stok);
              $('.stok').val(stok); 
              $('.modal-form').on('keyup','.jumlah', function(){
                  var me = $(this),
                  jumlah = parseInt(me.val());
                  total = stok + jumlah;
                  $('.stok').val(total); 
              });                   
          },
          error: function(message){
              console.log('error');
          }
      })
  }

  // menampilkan modal show
  function showData(url) {
      event.preventDefault();
      $('.modal-show').modal('show');      
      $.get(url)
          .done((response) => {
              var nama_produk = response.data.product.nama_produk,
              jumlah = response.data.jumlah,
              penerima = response.data.penerima,
              pemberi = response.data.pemberi,
              keterangan = response.data.keterangan,
              tanggal = response.tanggal,
              foto = response.foto;
              console.log(foto);

              $('.modal-show .modal-title').text('Detail '+nama_produk);

              $('.modal-show .foto').prop("src",foto).width(200).height(130);
              $('.modal-show .nama_produk').text(nama_produk);
              $('.modal-show .jumlah').text(jumlah);
              $('.modal-show .tanggal').text(tanggal);
              $('.modal-show .pemberi').text(pemberi);
              $('.modal-show .keterangan').text(keterangan);
              $('.modal-show .penerima').text(penerima);
          })
          .fail((errors) => {
              Swal.fire('Oops...', 'Data tidak ditemukan!', 'error')
              return;
          })
  }
</script>


@endpush
