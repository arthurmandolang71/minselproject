@extends('template.main')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/welcome">Pengaturan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Target Suara</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile card card-body px-3 pt-3 pb-0">
                        <div class="profile-head">
                            @if (session()->has('pesan'))
                                <div class="container text-center">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ session('pesan') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <br><Br>
                            @endif
                            <div class="profile-info">
                                <div class="profile-photo">
                                    <img src="{{ $profil->foto_profil }}" class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="profile-details">
                                    <div class="profile-name px-3 pt-2">
                                        <h4 class="text-primary mb-0">{{ $profil->name }}</h4>
                                        <p>{{ $profil->username }}</p>
                                    </div>
                                </div>
                            </div>
                            <form action="/target/" method="post">
                                @csrf
                                @method('PUT')
                                <small class="card-text text-uppercase">Target Suara</small>
                                <div class="form-floating">
                                    <input type="text" name="target_pendukung"
                                        class="form-control @error('target_pendukung') is-invalid @enderror"
                                        id="floatingInput" placeholder="Masukan target_pendukung baru"
                                        aria-describedby="floatingInputHelp"
                                        value="{{ old('target_pendukung', $target->target_pendukung) }}" required />
                                    <label for="floatingInput">Target Suara</label>
                                    <div id="floatingInputHelp" class="form-text">
                                        Masukan Target Suara
                                    </div>
                                    @error('target_pendukung')
                                        <div id="floatingInputHelp" class="form-text invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <br>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="ti-xs ti ti-flag me-1"></span>Set Target Suara
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
    </div>
@endSection
