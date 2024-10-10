@extends('template.main')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/kta">Profil</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">My Profil</a></li>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
    </div>
@endSection
