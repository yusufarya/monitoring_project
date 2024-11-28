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
            <form action="/store-material-daily-report" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mx-2">
                    @php
                        $date = isset($dailyReport['date']) ? date('Y-m-d', strtotime($dailyReport['date'])) : date('Y-m-d');
                        $dailyReport_id = isset($dailyReport['id']) ? $dailyReport['id'] : '';
                    @endphp

                    <input type="hidden" id="daily_report_id" name="daily_report_id" value="{{$dailyReport_id}}" >

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2" hidden>
                        <label for="project_id">ID Proyek</label>
                        <input type="text" class="form-control @error('project_id')is-invalid @enderror" name="project_id" id="project_id" value="{{ $dailyReport['project_id'] ?? '' }}" required>
                        @error('project_id')
                        <small class="invalid-feedback">
                            ID Proyek {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="spk_number">Nomor SPK</label>
                        <input type="text" class="form-control @error('spk_number')is-invalid @enderror" name="spk_number" id="spk_number" value="{{ $dailyReport['spk_number'] ?? '' }}" required>
                        @error('spk_number')
                        <small class="invalid-feedback">
                            Nomor SPK {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="date">Tanggal Laporan Harian</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ $date }}" required>
                        @error('date')
                        <small class="invalid-feedback">
                            Tanggal Laporan Harian {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="project_name">Nama Proyek</label>
                        <input type="text" class="form-control @error('project_name')is-invalid @enderror" name="project_name" id="project_name" value="{{ $dailyReport['project_name'] ?? '' }}" required readonly>
                        @error('project_name')
                        <small class="invalid-feedback">
                            Nama Proyek {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="contractor_name">Nama Kontraktor</label>
                        <input type="text" class="form-control @error('contractor_name')is-invalid @enderror" name="contractor_name" id="contractor_name" value="{{ $dailyReport['contractor_name'] ?? '' }}" required readonly>
                        @error('contractor_name')
                        <small class="invalid-feedback">
                            Nama Kontraktor {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="location_project">Lokasi Proyek</label>
                        <input type="text" class="form-control @error('location_project')is-invalid @enderror" name="location_project" id="location_project" value="{{ $dailyReport['location_project'] ?? '' }}" required readonly>
                        @error('location_project')
                        <small class="invalid-feedback">
                            Lokasi Proyek {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="value_contract">Nilai Kontrak</label>
                        <input type="text" class="form-control @error('value_contract')is-invalid @enderror" name="value_contract" id="value_contract" value="{{ isset($dailyReport['value_contract']) ? number_format($material_pickup['value_contract'],2, ',', '.') : 0 }}" required readonly>
                        @error('value_contract')
                        <small class="invalid-feedback">
                            Nilai Kontrak {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="value_total_job">Nilai Total Pekerjaan</label>
                        <input type="text" class="form-control @error('value_total_job')is-invalid @enderror" name="value_total_job" id="value_total_job" value="{{ isset($dailyReport['value_total_job']) ? number_format($material_pickup['value_total_job'],2, ',', '.') : 0 }}" required readonly>
                        @error('value_total_job')
                        <small class="invalid-feedback">
                            Nilai Total Pekerjaan {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="value_total_material">Nilai Total Material</label>
                        <input type="text" class="form-control @error('value_total_material')is-invalid @enderror" name="value_total_material" id="value_total_material" value="{{ isset($dailyReport['value_total_material']) ? number_format($material_pickup['value_total_material'],2, ',', '.') : 0 }}" required readonly>
                        @error('value_total_material')
                        <small class="invalid-feedback">
                            Nilai Total Material {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>

                @if ($dailyReport)
                    <br>
                    <h6>Data Material</h6>
                    <div class="box-table">
                        <table class="table table-hover table-sm" id="table-material">
                            <thead>
                                <tr>
                                    <th style="width: 7%;">Kode Material</th>
                                    <th>Nama Material</th>
                                    <th style="width: 5%;">Unit</th>
                                    <th style="width: 6%; text-align: center;">Quantity</th>
                                    <th style="width: 10%; text-align: right">Harga Satuan</th>
                                    <th style="width: 13%; text-align: right">Jumlah Harga</th>
                                    <th style="width: 6%; text-align: right">Bobot (%)</th>
                                    <th style="width: 4%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- load in script  --}}
                            </tbody>
                        </table>
                    </div>
                    {{-- <br>
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
                            </tbody>
                        </table>
                    </div> --}}
                @endif

                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/material-daily-report" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
                            <button class="btn my-button-save"><i class="far fa-save"></i> Simpan</button>
                        </section>
                    </section>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
