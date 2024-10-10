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
                                <form action="/pendukung_referensi/" class="form-valide-with-icon needs-validation"
                                    method="post" enctype="multipart/form-data">
                                    @csrf

                                    @php
                                        if ($status == 1) {
                                            $id_dpt_ambil = $dpt->dpt;
                                        }

                                        if ($status == 2) {
                                            $id_dpt_ambil = $dpt->id;
                                        }
                                    @endphp

                                    @php
                                        $id_user = session()->get('caleg_id');
                                        $ambil_id_pendukung = request()->segment(3);
                                        $ambil_pendukung = App\Models\CalegPendukung::where(
                                            'dpt',
                                            $ambil_id_pendukung,
                                        )->first();
                                        if (isset($ambil_pendukung)) {
                                            $pendukung_ada = true;
                                        } else {
                                            $pendukung_ada = false;
                                        }

                                        $user_update_prov = $ambil_pendukung->user_update_prov ?? '';
                                        $user_update_ri = $ambil_pendukung->user_update_ri ?? '';

                                    @endphp

                                    <input type="hidden" value="{{ $id_dpt_ambil }}" name="dpt_id">

                                    <input type="hidden" value="{{ $dpt->pendukung_caleg_prov->id }}" name="pendukung_id">

                                    <input type="hidden" value="{{ $url_direct }}" name="url_direct">

                                    <div class="card-header">
                                        <h4 class="card-title"> Tambahkan <b>{{ $dpt->nama }}</b> Jadi pendukung</h4>
                                    </div>



                                    <div id="smartwizard" class="form-wizard order-create">
                                        <ul class="nav nav-wizard">
                                            <li><a class="nav-link" href="#form">
                                                    {{-- <span>DATA</span> --}}
                                                </a></li>

                                        </ul>


                                        <div class="">
                                            {{-- biodata --}}
                                            <div id="form">
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



                                                <hr>



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

                                                </div>

                                                <hr>

                                                <hr>

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
                                                                value="{{ old('no_wa', $dpt->pendukung_caleg_prov->no_wa ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('no_wa') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan Nomor WA aktif" readonly>
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
                                                                value="{{ old('no_hp', $dpt->pendukung_caleg_prov->no_hp ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('no_hp') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan No.Hp Aktif" readonly>
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
                                                                value="{{ old('alamat_detail', $dpt->pendukung_caleg_prov->alamat_detail ?? null) }}"
                                                                type="text"
                                                                class="form-control @error('alamat_detail') is-invalid @enderror"
                                                                id="validationCustomUsername"
                                                                placeholder="Masukan alamat detail" readonly>
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



                                        <div class="card-header">
                                            <h4 class="card-title">Klasifikasi Pemilih</h4>
                                        </div>

                                        <div class="row " style="">
                                            <div class="mb-6 col-md-6">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername">Pemberi Data</label>
                                                <div class="basic-form">
                                                    <select name="referensi_id" id="single-selecteff"
                                                        class="single-select-placeholder js-states @error('referensi_id') is-invalid @enderror">
                                                        <option value="">Pilih</option>
                                                        @foreach ($referensi as $item)
                                                            @if (old('referensi_id', $dpt->pendukung_caleg_prov->referensi_id ?? null) == $item->id)
                                                                <option value="{{ $item->id }}" selected>
                                                                    {{ $item->nama }}</option>
                                                            @else
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->nama }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('referensi_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-6 col-md-6">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername">Klasifikasi Pendukung</label>
                                                <div class="basic-form">
                                                    <select name="klasifikasi_id" id="single-selecte"
                                                        class="single-select-placeholder js-states @error('klasifikasi_id') is-invalid @enderror">
                                                        <option value="">Pilih</option>
                                                        @foreach ($klasifikasi as $item)
                                                            @if (old('klasifikasi_id', $dpt->pendukung_caleg_prov->klasifikasi_id ?? null) == $item->id)
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
        {{-- <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script> --}}
        <script src="{{ asset('') }}assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

        <script src="{{ asset('') }}assets/vendor/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('') }}assets/js/plugins-init/select2-init.js"></script>

        <script src="{{ asset('') }}assets/vendor/jquery-steps/build/jquery.steps.min.js"></script>
        <script src="{{ asset('') }}assets/vendor/jquery-validation/jquery.validate.min.js"></script>


        <!-- Form Steps -->
        <script src="{{ asset('') }}assets/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>
    @endSection
