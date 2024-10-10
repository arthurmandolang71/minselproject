@extends('template.main')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/welcome">Profil</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Ganti Password</a></li>
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
                                    <img src="{{ asset('') }}assets/images/profile/{{ $profil->foto }}"
                                        class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="profile-details">
                                    <div class="profile-name px-3 pt-2">
                                        <h4 class="text-primary mb-0">{{ $profil->name }}</h4>
                                        <p>{{ $profil->username }}</p>
                                    </div>
                                </div>
                            </div>
                            <form action="/profil/{{ $profil->id }}" method="post">
                                @csrf
                                @method('PUT')
                                <small class="card-text text-uppercase">Ganti Password Baru</small>
                                <div class="form-floating">
                                    <input type="text" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="floatingInput"
                                        placeholder="Masukan password baru" aria-describedby="floatingInputHelp"
                                        value="{{ old('password') }}" required />
                                    <label for="floatingInput">Password</label>
                                    <div id="floatingInputHelp" class="form-text">
                                        Masukan password minimal 6 karakter
                                    </div>
                                    @error('password')
                                        <div id="floatingInputHelp" class="form-text invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <br>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="ti-xs ti ti-key me-1"></span>Ganti Password
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
