@extends('template.main')

@section('header')
    <!-- Material color picker -->
    <link href="{{ asset('') }}assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">

    <!-- Pick date -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/pickadate/themes/default.date.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Form step -->
    <link href="{{ asset('') }}assets/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css" rel="stylesheet">
@endSection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/pendukung/">Pendukung</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Daftar Pemberi Data</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">

                        <!--********************************** content start ***********************************-->
                        <div class="row container">
                            <div class="col">
                                <a href="{{ $url_direct }}" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="bi bi-backspace-fill"></i>
                                    </span>Kembali</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="basic-form">

                                <h4 class="text-primary mb-0">{{ $pendukung->pendukung_ref->nama }}</h4>
                                <h4 class="pt-3">NIK : <b>{{ $pendukung->ktp }}</b></h4>
                                <h4 class="pt-3">Usia : <b>{{ $pendukung->pendukung_ref->usia }}</b></h4>

                                <h4 class="pt-3">Kecamatan : <b>{{ $pendukung->pendukung_ref->kecamatan_ref->nama }}</b>
                                </h4>
                                <h4 class="pt-3">Kelurahan/Desa :
                                    <b>{{ $pendukung->pendukung_ref->kelurahandesa_ref->nama }}</b>
                                </h4>

                                <h4 class="pt-3">Alamat : <b>{{ $pendukung->alamat_detail }}</b></h4>

                                {{-- <h4 class="pt-3">TPS : <b>{{ $pendukung->tps }}</b></h4> --}}

                                <div class="alert alert-primary" role="alert">
                                    Data di entry pertama kali pada {{ $pendukung->created_at->diffForHumans() }} dan
                                    di
                                    referensikan dari <b>{{ $pendukung->relawan_ref->nama }} </b>
                                </div>

                                @foreach ($pendukung_referensi as $item)
                                    <div class="alert alert-danger" role="alert">
                                        Kemudian di tambahkan oleh <b>{{ $item->relawan_ref->nama }} </b> pada
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                @endforeach

                            </div>
                            <!--********************************** content end ***********************************-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endSection


    @section('footer')
        <!-- Daterangepicker -->
        <!-- momment js is must -->
        <script src="{{ asset('') }}assets/vendor/moment/moment.min.js"></script>
        <script src="{{ asset('') }}assets/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- pickdate -->
        <script src="{{ asset('') }}assets/vendor/pickadate/picker.js"></script>
        <script src="{{ asset('') }}assets/vendor/pickadate/picker.date.js"></script>

        <!-- Material color picker -->
        <script
            src="{{ asset('') }}assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js">
        </script>

        <script src="{{ asset('') }}assets/js/plugins-init/material-date-picker-init.js"></script>
        <!-- Pickdate -->
        <script src="{{ asset('') }}assets/js/plugins-init/pickadate-init.js"></script>



        <!--  vendors -->
        {{-- <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script> --}}
        <script src="{{ asset('') }}assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

        <script src="{{ asset('') }}assets/vendor/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('') }}assets/js/plugins-init/select2-init.js"></script>

        <script src="{{ asset('') }}assets/vendor/jquery-steps/build/jquery.steps.min.js"></script>
        <script src="{{ asset('') }}assets/vendor/jquery-validation/jquery.validate.min.js"></script>


        <!-- Form Steps -->
        <script src="{{ asset('') }}assets/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>
    @endSection
