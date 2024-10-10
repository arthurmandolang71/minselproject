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
                    <li class="breadcrumb-item active"><a href="/klasifikasibantuan">Klasifikasi bantuan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Klasifikasi</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">

                        <!--********************************** content start ***********************************-->
                        <div class="row container">
                            <div class="col-12">
                                <a href="/klasifkasibantuan" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="bi bi-backspace-fill"></i>
                                    </span>Kembali</a>
                            </div>
                        </div>

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

                            <div class="basic-form">
                                <form action="/klasifikasibantuan/{{ $klasifikasi_bantuan->id }}"
                                    class="form-valide-with-icon needs-validation" method="post"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="card-header">
                                        <h4 class="card-title">Data Klasifkasi</h4>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername">Nama Klasifikasi
                                            bantuan
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="bi bi-card-heading"></i> </span>
                                            <input name="nama"
                                                value="{{ old('nama', $klasifikasi_bantuan->nama), $klasifikasi_bantuan->nama }}"
                                                type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="validationCustomUsername"
                                                placeholder="Nama Klasifkasi. Contoh : Militansi">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername">Kwterangan
                                            Klasifikasi bantuan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="bi bi-card-heading"></i> </span>
                                            <input name="keterangan"
                                                value="{{ old('keterangan', $klasifikasi_bantuan->keterangan) }}"
                                                type="text"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                id="validationCustomUsername" placeholder="Masukan deskripsi Klasifkasi">
                                            @error('keterangan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="text-label form-label" for="validationCustomUsername">Apakah
                                            akan menonaktifkan klasifikasi bantuan ini ?</label>
                                        <div class="form-check form-switch">
                                            <input name="is_active" value="1" class="form-check-input" type="checkbox"
                                                id="flexSwitchCheckChecked"
                                                @if (old('is_active', $klasifikasi_bantuan->is_active)) checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">centang jika
                                                ingin mengnonaktifkan klasifikasi bantuan ini</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="invalidCheck2" required>
                                            <label class="form-check-label" for="invalidCheck2">
                                                Anda yakin data yang di input sudah benar ?
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn me-2 btn-primary">Simpan</button>
                                    <a href="/klasifkasibantuan" class="btn btn-light">Batal</a>
                                </form>
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
