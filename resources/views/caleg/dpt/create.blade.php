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
                    <li class="breadcrumb-item active"><a href="/dptcaleg/">DPT</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah DPT Manual</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">

                        {{-- {{-- <!--********************************** --}}
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="/collectdata/" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="text-label form-label" for="validationCustomUsername">Nama Lengkap
                                            sesuai KTP</label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="bi bi-card-heading"></i> </span>
                                            <input name="nama" value="{{ old('nama') }}" type="text"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                id="validationCustomUsername"
                                                placeholder="Masukan nama lengkap sesuai di KTP">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="text-label form-label" for="validationCustomUsername">
                                            Usia</label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="bi bi-card-heading"></i> </span>
                                            <input name="usia" value="{{ old('usia') }}" type="text"
                                                class="form-control @error('usia') is-invalid @enderror"
                                                id="validationCustomUsername" placeholder="Masukan usia pemilih">
                                            @error('usia')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="text-label form-label" for="validationCustomUsername">Jenis
                                                Kelamin</label>
                                            <div class="input-group">
                                                <select name="jenis_kelamin"
                                                    class="default-select form-control wide mb-3 @error('jenis_kelamin') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($jenis_kelamin as $item)
                                                        @if (old('jenis_kelamin') == $item)
                                                            <option value="{{ $item }}" selected>
                                                                {{ $item }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('jenis_kelamin')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="mb-3 col-md-6">
                                            <label class="text-label form-label" for="validationCustomUsername">TPS
                                            </label>
                                            <div class="input-group">
                                                <select name="tps" id="struktur_level"
                                                    class="default-select form-control wide mb-3 @error('struktur_level') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($tps as $item)
                                                        @if (old('struktur_level') == $item)
                                                            <option value="{{ $item }}" selected>
                                                                {{ $item }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('struktur_level')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label" for="multicol-country">Kabupaten / kota</label>
                                                <select id="kabkota" name="kabkota" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    {{-- @if ($select_kabkota)
                                                        <option value="{{ $select_kabkota['id'] }}"> ->
                                                            {{ $select_kabkota['nama'] }}</option>
                                                    @else
                                                        <option value="" selected>Pilih Kabkota</option>
                                                    @endif --}}

                                                    <option value="" selected>Pilih Kabkota</option>

                                                    @foreach ($kabkota as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="multicol-country">Kecamatan</label>
                                                <select id="kecamatan" name="kecamatan" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    {{-- @if ($select_kecamatan)
                                                        <option value="{{ $select_kecamatan['id'] }}"> ->
                                                            {{ $select_kecamatan['nama'] }}</option>
                                                    @endif --}}
                                                    <option value="">Pilih</option>
                                                </select>
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="multicol-country">Kelurahan/Desa</label>
                                                <select id="kelurahandesa" name="kelurahandesa" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    {{-- @if ($select_kelurahandesa)
                                                        <option value="{{ $select_kelurahandesa['id'] }}"> ->
                                                            {{ $select_kelurahandesa['nama'] }}</option>
                                                    @endif --}}
                                                    <option value="">Pilih</option>
                                                </select>
                                                <hr>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <label class="form-label" for="multicol-country">TPS</label>
                                                <select id="tps" name="tps" class="select2 form-select"
                                                    data-allow-clear="true">
                                                    @foreach ($tps as $item)
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                <hr>
                                            </div> --}}
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="text-label form-label" for="validationCustomUsername">
                                                Alamat</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-card-heading"></i> </span>
                                                <input name="alamat" value="{{ old('alamat') }}" type="text"
                                                    class="form-control @error('alamat') is-invalid @enderror"
                                                    id="validationCustomUsername" placeholder="Masukan alamat pemilih">
                                                @error('alamat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>





                                    </div>
                                    {{-- <div class="input-group mb-3">
                                    <div class="form-file">
                                        <input type="file" name="file_pdf"
                                            class="form-file-input form-control @error('file_pdf') is-invalid @enderror">
                                    </div>
                                    <span class="input-group-text">Upload</span>
                                    @error('file_pdf')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}

                                    <hr>

                                    <button type="submit" class="btn rounded-pill btn-primary">Tambah</button>
                            </form>

                        </div>
                        <!--********************************** --}}
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
@endSection

<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        // Department Change
        $('#kabkota').change(function() {

            // Department id
            var id = $(this).val();

            // Empty the dropdown
            $('#kecamatan').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: '/get_kecamatan/dptcaleg/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);

                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }

                    console.log(len);

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var nama = response['data'][i].nama;

                            var option = "<option value='" + id + "'>" + nama + "</option>";

                            $("#kecamatan").append(option);
                        }
                    }

                }
            });
        });
    });
</script>

{{-- get kelurahan --}}
<script>
    $(document).ready(function() {

        // Department Change
        $('#kecamatan').change(function() {
            var id = $(this).val();
            // Empty the dropdown
            $('#kelurahandesa').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: '/get_kelurahandesa/dptcaleg/' + id,
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

                            $("#kelurahandesa").append(option);
                        }
                    }

                }
            });
        });
    });
</script>
