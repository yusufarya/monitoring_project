@extends('admin-page.layouts.main_layout')

@section('content-pages')

<style>
    .select2-container--default .select2-selection--single {
        /* width: 760px; Set the width */
        height: 40px !important; /* Set the height */
        padding: 10px;
        border: 1px solid black;
    }
</style>

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
        <div class="card w-75 mx-3 elevation-1 p-3">
            <form action="" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mt-2">
                            <label for="type" class="ml-1">Tipe Rekap</label>
                            <select class="select-type form-control" name="type" id="type">
                                <option value="">Plih Tipe</option>
                                <option value="J">Pekerjaan</option>
                                <option value="M">Material</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-2">
                            <label for="spk_number" class="ml-1">Nomor Spk</label>
                            <select class="select-spk_number form-control" name="spk_number" id="spk_number">
                                <option value="">Plih Nomor Spk</option>
                                @foreach ($projectData as $item)
                                    <option value="{{ $item->spk_number }}"> » &nbsp; {{ $item->spk_number .' - '. $item->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-lg-6 col-md-6 mt-2">
                            <label for="date" class="ml-1">Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control form-select">
                        </div> --}}
                    </div>
                </div>

                <button type="button" class="btn btn-warning ml-3" id="submitRpt" style="float: right;">
                    <i class="fas fa-search mr-1"></i> Submit
                </button>
            </form>
        </div>
    </div>

</section>

@endsection
