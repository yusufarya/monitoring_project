@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 ml-2"> {{ $title }}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard </li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$todayJob}}</h3>

            <p>Jumlah Pekerjaan Hari Ini </p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-line"></i>
          </div>
          {{-- <a href="/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$todayMaterial}}</h3>

            <p>Jumlah Material Hari Ini</p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-area"></i>
          </div>
          {{-- <a href="/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$todayJobDone}}</h3>

            <p>Pekerjaan Selesai Hari Ini </p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-area"></i>
          </div>
          {{-- <a href="/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{$todayMaterialDone}}</h3>

            <p>Material Selesai Hari Ini</p>
          </div>
          <div class="icon">
            <i class="far fa-chart-bar"></i>
          </div>
          {{-- <a href="/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Proyek hari ini</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No. Spk</th>
                            <th>Nama Proyek</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Nama Kontraktor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projectData as $row)
                        <tr>
                            <td>{{ $row->spk_number }}</td>
                            <td>{{ $row->project_name }}</td>
                            <td>{{ $row->start_date }}</td>
                            <td>{{ $row->end_date }}</td>
                            <td>{{ $row->contractor_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- Main row -->
    <div class="row" hidden>
      <section class="col-lg-12 connectedSortable">

        <!-- PRODUCT LIST -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Recently Added Products</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
              <li class="item">
                <div class="product-img">
                  <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">Samsung TV
                    <span class="badge badge-warning float-right">$1800</span></a>
                  <span class="product-description">
                    Samsung 32" 1080p 60Hz LED Smart HDTV.
                  </span>
                </div>
              </li>
              <!-- /.item -->
              <li class="item">
                <div class="product-img">
                  <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">Bicycle
                    <span class="badge badge-info float-right">$700</span></a>
                  <span class="product-description">
                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                  </span>
                </div>
              </li>
              <!-- /.item -->
              <li class="item">
                <div class="product-img">
                  <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">
                    Xbox One <span class="badge badge-danger float-right">
                    $350
                  </span>
                  </a>
                  <span class="product-description">
                    Xbox One Console Bundle with Halo Master Chief Collection.
                  </span>
                </div>
              </li>
              <!-- /.item -->
              <li class="item">
                <div class="product-img">
                  <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                </div>
                <div class="product-info">
                  <a href="javascript:void(0)" class="product-title">PlayStation 4
                    <span class="badge badge-success float-right">$399</span></a>
                  <span class="product-description">
                    PlayStation 4 500GB Console (PS4)
                  </span>
                </div>
              </li>
              <!-- /.item -->
            </ul>
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <a href="javascript:void(0)" class="uppercase">View All Products</a>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

      </section>
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
