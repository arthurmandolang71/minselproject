@extends('template.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/datatables/css/jquery.dataTables.min.css">
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> --}}
@endSection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/dataprovidertim/">Data Provider</a></li>
                    <li class="breadcrumb-item"><a href="">Data Orang</a></li>
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
                                <a href="/dataprovidertim/create" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="fa fa-plus"></i>
                                    </span>Tambah Orang</a>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>No.Wa</th>
                                            <th>Keterangan</th>
                                            <th>Pengikut</th>
                                            <th>Target</th>
                                            <th>status</th>
                                            {{-- <th>#</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($relawan as $item)
                                            @php
                                                // dd($target_pengurus);
                                                if ($item->pengikut_ref->count() > 0 and $item->target_pendukung > 0) {
                                                    $persen =
                                                        ($item->pengikut_ref->count() / $item->target_pendukung) * 100;
                                                } else {
                                                    $persen = 0;
                                                }
                                            @endphp
                                            <tr>

                                                <td>{{ $item->nama }} <br>
                                                    {{-- <span>{{ $item->tim_ref->nama }}</span> --}}
                                                </td>
                                                <td>{{ $item->nik }} <br>
                                                <td>{{ $item->no_wa }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td><a href="" target="_blank"><span
                                                            class="badge badge-lg light badge-primary">{{ $item->pengikut_ref->count() }}
                                                            Pengikut</span> </a>
                                                </td>
                                                <td>
                                                    <span class="badge badge-lg light badge-primary">{{ $persen }}%
                                                        dari {{ $item->target_pendukung }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($item->is_active)
                                                        <span class="badge badge-lg light badge-primary">Aktif</span>
                                                    @else
                                                        <span class="badge badge-lg light badge-danger">Tidak
                                                            Aktif</span>
                                                    @endif
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>No.Wa</th>
                                            <th>Keterangan</th>
                                            <th>Pengikut</th>
                                            <th>Target</th>
                                            <th>status</th>
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
