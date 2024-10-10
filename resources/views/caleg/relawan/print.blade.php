<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <style>
        html,
        body {
            background: #fff !important;
        }

        body> :not(.invoice-print) {
            display: none !important;
        }

        .invoice-print {
            min-width: 768px !important;
            font-size: 15px !important;
        }

        .invoice-print svg {
            fill: #6f6b7d !important;
        }

        .invoice-print * {
            border-color: rgba(75, 70, 92, 0.5) !important;
            color: #6f6b7d !important;
        }

        .dark-style .invoice-print th {
            color: #fff !important;
        }
    </style>
    <!-- PAGE TITLE HERE -->
    <title>Print Out</title>
    <link href= 
    "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity= 
    "sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">

</head>

<body>

    <div class="invoice-print p-0">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">

                <p class="mb-1">Nama Koordinator : {{ $relawan->nama }}</p>

                <p class="mb-1">No.Hp : {{ $relawan->no_wa }}</p>

                <p class="mb-1">Keterangan : {{ $relawan->keterangan }} </p>

                {{-- <p class="mb-1">Total Keluarga : {{ $total_kk }} </p> --}}

                {{-- <p class="mb-0">Tps : </p> --}}

            </div>
            <div>
                <div>
                    <img src="{{ asset('') }}assets/images/logoloading.png" width="40" alt="">
                    <img src="{{ asset('') }}assets/images/tulisanpasang.png" width="40" alt="">
                </div>
            </div>
        </div>

        <hr />

        <div class="table-responsive" style="font-size: 10px;">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        {{-- <th>KK/NIK Kep.</th> --}}
                        {{-- <th>Status Kel.</th> --}}
                        <th>Usia</th>
                        <th>No.Hp/No.Wa</th>
                        {{-- <th>Alamat</th> --}}
                        <th>kelurahan</th>
                        <th>TPS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengikut as $item)
                        <tr>
                            <td> {{ $loop->iteration }}</td>
                            <td><strong>{{ $item->pendukung_ref->nama }}</strong></td>
                            {{-- <td>{{ $item->kk }} <br> --}}
                            {{-- <td>{{ $item->status_keluarga }} <br> --}}
                            <td>{{ $item->pendukung_ref->usia }} <br>
                            <td>{{ $item->no_hp }} / {{ $item->no_wa }} <br>
                                {{-- <td>{{ $item->alamat_detail }} <br> --}}
                            <td>{{ $item->pendukung_ref->kelurahandesa_ref->nama }}</td>
                            <td><strong>{{ $item->pendukung_ref->tps }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12">
                <span class="fw-bold">Note:</span>
                <span>Data ini di cetak berdasarkan tanggal cetak! data bisa saja terjadi perubahan</span>
            </div>
        </div>
    </div>

    <!--**********************************
 Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script>
    <script src="{{ asset('') }}assets/js/custom.min.js"></script>
    <script src="{{ asset('') }}assets/js/dlabnav-init.js"></script>

</body>

</html>
