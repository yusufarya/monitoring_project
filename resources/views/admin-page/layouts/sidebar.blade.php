<?php
    $profileImg = $auth_user->image ? $auth_user->image : 'userDefault.png';
?>

<!-- Main Sidebar Container -->
{{-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> --}}
<aside class="main-sidebar sidebar-light-lightblue elevation-2">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('img/logo-bussiness.png') }}" alt="Monitoring Proyek Logo" class="brand-image img-circle elevation-1" style="opacity: 1">
        <span class="brand-text my-color-secondary font-weight-bold"> Monitoring Proyek</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(!$auth_user->images)
                    <img src="{{ asset('img/userDefault.png') }}" class="img-circle elevation-0" alt="User Image">
                @else
                    <img src="{{ asset('/storage').'/'.$auth_user->images }}" class="img-circle elevation-0" style="height: 30px;" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="/profile" class="d-block link_profile px-2 {{ Request::segment(1) === 'profile' ? 'profile-active' : '' }}">{{ $auth_user->fullname }} </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::segment(1) === 'dashboard' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard  </p>
                    </a>
                </li>

                @if($auth_user->level_id == 3 || $auth_user->level_id == 1)
                    <li class="nav-item {{ Request::segment(1) === 'data-admin' || Request::segment(1) === 'data-staff' || Request::segment(1) === 'form-add-staff' ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data User
                            <i class="fas fa-angle-right right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="/data-admin" class="nav-link {{ Request::segment(1) === 'data-admin' ? 'submenu-active' : '' }}">
                                    » &nbsp;
                                    <p>Data Admin</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/data-staff" class="nav-link {{ Request::segment(1) === 'data-staff' || Request::segment(1) === 'form-add-staff' ? 'submenu-active' : '' }}">
                                    » &nbsp;
                                    <p>Data Operator</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Request::segment(1) === 'data-job' || Request::segment(1) === 'data-material' ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-box"></i>
                        <p>
                            Data Master
                        <i class="fas fa-angle-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/data-job" class="nav-link {{ Request::segment(1) === 'data-job' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Pekerjaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/data-material" class="nav-link {{ Request::segment(1) === 'data-material' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Material</p>
                            </a>
                        </li>
                        </ul>
                    </li>

                    <li class="nav-item ">
                        <a href="/project-list" class="nav-link {{ Request::segment(1) === 'project-list' || Request::segment(1) === 'form-project' ? 'menu-active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Daftar Proyek </p>
                        </a>
                    </li>
                @endif

                @if ($auth_user->level_id == 2 || $auth_user->level_id == 1)

                <li class="nav-item {{ Request::segment(1) === 'form-job-daily-report' || Request::segment(1) === 'job-daily-report' || Request::segment(1) === 'material-daily-report' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan Harian
                        <i class="fas fa-angle-right right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/job-daily-report" class="nav-link {{ Request::segment(1) === 'form-job-daily-report' || Request::segment(1) === 'job-daily-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Pekerjaan </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/material-daily-report" class="nav-link {{ Request::segment(1) === 'material-daily-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Material </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="/material-pickup" class="nav-link {{ Request::segment(1) === 'material-pickup' || Request::segment(1) === 'form-material-pickup'    ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Pengambilan Material</p>
                    </a>
                </li>
                {{-- <li class="nav-item ">
                    <a href="/job-balance" class="nav-link {{ Request::segment(1) === 'job-balance' || Request::segment(1) === 'form-job-balance'    ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Rekap Pekerjaan</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="/material-balance" class="nav-link {{ Request::segment(1) === 'material-balance' || Request::segment(1) === 'form-material-balance' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Rekap Material</p>
                    </a>
                </li> --}}
                <li class="nav-item ">
                    <a href="/recapitulation" class="nav-link {{ Request::segment(1) === 'recapitulation' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Rekapitulasi Data</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
