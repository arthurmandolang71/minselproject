@extends('template.main')

@section('header')
    <!-- Material color picker -->
    <link href="{{ asset('') }}assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">

    <!-- Pick date -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/pickadate/themes/default.date.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endSection


@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/dpt">DPT 2024</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Import</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Import DPT 2024 (file csv)</h4>
                        </div>
                        <!--**********************************
                                                                                                                                                                                                                                                                                                                                                                content start
                                                                                                                                                                                                                                                                                                                                                            ***********************************-->
                        <div class="card-body">
                            @if (session()->has('pesan'))
                                <div class="container text-center">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ session('pesan') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <form action="/dpt" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 col-md-6">
                                    <label class="text-label form-label" for="validationCustomUsername">Kecamatan</label>
                                    <div class="basic-form">
                                        <select name="kecamatan_id" id="kecamatan"
                                            class="single-select-placeholder js-states" required>
                                            <option value="">Pilih</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="multicol-country">Kelurahan / Desa</label>
                                    <select id="kelurahan_desa" name="wilayah_id" class="form-select" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-file">
                                        <input type="file" name="file_csv" class="form-file-input form-control" required>
                                    </div>
                                    <span class="input-group-text">Upload</span>
                                </div>

                                <button type="submit" class="btn rounded-pill btn-primary">Import</button>
                            </form>

                        </div>
                        <!--**********************************
                                                                                                                                                                                                                                                                                                                                                                content start
                                                                                                                                                                                                                                                                                                                                                            ***********************************-->
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
    <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script src="{{ asset('') }}assets/vendor/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}assets/js/plugins-init/select2-init.js"></script>
@endSection

<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        // Department Change
        $('#kecamatan').change(function() {

            // Department id
            var id = $(this).val();

            // Empty the dropdown
            $('#kelurahan_desa').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: '/get_kelurahandesaimport/dpt/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);

                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var nama = response['data'][i].nama;

                            var option = "<option value='" + id + "'>" + nama + "</option>";

                            $("#kelurahan_desa").append(option);
                        }
                    }

                }
            });
        });
    });
</script>
