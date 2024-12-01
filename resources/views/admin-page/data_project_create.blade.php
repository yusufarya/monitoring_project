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

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card mx-2 elevation-1 p-3 w-100">
            <form action="/store-project" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mx-2">
                    @php
                        $date = isset($project['date']) ? date('Y-m-d', strtotime($project['date'])) : date('Y-m-d');
                        $project_id = isset($project['id']) ? $project['id'] : '';
                    @endphp
                    <input type="hidden" id="project_id" name="project_id" value="{{$project_id}}" >
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ $date }}" required>
                        @error('date')
                        <small class="invalid-feedback">
                            Tanggal {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="supervisor_name">Nama Pengawas</label>
                        <input type="text" class="form-control @error('supervisor_name')is-invalid @enderror" name="supervisor_name" id="supervisor_name" value="{{ $project['supervisor_name'] ?? ''}}" required>
                        @error('supervisor_name')
                        <small class="invalid-feedback">
                            Nama Pengawas {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="operator_name">Nama Operator</label>
                        <input type="text" class="form-control @error('operator_name')is-invalid @enderror" name="operator_name" id="operator_name" value="{{ $project['operator_name'] ?? '' }}" required>
                        @error('operator_name')
                        <small class="invalid-feedback">
                            Nama Operator {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="spk_number">Nomor SPK</label>
                        <input type="text" class="form-control @error('spk_number')is-invalid @enderror" name="spk_number" id="spk_number" value="{{ $project['spk_number'] ?? '' }}" required>
                        @error('spk_number')
                        <small class="invalid-feedback">
                            Nama Operator {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="project_name">Nama Proyek</label>
                        <input type="text" class="form-control @error('project_name')is-invalid @enderror" name="project_name" id="project_name" value="{{ $project['project_name'] ?? '' }}" required>
                        @error('project_name')
                        <small class="invalid-feedback">
                            Nama Proyek {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 mt-2">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('start_date')is-invalid @enderror" name="start_date" id="start_date" value="{{ $project['start_date'] ?? '' }}" required>
                        @error('start_date')
                        <small class="invalid-feedback">
                            Tanggal Mulai {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 mt-2">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" class="form-control @error('end_date')is-invalid @enderror" name="end_date" id="end_date" value="{{ $project['end_date'] ?? '' }}" required>
                        @error('end_date')
                        <small class="invalid-feedback">
                            Tanggal Selesai {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="contractor_name">Nama Kontraktor</label>
                        <input type="text" class="form-control @error('contractor_name')is-invalid @enderror" name="contractor_name" id="contractor_name" value="{{ $project['contractor_name'] ?? '' }}" required>
                        @error('contractor_name')
                        <small class="invalid-feedback">
                            Nama Kontraktor {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="location_project">Lokasi Proyek</label>
                        <input type="text" class="form-control @error('location_project')is-invalid @enderror" name="location_project" id="location_project" value="{{ $project['location_project'] ?? '' }}" required>
                        @error('location_project')
                        <small class="invalid-feedback">
                            Lokasi Proyek {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="value_contract">Nilai Kontrak</label>
                        <input type="text" class="form-control @error('value_contract')is-invalid @enderror" name="value_contract" id="value_contract" value="{{ isset($project['value_contract']) ? number_format($project['value_contract'],2, ',', '.') : 0 }}" required>
                        @error('value_contract')
                        <small class="invalid-feedback">
                            Nilai Kontrak {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>

                @if ($project)
                    <br>
                    <h6>Data Pekerjaan</h6>
                    <div class="box-table">
                        <table class="table table-hover table-sm" id="table-job">
                            <thead>
                                <tr>
                                    <th style="width: 7%;">Kode Pekerjaan</th>
                                    <th>Nama Pekerjaan</th>
                                    <th style="width: 6%;">Unit</th>
                                    <th style="width: 8%; text-align: center;">Quantity</th>
                                    <th style="width: 13%; text-align: right">Harga Satuan</th>
                                    <th style="width: 15%; text-align: right">Jumlah Harga</th>
                                    <th style="width: 10%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- load in script  --}}
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <h6>Data Material</h6>
                    <div class="box-table">
                        <table class="table table-hover table-sm" id="table-material">
                            <thead>
                                <tr>
                                    <th style="width: 7%;">Kode Material</th>
                                    <th>Nama Material</th>
                                    <th style="width: 6%;">Unit</th>
                                    <th style="width: 8%; text-align: center;">Quantity</th>
                                    <th style="width: 13%; text-align: right">Harga Satuan</th>
                                    <th style="width: 15%; text-align: right">Jumlah Harga</th>
                                    <th style="width: 10%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- load in script  --}}
                            </tbody>
                        </table>
                    </div>
                @endif

                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/project-list" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
                            <button class="btn my-button-save"><i class="far fa-save"></i> Simpan</button>
                        </section>
                    </section>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
