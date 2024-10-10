@extends('dpw.template.main')

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
                    <li class="breadcrumb-item active"><a href="/pendukungcaleg/">Pendukung</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Input Pendukung</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">

                        <!--********************************** content start ***********************************-->
                        <div class="row container">
                            <div class="col">
                                <a href="/pendukungcaleg" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="bi bi-backspace-fill"></i>
                                    </span>Kembali</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="basic-form">
                                <form action="/pendukungcaleg/{{ $pendukung->id }}"
                                    class="form-valide-with-icon needs-validation" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('delete')

                                    <div class="card-header">
                                        <h4 class="card-title"> Hapus <b>{{ $pendukung->nama }}</b> sebagai pendukung ?</h4>
                                    </div>

                                    <input type="hidden" name="id_pendukung" value="{{ $pendukung->id }}">
                                    @foreach ($select_delete as $item)
                                        <div class="col-xl-12 col-xxl-12 col-12">
                                            <div class="form-check custom-checkbox mb-3 checkbox-info">
                                                <input name="pilih_hapus[]" value="{{ $item['name_value'] }}"
                                                    type="checkbox" class="form-check-input"
                                                    id="customCheckBox{{ $item['name_value'] }}">
                                                <label class="form-check-label"
                                                    for="customCheckBox{{ $item['name_value'] }}">
                                                    <h3>{{ $item['keterangan'] }}</h3>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                    <hr>

                                    <div class="mb-3 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="invalidCheck2" required>
                                            <label class="form-check-label" for="invalidCheck2">
                                                Anda yakin akan dihapus sebagai pendukung ?
                                            </label>
                                        </div>
                                        <button type="submit" class="btn me-2 btn-primary">Hapus dari Pendukung</button>
                                        <a href="/pendukungcaleg/index" class="btn btn-light">Batal</a>
                                    </div>
                                </form>
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


        <script>
            $(document).ready(function() {
                // SmartWizard initialize
                $('#smartwizard').smartWizard();
            });
        </script>
    @endSection
