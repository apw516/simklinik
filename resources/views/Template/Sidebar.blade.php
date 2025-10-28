<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
            <img src="./public/img/NP_MEDIKA_LOGO2.png" alt="AdminLTE Logo" class="brand-image shadow" />
            <span class="brand-text fw-bold">NP MEDIKA</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item ">
                    <a href="#" class="nav-link @if($menu == 'dashboard') active @endif">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard Rawat Jalan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard Rawat Inap</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">REKAMEDIS</li>
                <li class="nav-item">
                    <a href="{{ route('indexpendaftaran')}}" class="nav-link @if($menu == 'pendaftaran') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Pendaftaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatakunjunganrekamedis')}}" class="nav-link @if($menu == 'datakunjunganrekamedis') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Kunjungan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatauser')}}" class="nav-link @if($menu == 'masterpasien') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Master Pasien</p>
                    </a>
                </li>
                <li class="nav-header">DOKTER</li>
                <li class="nav-item">
                    <a href="{{ route('indexdatakunjungandokter')}}" class="nav-link @if($menu == 'datakunjungan') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Kunjungan</p>
                    </a>
                </li>
                <li class="nav-header">KASIR</li>
                  <li class="nav-item">
                    <a href="{{ route('indexdatakunjungankasir')}}" class="nav-link @if($menu == 'datakunjungankasir') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Kunjungan</p>
                    </a>
                </li>
                <li class="nav-header">DATA MASTER</li>
                <li class="nav-item">
                    <a href="{{ route('indexdatauser')}}" class="nav-link @if($menu == 'datauser') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatatarif')}}" class="nav-link @if($menu == 'datatarif') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Tarif</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataunit')}}" class="nav-link @if($menu == 'dataunit') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Unit</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatapegawai')}}" class="nav-link @if($menu == 'datapegawai') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Pegawai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatalokasi')}}" class="nav-link @if($menu == 'datalokasi') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Lokasi</p>
                    </a>
                </li>
                <li class="nav-header">INFO AKUN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-vcard"></i>
                        <p class="text">Detail Akun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="logout()">
                        <i class="nav-icon bi bi-box-arrow-left"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
