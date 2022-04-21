@extends('layouts.master')

@section('title')
    Toko List
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Toko List
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Toko List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              
                <button class="btn btn-success xs" onclick="addForm('{{ route('toko.store') }}')"> <i class="fa fa-plus-circle"></i>   Tambah</button>

          
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>Deskripsi</th>
                        <th width="10%"><i class="fa fa-cog"></i></th>
                    </thead>
                    
                </table>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

    </section>
    <!-- /.content -->
  </div>

  @include('admin.toko.form')
@endsection

@push('scripts')

{{-- buat datatable --}}
    <script>
        let table;

        $(function(){
            table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
                ajax: {
                    url: '{{ route('toko.data') }}'
                },
                columns: [
                        {data: 'DT_RowIndex', searchable: false, sortable: false},
                        {data: 'nama_toko'},
                        {data: 'alamat'},
                        {data: 'deskripsi'},
                        {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            
            $('#modal-form').validator().on('submit', function(e){
                if (! e.preventDefault()) {
                    $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: 'post',
                        data: $('#modal-form form').serialize(),
                        data: new FormData($('#modal-form form')[0]),
                        async: false,
                        processData: false,
                        contentType: false
                    })
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })

                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
                }
            });

        });

        function addForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Toko');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action',url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_toko]').focus();
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Toko');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action',url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_toko]').focus();

            $.get(url)
              .done((response) => {
                $('#modal-form [name=nama_toko]').val(response.nama_toko);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('.tampil-toko').html(`<img src="{{ url('/') }}/${response.image}" width="200">`);
              })

              .fail((errors) => {
                alert('Data tidak ditemukan');
                return;
              })
        }

        function deleteData(url) {
          if(confirm('Yakin Ingin Hapus Data?')){
            
          $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
          })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
              });
          }
        }

           </script>
@endpush