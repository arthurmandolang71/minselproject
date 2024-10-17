@extends('template.main')

@section('header')
@endSection
{{--  --}}
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/dptcaleg/dash?prov=71">Penjaringan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard DPT</a></li>
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
                                <form action="/collectdata/dash?prov=71" method="get">
                                    <input type="hidden" name="prov" value="71">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">Kabupaten / kota</label>
                                            <select id="kabkota" name="kabkota" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_kabkota)
                                                    <option value="{{ $select_kabkota['id'] }}"> ->
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
                                                    <option value="{{ $select_kecamatan['id'] }}"> ->
                                                        {{ $select_kecamatan['nama'] }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="multicol-country">Kelurahan/Desa</label>
                                            <select id="kelurahandesa" name="kelurahandesa" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_kelurahandesa)
                                                    <option value="{{ $select_kelurahandesa['id'] }}"> ->
                                                        {{ $select_kelurahandesa['nama'] }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <label class="form-label" for="multicol-country">TPS</label>
                                            <select id="tps" name="tps" class="select2 form-select"
                                                data-allow-clear="true">
                                                @if ($select_tps)
                                                    <option value="{{ $select_tps }}"> Pencarian ->
                                                        {{ $select_tps }}</option>
                                                @endif
                                                <option value="">Pilih</option>
                                            </select>
                                            <hr>
                                        </div> --}}

                                        <div class="col-md-12">
                                            <button type="submit" href="/dpt/create"
                                                class="btn btn-block btn-primary"><span
                                                    class="btn-icon-start text-primary"><i class="fa fa-arrow-down"></i>
                                                </span>Dashboard</button>
                                        </div>
                                    </div>
                                </form>
                            </div>



                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div>
                                        <h4 class="card-title mb-2">Statistik Demografi Usia</h4>
                                        <span class="fs-12">DPT 2024 berdasarkan Usia</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="pie_chart1"></canvas>
                                    <ul class="card-list mt-4">
                                        <li><span class="bg-light circle"></span>Pre
                                            Boomer<span>{{ $total_pemilih_PB }}</span></li>
                                        <li><span class="bg-success circle"></span>Baby
                                            Boomer<span>{{ $total_pemilih_BB }}</span></li>
                                        <li><span class="bg-warning circle"></span>Gen X<span>
                                                {{ $total_pemilih_X }}</span></li>
                                        <li><span class="bg-info circle"></span>Gen
                                            Milenial<span>{{ $total_pemilih_Y }}</span></li>
                                        <li><span class="bg-danger circle"></span>Gen
                                            Z<span>{{ $total_pemilih_Z }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div>
                                        <h4 class="card-title mb-2">Statistik Jenis Kelamin</h4>
                                        <span class="fs-12">DPT 2024 berdasarkan Jenis Kelamin</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="pie_chart2"></canvas>
                                    <ul class="card-list mt-4">
                                        <li><span class="bg-blue circle"></span>Laki-laki<span>
                                                {{ $jenis_kelamin['L'] ?? null }}
                                            </span>
                                        </li>
                                        <li><span
                                                class="bg-success circle"></span>Perempuan<span>{{ $jenis_kelamin['P'] ?? null }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div>
                                        <svg width="35px" height="34px">
                                            <path fill-rule="evenodd" fill="rgb(91, 207, 197, 1)"
                                                d="M32.482,9.730 C31.092,6.789 28.892,4.319 26.120,2.586 C22.265,0.183 17.698,-0.580 13.271,0.442 C8.843,1.458 5.074,4.140 2.668,7.990 C0.255,11.840 -0.509,16.394 0.514,20.822 C1.538,25.244 4.224,29.008 8.072,31.411 C10.785,33.104 13.896,34.000 17.080,34.000 L17.286,34.000 C20.456,33.960 23.541,33.044 26.213,31.358 C26.991,30.866 27.217,29.844 26.725,29.067 C26.234,28.291 25.210,28.065 24.432,28.556 C22.285,29.917 19.799,30.654 17.246,30.687 C14.627,30.720 12.067,29.997 9.834,28.609 C6.730,26.671 4.569,23.644 3.752,20.085 C2.934,16.527 3.546,12.863 5.486,9.763 C9.488,3.370 17.957,1.418 24.359,5.414 C26.592,6.808 28.360,8.793 29.477,11.157 C30.568,13.460 30.993,16.016 30.707,18.539 C30.607,19.448 31.259,20.271 32.177,20.371 C33.087,20.470 33.911,19.820 34.011,18.904 C34.363,15.764 33.832,12.591 32.482,9.730 L32.482,9.730 Z" />
                                            <path fill-rule="evenodd" fill="rgb(1, 207, 197, 1)"
                                                d="M22.593,11.237 L14.575,19.244 L11.604,16.277 C10.952,15.626 9.902,15.626 9.250,16.277 C8.599,16.927 8.599,17.976 9.250,18.627 L13.399,22.770 C13.725,23.095 14.150,23.254 14.575,23.254 C15.001,23.254 15.427,23.095 15.753,22.770 L24.940,13.588 C25.592,12.937 25.592,11.888 24.940,11.237 C24.289,10.593 23.238,10.593 22.593,11.237 L22.593,11.237 Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-black invoice-num">{{ $total_pemilih_turunan }}</h2>
                                        <span class="text-black fs-18">DPT Terdaftar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="card">
            <div class="card-body">
                <!-- start content -->
                <div class="card-header border-0 pb-0">
                    <div>
                        <h4 class="card-title mb-2">Statistik Wilayah</h4>
                        <span class="fs-12">Data DPT 2024 Berdasarkan Wilayah</span>
                    </div>
                </div>

                <div class="card-body">
                    <br>
                    <canvas id="barChart_1"></canvas>
                </div>

            </div>
        </div>



    </div>
    </div>
@endSection






@section('footer')
    <script src="{{ asset('') }}assets/vendor/chart.js/Chart.bundle.min.js"></script>
    <!-- Apex Chart -->
    <script src="{{ asset('') }}assets/vendor/apexchart/apexchart.js"></script>

    <script src="{{ asset('') }}assets/vendor/chart.js/Chart.bundle.min.js"></script>

    <script>
        var dlabSparkLine = function() {
            let draw = Chart.controllers.line.__super__.draw; //draw shadow

            var screenWidth = $(window).width();

            var barChart1 = function() {
                if (jQuery('#barChart_1').length > 0) {
                    const barChart_1 = document.getElementById("barChart_1").getContext('2d');

                    barChart_1.height = 100;

                    new Chart(barChart_1, {
                        type: 'bar',
                        data: {
                            defaultFontFamily: 'Poppins',
                            labels: [
                                @foreach ($list_turunan as $item)
                                    "{{ $item->nama }}",
                                @endforeach

                            ],
                            datasets: [{
                                label: "DPT : ",
                                data: [
                                    @foreach ($list_turunan as $item)
                                        "{{ $item->jumlah }}",
                                    @endforeach
                                ],
                                borderColor: 'rgba(91, 207, 197, 1)',
                                borderWidth: "0",
                                backgroundColor: 'rgba(91, 207, 197, 1)'
                            }]
                        },
                        options: {
                            legend: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    // Change here
                                    barPercentage: 0.5
                                }]
                            }
                        }
                    });
                }
            }


            var pieChart1 = function() {
                //pie chart
                if (jQuery('#pie_chart1').length > 0) {
                    //pie chart
                    const pie_chart = document.getElementById("pie_chart1").getContext('2d');
                    // pie_chart.height = 100;
                    new Chart(pie_chart, {
                        type: 'pie',
                        data: {
                            defaultFontFamily: 'Poppins',
                            datasets: [{
                                data: [{{ $total_pemilih_PB }}, {{ $total_pemilih_BB }},
                                    {{ $total_pemilih_X }}, {{ $total_pemilih_Y }},
                                    {{ $total_pemilih_Z }}
                                ],
                                borderWidth: 0,
                                backgroundColor: [
                                    "rgb(217, 217, 217)",
                                    "rgb(92, 214, 92)",
                                    "rgb(255, 153, 0)",
                                    "rgb(136, 0, 204)",
                                    "rgb(204, 51, 0)"
                                ],
                                hoverBackgroundColor: [
                                    "rgb(217, 217, 217)",
                                    "rgb(92, 214, 92)",
                                    "rgb(255, 153, 0)",
                                    "rgb(136, 0, 204)",
                                    "rgb(204, 51, 0)"
                                ]

                            }],
                            labels: [
                                "Pre Boomer",
                                "Baby Boomer",
                                "Generasi X",
                                "Generasi Milenial",
                                "Generasi Z"
                            ]
                        },
                        options: {
                            responsive: false,
                            legend: false,
                            maintainAspectRatio: false
                        }
                    });
                }
            }

            var pieChart2 = function() {
                //pie chart
                if (jQuery('#pie_chart2').length > 0) {
                    //pie chart
                    const pie_chart = document.getElementById("pie_chart2").getContext('2d');
                    // pie_chart.height = 100;
                    new Chart(pie_chart, {
                        type: 'pie',
                        data: {
                            defaultFontFamily: 'Poppins',
                            datasets: [{
                                data: [{{ $jenis_kelamin['L'] ?? null }},
                                    {{ $jenis_kelamin['P'] ?? null }}
                                ],
                                borderWidth: 0,
                                backgroundColor: [
                                    "rgb(26, 117, 255)",
                                    "rgb(255, 77, 148)",
                                ],
                                hoverBackgroundColor: [
                                    "rgb(26, 117, 255)",
                                    "rgb(255, 77, 148)",
                                ]

                            }],
                            labels: [
                                "Laki-laki",
                                "Perempuan",
                            ]
                        },
                        options: {
                            responsive: false,
                            legend: false,
                            maintainAspectRatio: false
                        }
                    });
                }
            }

            /* Function ============ */
            return {
                init: function() {},
                load: function() {
                    barChart1();
                    pieChart1();
                    pieChart2();
                },
                resize: function() {
                    barChart1();
                    pieChart1();
                    pieChart2();
                }
            }

        }();

        jQuery(document).ready(function() {});

        jQuery(window).on('load', function() {
            dlabSparkLine.load();
        });
    </script>
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

{{-- get tps --}}
{{-- <script>
    $(document).ready(function() {


        // Department Change
        $('#kelurahandesa').change(function() {

            // Department id
            var id = $(this).val();

            // Empty the dropdown
            $('#tps').find('option').not(':first').remove();

            // AJAX request 
            $.ajax({
                url: '/get_tps/dpt/' + id,
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
</script> --}}
