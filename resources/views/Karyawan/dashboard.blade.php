@extends('masterFile')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            {{-- Presensi --}}
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            @can('dashboard_user', Dashboard::class)
                                <h5>Presensi</h5>
                            @endcan
                            @can('dashboard_admin', Dashboard::class)
                                <h5>Presensi Karyawan</h5>
                            @endcan
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Bulan {{ date_format(now(), 'M') }}</div>
                            @can('dashboard_user', Dashboard::class)
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($presensi) . ' / ' . $weekdays }}
                                @endcan
                                @can('dashboard_admin', Dashboard::class)
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $presensi . ' / ' . $total_presensi }}
                                    @endcan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Izin --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                @can('dashboard_user', Dashboard::class)
                                    <h5>Izin</h5>
                                @endcan
                                @can('dashboard_admin', Dashboard::class)
                                    <h5>Izin Karyawan</h5>
                                @endcan
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Bulan {{ date_format(now(), 'M') }}</div>
                                @can('dashboard_user', Dashboard::class)
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($izin) }}</div>
                                @endcan
                                @can('dashboard_admin', Dashboard::class)
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $izin }}</div>
                                @endcan
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cuti --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                @can('dashboard_user', Dashboard::class)
                                    <h5>Cuti</h5>
                                @endcan
                                @can('dashboard_admin', Dashboard::class)
                                    <h5>Cuti Karyawan</h5>
                                @endcan
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bulan
                                    {{ date_format(now(), 'M') }}
                                </div>
                                <div class="row no-gutters align-items-center">
                                    @can('dashboard_user', Dashboard::class)
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($cuti) }}</div>
                                        </div>
                                    @endcan
                                    @can('dashboard_admin', Dashboard::class)
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $cuti }}</div>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Pie Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Total Kehadiran</h6>
                        {{-- <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Total presensi
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Total izin
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Total cuti
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @can('dashboard_user', Dashboard::class)
                {{-- Izin / Cuti --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Izin / Cuti</h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow:scroll;height:22.5rem">
                            @foreach ($izin_cuti as $val)
                                <div
                                    class="card border-left-{{ $val['status_presensi'] == 'izin' ? 'success' : 'danger' }} shadow h-50 mb-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <h5>{{ strtoupper($val['status_presensi']) }}</h5>
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Bulan {{ date_format(new DateTime($val['waktu_presensi']), 'M') }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ date_format(new DateTime($val['waktu_presensi']), 'D-M-Y') }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endcan
@endsection
