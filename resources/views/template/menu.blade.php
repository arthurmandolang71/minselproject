<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    @if (auth()->user()->foto_profil)
                        <img src="{{ asset('') }}assets/images/avatar/{{ auth()->user()->foto_profil }}"
                            alt="" />
                    @else
                        <img src="{{ asset('') }}assets/images/avatar/1.png" alt="" />
                    @endif

                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi,<b>{{ auth()->user()->username }}</b></span>
                        <small class="text-end font-w400">{{ auth()->user()->name }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="/profil/{{ auth()->user()->id }}" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18"
                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="/profil/{{ auth()->user()->id }}/edit" class="dropdown-item ai-icon">
                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18"
                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        </svg>
                        <span class="ms-2">Edit Password </span>
                    </a>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="dropdown-item ai-icon">
                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                                height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span class="ms-2">Logout </span>
                        </button>
                    </form>
                </div>
            </li>

            @can('isAdmin')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-people-fill"></i>
                        <span class="nav-text">Calon Pilkada</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/calon">Data Calon</a></li>
                        <li><a href='/calon/create'>Tambah Calon</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-flag-fill"></i>
                        <span class="nav-text">DPT</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/dpt">DPT 2024</a></li>
                        <li><a href='/dpt/create'>Import DPT</a></li>
                    </ul>
                </li>
            @endcan

            @can('isCaleg')
                <li>
                    <a class="bi bi-bar-chart" href="/dash">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-people-fill"></i>
                        <span class="nav-text">Collect Data</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href='/collectdata'>DPT</a></li>
                        <li><a href="/collectdata/dash?prov=71">Dashboard</a></li>
                        <li><a href='/collectdata/create'>Input DPT (tambahan)</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-flag-fill"></i>
                        <span class="nav-text">Data Collection</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/pendukung/index">Data Pendukung</a></li>
                        <li><a href='/pendukung/dash?prov=71'>Dashboard</a></li>
                        <li><a href="/pendukung/pilih_print">Print/Pdf</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-person"></i>
                        <span class="nav-text">Data Provider</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/dataprovider">Daftar Pemberi Data</a></li>
                        <li><a href='/tim'>Tim Pemenangan</a></li>
                    </ul>
                </li>
                {{--  --}}
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="bi bi-gear-fill"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/klasifikasipendukung">Klasifkasi Pendukung</a></li>
                        <li><a href="/klasifikasibantuan">Klasifkasi Bantuan</a></li>
                        <li><a href="/target/edit">Target Pendukung</a></li>
                        <li><a href="/operator">Operator</a></li>
                    </ul>
                </li>
            @endcan

            @can('isTim')
                {{-- <li>
                    <a class="bi bi-bar-chart" href="/timdash">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li> --}}
                <li>
                    <a class="bi bi-save-fill" href="/timdpt">
                        <span class="nav-text">Collect Data</span>
                    </a>
                </li>
                <li>
                    <a class="bi bi-people-fill" href="/dataprovidertim">
                        <span class="nav-text">Pemberi Data</span>
                    </a>
                </li>
            @endcan
        </ul>

    </div>
</div>
