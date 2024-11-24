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
                    <li class="breadcrumb-item active"><a href="/dataprovider/">Data Provider</a></li>
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
                                <a href="/dataprovider/create" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="fa fa-plus"></i>
                                    </span>Tambah Orang</a>
                            </div>
                            <br>

                            <form action="/dataprovider" method="get">
                                <div class="row">

                                    <div class="col-md-4">
                                        {{-- <label class="form-label" for="multicol-country">Nama</label> --}}
                                        @if ($cari_nama)
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                placeholder="John" value="{{ $cari_nama }}" />
                                        @else
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                placeholder="Masukan pencarian nama/marga" value="" />
                                        @endif
                                        {{-- <hr> --}}
                                    </div>

                                    <div class="col-md-4">
                                        {{-- <label class="form-label" for="multicol-country">Pilih Tim</label> --}}
                                        <select id="tim" name="tim" class="select2 form-select"
                                            data-allow-clear="true">
                                            @if ($select_tim)
                                                <option value="{{ $select_tim['id'] }}"> Pencarian
                                                    {{ $select_tim['nama'] }}</option>
                                            @else
                                                <option value="" selected>Pilih Tim</option>
                                            @endif

                                            @foreach ($tim_list as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <hr> --}}
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" href="/dpt/create" class="btn btn-block btn-primary"><span
                                                class="btn-icon-start text-primary"><i class="fa fa-search"></i>
                                            </span>Filter!</button>
                                    </div>

                                </div>
                            </form>

                            <hr>


                            <div class="table-responsive">
                                {{-- <table id="example" class="display" style="width:100%"> --}}
                                <table class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>No.Wa</th>
                                            <th>Keterangan</th>
                                            <th>Pengikut</th>
                                            <th>Target</th>
                                            <th>status</th>
                                            <th>#</th>
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

                                                <td>{{ $item->nama }} <br> </td>
                                                <td>{{ $item->nik }} <br></td>
                                                <td>{{ $item->no_wa }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td><a href="pendukungcaleg/index?referensi={{ $item->id }}"
                                                        target="_blank"><span
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
                                                    <a href="/dataprovider/{{ $item->id }}/edit"
                                                        class="btn btn-rounded btn-primary"><span
                                                            class="btn-icon-start text-primary"><i class="fa fa-edit"></i>
                                                        </span></a>
                                                    <a href='/dataprovider/{{ $item->id }}' target="_blank"
                                                        type='button' class='btn btn-print btn-info'><span
                                                            class='btn-icon-start text-info'><i
                                                                class='fa fa-print color-info'></i></span></a>
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
                                            <th>#</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="container">
                                {{ $relawan->links() }}
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
