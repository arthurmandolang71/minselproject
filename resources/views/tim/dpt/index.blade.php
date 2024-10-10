@extends('template.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/datatables/css/jquery.dataTables.min.css">
@endSection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Penjaringan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Cari DPT</a></li>
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

                            <!-- start content -->
                            <div class="container">
                                <form action="/dpttim" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">Kabupaten / kota</label>
                                            <select id="kabkota" name="kabkota" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_kabkota)
                                                    <option value="{{ $select_kabkota['id'] }}"> Pencarian
                                                        {{ $select_kabkota['nama'] }}</option>
                                                @else
                                                    <option value="" selected>Pilih Kabkota</option>
                                                @endif

                                                @foreach ($kabkota_list as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">Kecamatan</label>
                                            <select id="kecamatan" name="kecamatan" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_kecamatan)
                                                    <option value="{{ $select_kecamatan['id'] }}"> Pencarian
                                                        {{ $select_kecamatan['nama'] }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">Kelurahan/Desa</label>
                                            <select id="kelurahandesa" name="kelurahandesa" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_kelurahandesa)
                                                    <option value="{{ $select_kelurahandesa['id'] }}"> Pencarian
                                                        {{ $select_kelurahandesa['nama'] }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">TPS</label>
                                            <select id="tps" name="tps" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_tps)
                                                    <option value="{{ $select_tps }}"> Pencarian TPS
                                                        {{ $select_tps }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="col-md-8">
                                            {{-- <label class="form-label" for="multicol-country">Nama</label> --}}
                                            @if ($cari_nama)
                                                <input type="text" name="cari_nama" id="nama" class="form-control"
                                                    placeholder="John" value="{{ $cari_nama }}" />
                                            @else
                                                <input type="text" name="cari_nama" id="nama" class="form-control"
                                                    placeholder="Masukan pencarian nama/marga" value="" />
                                            @endif
                                            <hr>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" href="/dpt/create"
                                                class="btn btn-block btn-primary"><span
                                                    class="btn-icon-start text-primary"><i class="fa fa-search"></i>
                                                </span>Cari!</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Kabkota</th>
                                            <th>Kecamatan</th>
                                            <th>Kel./Desa</th>
                                            <th>Tps</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pemilih as $item)
                                            @php
                                                if ($item->pendukung) {
                                                    $status = 1;
                                                } else {
                                                    $status = 2;
                                                }
                                            @endphp

                                            <tr>
                                                <td><strong>{{ $item->nama }}</strong></td>
                                                <td>{{ $item->usia }}</td>
                                                <td>{{ $item->kabkota_ref->nama }}</td>
                                                <td>{{ $item->kecamatan_ref->nama }}</td>
                                                <td>{{ $item->kelurahandesa_ref->nama }}</td>
                                                <td>{{ $item->tps }}</td>
                                                </td>
                                                <td>
                                                    @if ($level_caleg == 1)
                                                        @if ($item->pendukung->pendukung_caleg_ri)
                                                            <span>sudah di input</span>
                                                        @else
                                                            <a href='/pendukungtim/create/{{ $item->id }}/{{ $status }}'
                                                                type='button' class='btn btn-rounded btn-info'><span
                                                                    class='btn-icon-start text-info'><i
                                                                        class='fa fa-plus color-info'></i></span></a>
                                                        @endif
                                                    @endif

                                                    @if ($level_caleg == 2)
                                                        @if ($item->pendukung->pendukung_caleg_prov)
                                                            <span>sudah di input</span>
                                                        @else
                                                            <a href='/pendukungtim/create/{{ $item->id }}/{{ $status }}'
                                                                type='button' class='btn btn-rounded btn-info'><span
                                                                    class='btn-icon-start text-info'><i
                                                                        class='fa fa-plus color-info'></i></span></a>
                                                        @endif
                                                    @endif

                                                    @if ($level_caleg == 3)
                                                        @if ($item->pendukung->pendukung_caleg_kabkota ?? null)
                                                            <span>sudah di input</span>
                                                        @else
                                                            <a href='/pendukungtim/create/{{ $item->id }}/{{ $status }}'
                                                                type='button' class='btn btn-rounded btn-info'><span
                                                                    class='btn-icon-start text-info'><i
                                                                        class='fa fa-plus color-info'></i></span></a>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Kabkota</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan/Desa</th>
                                            <th>Tps</th>

                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="container">
                                    {{ $pemilih->links() }}
                                </div>
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
                url: '/get_kecamatan/dpttim/' + id,
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
                url: '/get_kelurahandesa/dpttim/' + id,
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

{{-- get tps --}}
<script>
    $(document).ready(function() {

        // Department Change
        $('#kelurahandesa').change(function() {

            // Department id
            var id = $(this).val();

            // Empty the dropdown
            $('#tps').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: '/get_tps/dpttim/' + id,
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

                            var option = "<option value='" + nama + "'>" + nama +
                                "</option>";

                            $("#tps").append(option);
                        }
                    }

                }
            });
        });
    });
</script>
