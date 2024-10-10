@extends('template.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/datatables/css/jquery.dataTables.min.css">
@endSection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">DPT</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Data Import DPT</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">

                        @if (session()->has('pesan'))
                            <div class="container text-center">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('pesan') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        <!--********************************** content start ***********************************-->

                        <div class="card-body">
                            <div class="col-md-4">
                                <a href="/dpt/create" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="fa fa-plus"></i>
                                    </span>Import DPT</a>
                            </div>


                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Kode.</th>
                                            <th>Kabkota</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan/Desa</th>
                                            <th>Total Pemilih</th>
                                            <th>Tps</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelurahan_desa as $item)
                                            <tr>
                                                <td><strong>{{ $item->id }}</strong></td>
                                                <td>{{ $item->kabkota->nama }}</td>
                                                <td>{{ $item->kecamatan->nama }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>
                                                    @if ($item->jumlah > 0)
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-success light sharp"
                                                                data-bs-toggle="dropdown">
                                                                <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <circle fill="#000000" cx="5" cy="12"
                                                                            r="2" />
                                                                        <circle fill="#000000" cx="12" cy="12"
                                                                            r="2" />
                                                                        <circle fill="#000000" cx="19" cy="12"
                                                                            r="2" />
                                                                    </g>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @foreach ($item->tps as $item_sub)
                                                                    <a class="dropdown-item" href="/kta/"> TPS
                                                                        {{ $item_sub->nama }} |
                                                                        {{ $item_sub->total_pemilih_tps }}
                                                                        Pemilih</a>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    @else
                                                        belum import
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kabkota</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan/Desa</th>
                                            <th>Total Pemilih</th>
                                            <th>Tps</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>



                        </div>
                        <!--********************************** content end ***********************************-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection



@section('footer')
    <!-- Datatable -->
    <script src="{{ asset('') }}assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins-init/datatables.init.js"></script>
@endSection
