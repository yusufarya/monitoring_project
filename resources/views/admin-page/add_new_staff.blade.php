@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-3">{{ $title}}</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <hr style="margin-bottom: 0; margin:0 22px;">
  </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card mx-3 elevation-1 p-3">
            <form action="/add-new-staff" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row my-4 mx-3">
                    <div class="col-lg-6 col-md-6 col-sm-12" >
                        <div class="row">

                            <input type="hidden" id="valid" value="<?= session()->has('success') ?>">
                            <input type="hidden" id="invalid" value="<?= session()->has('failed') ?>">

                            <div class="col-lg-7 col-md-7 col-sm-12 mt-2">
                                <label for="number">Nomor ID</label>
                                <input type="text" class="form-control" name="number" id="number" value="{{getLastNumberStaff()}}" readonly>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5 mt-2">
                                <div class="form-check mt-1">
                                    <label for="is_active">Status Aktif ?</label>
                                    <input class="form-check-input mt-5" type="checkbox" checked value="Y" name="is_active" id="is_active" style="width: 1.3rem; height: 1.3rem; top:-1rem; left: 2.5rem;">
                                    <div class="form-check-label" style="margin-left: 30px">Ya</div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <label for="fullname">Nema Lengkap</label>
                                <input type="text" autocomplete="off" class="form-control @error('fullname')is-invalid @enderror" name="fullname" id="fullname" maxlength="50" placeholder="Nama lengkap" value="{{ old('fullname') }}">
                                @error('fullname')
                                    <small class="invalid-feedback">
                                        Nama Lengkap {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <label for="username">Username</label>
                                <input type="text" autocomplete="off" class="form-control @error('username')is-invalid @enderror" name="username" id="username" maxlength="50" onkeyup="changeUsername()" value="{{ old('username') }}">
                                @error('username')
                                    <small class="invalid-feedback">
                                        Username {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <label for="gender">Jenis Kelamin</label>
                                <select class="form-control @error('gender')is-invalid @enderror" name="gender" id="gender">
                                    <option value="">Pilih</option>
                                    <option value="M" {{ old('gender') == "M" ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="F" {{ old('gender') == "F" ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <small class="invalid-feedback">
                                    Jenis Kelamin {{ $message }}
                                </small>
                                @enderror

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <label for="level_id">Level</label>
                                <select class="form-control @error('level_id')is-invalid @enderror" name="level_id" id="level_id">
                                    {{-- <option value="">Pilih</option> --}}
                                    @foreach ($level_id as $val)
                                        @if ($val->id == 2)
                                            <option value="{{$val->id}}" {{ old('level_id') == $val->id ? 'selected' : '' }} >{{ $val->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('level_id')
                                <small class="invalid-feedback">
                                    Level {{ $message }}
                                </small>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                <label for="no_telp">No. Telp</label>
                                <input type="text" class="form-control @error('no_telp')is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp') }}">
                                @error('no_telp')
                                <small class="invalid-feedback">
                                    Level {{ $message }}
                                </small>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email')is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                <small class="invalid-feedback">
                                    Email {{ $message }}
                                </small>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                <label for="place_of_birth">Tempat lahir</label>
                                <input type="text" class="form-control @error('place_of_birth')is-invalid @enderror" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}">
                                @error('place_of_birth')
                                <small class="invalid-feedback">
                                    Tempat Lahir {{ $message }}
                                </small>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('date_of_birth')is-invalid @enderror" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                <small class="invalid-feedback">
                                    Tanggal Lahir {{ $message }}
                                </small>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <label for="date_of_birth">Alamat Lengkap</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="bg-transparent col" style="max-width: 5%"></div>
                    <div class="col" >
                        <div class="elevation-1">
                            <img src="{{ asset('img/who_icon.jpg')}}" class="img-fluid" alt="defaul_user" id="blah" style="height: 390px; padding: 10px;">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px; margin-top: -10px;">
                                <input type="file" name="images" id="images" class="form-control border-0 @error('images')is-invalid @enderror">
                                @error('images')
                                <small class="invalid-feedback">
                                    File {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password')is-invalid @enderror" name="password" id="password">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                <small class="invalid-feedback">
                                    Password {{ $message }}
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/data-staff" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
                            <button class="btn my-button-save"><i class="far fa-save"></i> Simpan</button>

                        </section>
                    </section>
                </div>
            </form>

        </div>

        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header my-bg-primary">
                    <strong class="me-auto text-white">Berhasil</strong>
                    {{-- <small>11 mins ago</small> --}}
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="notif-failed" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-white">Proses Gagal</strong>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('failed') }}
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
