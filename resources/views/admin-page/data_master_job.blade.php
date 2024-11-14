@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-2">{{ $title}}</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <hr style="margin-bottom: 0">
  </div><!-- /.container-fluid -->
</div>

<input type="hidden" id="valid" value="<?= session()->has('success') ?>">
<input type="hidden" id="invalid" value="<?= session()->has('failed') ?>">

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          @if (session()->has('failed'))
            <div class="alert alert-danger py-1" id="alert-response">
              <?= session()->get('failed') ?>
            </div>
          @endif
          @if (session()->has('success'))
            <div class="alert alert-success py-1" id="alert-response">
              <?= session()->get('success') ?>
            </div>
          @endif
          <div class="row justify-content-end mb-2 w-100">
            <a href="#" class="btn float-right btn-add"><i class="fas fa-plus-square"></i> &nbsp; Data</a>
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 11%">Kode Pekerjaan</th>
                      <th>Nama Pekerjaan</th>
                      <th style="width: 5%">Unit</th>
                      <th style="width: 15%; text-align: right;">Harga Satuan</th>
                      <th style="width: 8%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($dataJob as $row)
                  <tr>
                    <td>{{ $row->code }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->unit }}</td>
                    <td style="text-align: right;">{{ number_format($row->price,2,',','.') }}</td>
                    <td style=" text-align: center;">
                    <a href="#" class="text-warning"><i class="fas fa-edit" onclick="edit_data(`{{$row->id}}`, `{{$row->code}}`, `{{$row->name}}`, `{{$row->unit}}`, `{{number_format($row->price,2,',','.')}}`)" ></i></a>
                    &nbsp;
                    <a href="#" onclick="delete_data(`{{$row->id}}`, `{{$row->name}}`)" class="text-danger"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" id="notif-success">
        <div class="toast" style="position: absolute; top: 0; right: 0;">
          <div class="toast-header">
            <strong class="me-auto text-white">Berhasil</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ session('success') }}
          </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" id="notif-failed">
        <div class="toast" style="position: absolute; top: 0; right: 0;">
          <div class="toast-header">
            <strong class="me-auto text-white">Proses Gagal</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ session('failed') }}
          </div>
        </div>
    </div>

</section>

<div class="modal fade" id="modal-add-job" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-3 font-weight-bold">Tambah Data Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/add-new-job') }}" method="POST">
                @csrf
                <div class="modal-body p-3">
                    <div class="row mb-3">
                        <label for="code" class="col-sm-3 col-form-label">Kode Pekerjaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="code" name="code" autofocus >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Nama Pekerjaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="unit" class="col-sm-3 col-form-label">Unit</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="unit" name="unit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="price" class="col-sm-3 col-form-label">Harga Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="price" name="price" onkeyup="formatRupiah(this, this.value)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-job" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-3 font-weight-bold">Tambah Data Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/edit-new-job') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <input type="hidden" name="id" id="in_id">
                    <div class="row mb-3">
                        <label for="code" class="col-sm-3 col-form-label">Kode Pekerjaan</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="in_code1" name="code1">
                            <input type="text" class="form-control" id="in_code" name="code">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Nama Pekerjaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="in_name" name="name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="unit" class="col-sm-3 col-form-label">Unit</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="in_unit" name="unit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="price" class="col-sm-3 col-form-label">Harga Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="in_price" name="price" onkeyup="formatRupiah(this, this.value)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-2 font-weight-bold">Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body p-3">
          <div class="row" id="content-delete">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
