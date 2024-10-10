@extends('template.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/datatables/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endSection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/tim/">Tim kemenangan</a></li>
                    <li class="breadcrumb-item"><a href="">Data</a></li>
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
                                <a href="/tim/create" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="fa fa-plus"></i>
                                    </span>Tambah Tim</a>
                            </div>


                            <div class="table-responsive">
                                <table id="example">
                                    <thead>
                                        <tr>
                                            <th>Nama Tim</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tim as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    @if ($item->is_active)
                                                        <span class="badge badge-lg light badge-primary">Aktif</span>
                                                    @else
                                                        <span class="badge badge-lg light badge-danger">Tidak
                                                            Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/tim/{{ $item->id }}/edit"
                                                        class="btn btn-rounded btn-primary"><span
                                                            class="btn-icon-start text-primary"><i class="fa fa-edit"></i>
                                                        </span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Tim</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>#</th>
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
