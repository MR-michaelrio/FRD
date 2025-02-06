<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <!-- <img src="{{asset('img/frd-logo.jpg')}}" alt="Indonesia Emergency Responder" class="brand-image img-circle elevation-3"
            style="opacity: .8"> -->
        <span class="brand-text font-weight-light" style="font-size:14px">Indonesia Emergency Responder</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block" style="text-transform:Capitalize">{{ auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(auth()->user()->level == "admin")
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Anggota
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('anggota.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Anggota 101 & 102</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('agt.index2') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Seluruh Anggota</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Regu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('regu.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regu</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Absen
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('absen.index2') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Absen Jakarta</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('absen.index3') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Absen Bekasi</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('absen.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Absen</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lpr.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buat Laporan</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lpr.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                    </ul>
                    @if(auth()->user()->level == "admin")
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lpr.rekap') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Laporan Kejadian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Backup Laporan Lama</p>
                            </a>
                        </li>
                    </ul>
                    @endif
                </li>

                <li class="nav-item">
                    <a href="{{ route('wilayah.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-globe-asia"></i>
                        <p>
                            Wilayah
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('lembaga.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-grip-horizontal"></i>
                        <p>
                            Lembaga
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('approve.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>
                            Approval
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Logout
                    </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>