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
                                <a href="{{ $url_direct }}" class="btn btn-block btn-primary"><span
                                        class="btn-icon-start text-primary"><i class="bi bi-backspace-fill"></i>
                                    </span>Kembali</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="basic-form">
                                <form action="/pendukungtim/" class="form-valide-with-icon needs-validation" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    @php
                                        if ($status == 1) {
                                            $id_dpt_ambil = $dpt->dpt;
                                        }

                                        if ($status == 2) {
                                            $id_dpt_ambil = $dpt->id;
                                        }
                                    @endphp
                                    <input type="hidden" value="{{ $id_dpt_ambil }}" name="dpt_id">

                                    <input type="hidden" value="{{ $status }}" name="status">

                                    <input type="hidden" value="{{ $url_direct }}" name="url_direct">

                                    <div class="card-header">
                                        <h4 class="card-title"> Tambahkan <b>{{ $dpt->nama }}</b> Jadi pendukung</h4>
                                    </div>

                                    @php
                                        $id_user = session()->get('caleg_id');
                                        $ambil_id_pendukung = request()->segment(3);
                                        $ambil_pendukung = App\Models\CalegPendukung::where('dpt', $ambil_id_pendukung)->first();
                                        if (isset($ambil_pendukung)) {
                                            $pendukung_ada = true;
                                        } else {
                                            $pendukung_ada = false;
                                        }

                                        $user_update_prov = $ambil_pendukung->user_update_prov ?? '';
                                        $user_update_ri = $ambil_pendukung->user_update_ri ?? '';

                                    @endphp

                                    <div id="smartwizard" class="form-wizard order-create">
                                        <ul class="nav nav-wizard">
                                            <li><a class="nav-link" href="#form">
                                                    {{-- <span>DATA</span> --}}
                                                </a></li>
                                            {{-- @php

                                                // }
                                                if ($user_update_prov == null or $id_user == $user_update_prov) {
                                                    echo ' <li><a class="nav-link" href="#form_a">
                                                    <span>PROV</span>
                                                </a></li>';
                                                }

                                            @endphp
                                            @php

                                                if ($user_update_ri == null or $id_user == $user_update_ri) {
                                                    echo '  <li><a class="nav-link" href="#form_b">
                                                    <span>RI</span>
                                                </a></li>';
                                                }
                                            @endphp --}}
                                        </ul>


                                        <div class="tab-content">
                                            {{-- biodata --}}
                                            <div id="form" class="tab-pane" role="tabpanel">
                                                <div class="mb-12 col-md-12">
                                                    <label class="text-label form-label" for="validationCustomUsername">Nama
                                                        Lengkap</label>
                                                    <div class="input-group">
                                                        <br>
                                                        <span class="input-group-text"> <i
                                                                class="bi bi-person-bounding-box"></i>
                                                        </span>
                                                        <input name="nama" value="{{ old('nama', $dpt->nama) }}"
                                                            type="text"
                                                            class="form-control @error('nama') is-invalid @enderror"
                                                            id="validationCustomUsername" placeholder="Nama Lengkap"
                                                            disabled>
                                                        @error('nama')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="mb-4 col-md-4">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Nomor Kartu
                                                            Tanda Penduduk (KTP)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i
                                                                    class="bi bi-credit-card-fill"></i>
                                                            </span>
                                                            <input name="ktp"
                                                                value="{{ old('ktp', $dpt->pendukung_caleg_kabkota->ktp ?? null) }}"
                                                                type="text"
                                                                class="form-control  @error('ktp') is-invalid @enderror"
                                                                id=""
                                                                placeholder="Masukan Nomor Kartu Tanda Penduduk (KTP)" />
                                                            @error('ktp')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 col-md-4">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">KK/KTP dari Kepala
                                                            Keluarga</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i
                                                                    class="bi bi-credit-card-fill"></i>
                                                            </span>
                                                            <input name="kk"
                                                                value="{{ old('kk', $dpt->pendukung_caleg_kabkota->kk ?? null) }}"
                                                                type="text"
                                                                class="form-control  @error('kk') is-invalid @enderror"
                                                                id=""
                                                                placeholder="Masukan KK/KTP Kepala Keluaraga" />
                                                            @error('kk')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 col-md-4">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Status
                                                            Keluarga</label>
                                                        <div class="input-group">
                                                            <select name="status_keluarga"
                                                                class="default-select form-control wide mb-3 @error('status_keluarga') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($status_keluarga as $item)
                                                                    @if (old('status_keluarga', $dpt->pendukung_caleg_kabkota->status_keluarga ?? null) == $item)
                                                                        <option value="{{ $item }}" selected>
                                                                            {{ $item }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item }}">
                                                                            {{ $item }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('status_keluarga')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>



                                                <hr>

                                                <div class="row ">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Tempat
                                                            Lahir</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i
                                                                    class="bi bi-house-door-fill"></i>
                                                            </span>
                                                            <input name="tempat_lahir"
                                                                value="{{ old('tempat_lahir', $dpt->pendukung_caleg_ri->tempat_lahir ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan tempat lahir">
                                                            @error('tempat_lahir')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Tanggal
                                                            Lahir</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i
                                                                    class="bi bi-calendar4-event"></i>
                                                            </span>
                                                            <input name="tanggal_lahir"
                                                                value="{{ old('tanggal_lahir', $dpt->pendukung_caleg_ri->tanggal_lahir ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                                placeholder="Masukan tanggal lahir" id="mdate">
                                                            @error('tanggal_lahir')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row ">
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Jenis
                                                            Kelamin</label>
                                                        <div class="input-group">
                                                            <select name="jenis_kelamin"
                                                                class="default-select form-control wide mb-3 @error('jenis_kelamin') is-invalid @enderror"
                                                                disabled>
                                                                <option value="">Pilih</option>
                                                                @foreach ($jenis_kelamin as $item)
                                                                    @if (old('jenis_kelamin', $dpt->jenis_kelamin) == $item)
                                                                        <option value="{{ $item }}" selected>
                                                                            {{ $item }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item }}">
                                                                            {{ $item }}
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
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Status
                                                            Perkawinan</label>
                                                        <div class="input-group">
                                                            <select name="status_perkawinan"
                                                                class="default-select form-control wide mb-3 @error('status_perkawinan') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($status_perkawinan as $item)
                                                                    @if (old('status_perkawinan', $dpt->pendukung_caleg_ri->status_perkawinan ?? null) == $item)
                                                                        <option value="{{ $item }}" selected>
                                                                            {{ $item }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item }}">
                                                                            {{ $item }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('status_perkawinan')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row ">
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Agama</label>
                                                        <div class="basic-form">
                                                            <select name="agama"
                                                                class="default-select form-control wide mb-3 @error('agama') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($agama as $item)
                                                                    @if (old('agama', $dpt->pendukung_caleg_ri->agama ?? null) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            {{ $item->nama }}</option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('agama')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Pekerjaan</label>
                                                        <div class="basic-form">
                                                            <select name="pekerjaan" id="single-select2"
                                                                class="single-select-placeholder js-states @error('pekerjaan') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($pekerjaan as $item)
                                                                    @if (old('pekerjaan', $dpt->pendukung_caleg_ri->pekerjaan ?? null) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            {{ $item->nama }}</option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('pekerjaan')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="card-header">
                                                    <h4 class="card-title">Klasifikasi Pemilih</h4>
                                                </div>

                                                <div class="row ">

                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Klasifikasi Pendukung</label>
                                                        <div class="basic-form">
                                                            <select name="klasifikasi_id" id="single-selecte"
                                                                class="single-select-placeholder js-states @error('klasifikasi_id') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($klasifikasi as $item)
                                                                    @if (old('klasifikasi_id', $dpt->pendukung_caleg_ri->klasifikasi_id ?? null) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            {{ $item->nama }}</option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('klasifikasi_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Bantuan</label>
                                                        <div class="basic-form">
                                                            <select name="klasifikasi_bantuan_id" id="single-select"
                                                                class="single-select-placeholder js-states @error('klasifikasi_bantuan_id') is-invalid @enderror">
                                                                <option value="">Pilih</option>
                                                                @foreach ($bantuan as $item)
                                                                    @if (old('klasifikasi_bantuan_id', $dpt->pendukung_caleg_ri->klasifikasi_bantuan_id ?? null) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            {{ $item->nama }}</option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @error('klasifikasi_bantuan_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="card-header">
                                                    <h4 class="card-title">Kontak Pendukung</h4>
                                                </div>

                                                <div class="row ">
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">No.Whatsapp</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i class="bi bi-envelope"></i>
                                                            </span>
                                                            <input name="no_wa"
                                                                value="{{ old('no_wa', $dpt->pendukung_caleg_ri->no_wa ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('no_wa') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan Nomor WA aktif">
                                                            @error('no_wa')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-6 col-md-6">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">No.Hp</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-telephone-fill"></i>
                                                            </span>
                                                            <input name="no_hp"
                                                                value="{{ old('no_hp', $dpt->pendukung_caleg_ri->no_hp ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('no_hp') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan No.Hp Aktif">
                                                            @error('no_hp')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="mb-12 col-md-12">
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername">Alamat
                                                            Detail</label>
                                                        <div class="input-group">
                                                            <br>
                                                            <span class="input-group-text"> <i class="bi bi-house"></i>
                                                            </span>
                                                            <input name="alamat_detail"
                                                                value="{{ old('alamat_detail', $dpt->pendukung_caleg_ri->alamat_detail ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('alamat_detail') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan alamat detail">
                                                            @error('alamat_detail')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>





                                            </div>


                                            {{-- caleg a --}}
                                            {{-- <div id="form_a" class="tab-pane" role="tabpanel">

                                                @php
                                                    $dapil_id_user = session()->get('dapil_id');
                                                    $kabkota = App\Models\DapilKabkotaWilayah::where('dapil_kabkota_id', $dapil_id_user)->first()->kabkota;
                                                    $dapil_prov_id = App\Models\DapilProvWilayah::where('kabkota', $kabkota)->first()->dapil_prov_id;
                                                    $caleg_prov = App\Models\CalegProv::orderBy('no_urut', 'asc')
                                                        ->where('dapil_prov', $dapil_prov_id)
                                                        ->get();
                                                @endphp

                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="mb-12">
                                                                <h4 class="card-title">Apakah pendukung ini akan mendukung
                                                                    calon DPRD Provinsi dari Partai Nasdem ?</h4>
                                                                <p>Jika Iya Silakan Pilih Calon DPRD Provinsi Nasdem</p>
                                                            </div>
                                                            <select name="caleg_prov" id="single-select3"
                                                                class="single-select-placeholder js-states">
                                                                <option
                                                                    value="TIDAK MEMILIH CALEG DPR PROVINSI DARI NASDEM">
                                                                    TIDAK MEMILIH CALEG PROVINSI SULUT</option>
                                                                @foreach ($caleg_prov as $item)
                                                                    @if (old('caleg_prov', $dpt->caleg_prov) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            No.Urut {{ $item->no_urut }} |
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            No.Urut {{ $item->no_urut }} |
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <br> <br> <br> <br> <br> <br>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div> --}}


                                            {{-- caleg a --}}
                                            {{-- <div id="form_b" class="tab-pane" role="tabpanel">

                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="mb-12">
                                                                <h4 class="card-title">Apakah pendukung ini akan
                                                                    mendukung
                                                                    calon DPR RI dari Partai Nasdem ?</h4>
                                                                <p>Jika Iya Silakan Pilih Calon DPR RI Nasdem</p>
                                                            </div>

                                                            @php
                                                                $caleg_ri = App\Models\CalegRi::orderBy('no_urut', 'asc')->get();
                                                            @endphp

                                                            <select name="caleg_ri" id="single-select2"
                                                                class="single-select-placeholder js-states">
                                                                <option value="TIDAK MEMILIH CALEG DPR RI DARI NASDEM">
                                                                    TIDAK MEMILIH CALEG DPR RI
                                                                    DARI NASDEM</option>
                                                                @foreach ($caleg_ri as $item)
                                                                    @if (old('caleg_ri', $dpt->caleg_ri) == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            No.Urut {{ $item->no_urut }} |
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            No.Urut {{ $item->no_urut }} |
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <br> <br> <br> <br> <br> <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                        </div>

                                        <div class="mb-12 col-md-12">
                                            <label class="text-label form-label" for="validationCustomUsername">Foto
                                                (ktp/dll)
                                            </label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input name="foto" type="file"
                                                        class="form-file-input form-control @error('foto') is-invalid @enderror"
                                                        id="image1" onchange="priviewImage1()">
                                                </div>
                                                <span class="input-group-text">Upload</span>
                                                @error('foto')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div>
                                                    <img src="{{ $dpt->pendukung_caleg_ri->alamat_detail ?? null }}"
                                                        class="img-preview1 img-fluid">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="invalidCheck2" required>
                                                <label class="form-check-label" for="invalidCheck2">
                                                    Anda yakin akan menambahkan sebagai pendukung ?
                                                </label>
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn me-2 btn-primary">Simpan Data</button>
                                            <a href="{{ $url_direct }}" class="btn btn-light">Batal</a>
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
        <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script>
        <script src="{{ asset('') }}assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

        <script src="{{ asset('') }}assets/vendor/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('') }}assets/js/plugins-init/select2-init.js"></script>

        <script src="{{ asset('') }}assets/vendor/jquery-steps/build/jquery.steps.min.js"></script>
        <script src="{{ asset('') }}assets/vendor/jquery-validation/jquery.validate.min.js"></script>


        <!-- Form Steps -->
        <script src="{{ asset('') }}assets/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>

        <script>
            function priviewImage1() {
                const image = document.querySelector('#image1');
                const view = document.querySelector('.img-preview1');

                view.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    view.src = oFREvent.target.result;
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                // SmartWizard initialize
                $('#smartwizard').smartWizard();
            });
        </script>
    @endSection
