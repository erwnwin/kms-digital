<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('dist/assets/images/logo.svg') }}" alt="" class="logo logo-lg" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Main Menu</label>
                </li>
                <li class="pc-item">
                    <a href="{{ route('dashboard') }}"
                        class="pc-link {{ request()->routeIs('dashboard*') || request()->is('dashboard*') ? 'active' : '' }} "><span
                            class="pc-micon"><i class="ti ti-layout-grid"></i></span><span
                            class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('imunisasi.index') }}"
                        class="pc-link {{ request()->is('imunisasi') || request()->is('imunisasi/*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-mood-boy"></i></span>
                        <span class="pc-mtext">Data Imunisasi</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('obat-cacing.index') }}"
                        class="pc-link {{ request()->routeIs('obat-cacing.index*') || request()->is('obat-cacing.index*') ? 'active' : '' }} "><span
                            class="pc-micon"><i class="ti ti-activity"></i></span><span class="pc-mtext">Obat
                            Cacing</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('vitamin-a.index') }}"
                        class="pc-link {{ request()->routeIs('vitamin-a.index*') || request()->is('vitamin-a.index*') ? 'active' : '' }} "><span
                            class="pc-micon"><i class="ti ti-checkbox"></i></span><span class="pc-mtext">Vitamin
                            A</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('kms.index') }}"
                        class="pc-link {{ request()->routeIs('kms*') || request()->is('kms*') ? 'active' : '' }} "><span
                            class="pc-micon"><i class="ti ti-chart-bar"></i></span><span class="pc-mtext">KMS
                            Digital</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Administrator</label>
                </li>

            </ul>

        </div>
    </div>
</nav>
