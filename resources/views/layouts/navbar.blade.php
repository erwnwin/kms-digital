  <div id="app">
      <div id="sidebar" class="active custom-sidebar">
          <div class="sidebar-wrapper active">
              <div class="sidebar-header text-center py-4">
                  <img src="{{ asset('assets/images/logo-posyandu.png') }}" alt="Logo Posyandu" class="logo img-fluid mb-2"
                      style="max-width: 100px;">
                  <h5 class="mb-0 fw-bold text-white" style="font-size: 1rem;">POSYANDU CEMPAKA</h5>
              </div>
              <div class="sidebar-menu">
                  <ul class="menu">
                      <li class="sidebar-title">Main Menu</li>
                      <li
                          class="sidebar-item  {{ request()->routeIs('dashboard*') || request()->is('dashboard*') ? 'active' : '' }} ">
                          <a href="{{ route('dashboard') }}" class="sidebar-link ">
                              <i data-feather="grid" width="20"></i>
                              <span>Dashboard</span>
                          </a>
                      </li>

                      @if (Auth::user()->role === 'kordinator')
                          <li
                              class="sidebar-item  {{ request()->routeIs('orang-tua*') || request()->is('orang-tua*') ? 'active' : '' }} ">
                              <a href="{{ route('orang-tua.index') }}" class="sidebar-link ">
                                  <i data-feather="users" width="20"></i>
                                  <span>Data Orang Tua</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('anak*') || request()->is('anak*') ? 'active' : '' }} ">
                              <a href="{{ route('anak.index') }}" class="sidebar-link ">
                                  <i data-feather="smile" width="20"></i>
                                  <span>Data Anak</span>
                              </a>
                          </li>
                      @endif

                      @if (Auth::user()->role === 'kader')
                          <li
                              class="sidebar-item  {{ request()->routeIs('profil*') || request()->is('profil*') ? 'active' : '' }} ">
                              <a href="{{ route('profil') }}" class="sidebar-link ">
                                  <i data-feather="user" width="20"></i>
                                  <span>Profil</span>
                              </a>
                          </li>
                          <li class="sidebar-item">
                              <a href="{{ route('logout') }}" class="sidebar-link ">
                                  <i data-feather="power" width="20"></i>
                                  <span>Logout</span>
                              </a>
                          </li>
                          <li class="sidebar-title">IMUNISASI</li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('imunisasi*') || request()->is('imunisasi*') ? 'active' : '' }} ">
                              <a href="{{ route('imunisasi.index') }}" class="sidebar-link ">
                                  <i data-feather="thermometer" width="20"></i>
                                  <span>Data Imunisasi</span>
                              </a>
                          </li>

                          <li
                              class="sidebar-item  {{ request()->routeIs('vitamin-a*') || request()->is('vitamin-a*') ? 'active' : '' }} ">
                              <a href="{{ route('vitamin-a.index') }}" class="sidebar-link ">
                                  <i data-feather="check-square" width="20"></i>
                                  <span>Vitamin A & Obat Cacing</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('kms*') || request()->is('kms*') ? 'active' : '' }} ">
                              <a href="{{ route('kms.index') }}" class="sidebar-link ">
                                  <i data-feather="bar-chart" width="20"></i>
                                  <span>KMS Digital</span>
                              </a>
                          </li>
                      @endif

                      @if (Auth::user()->role === 'kordinator')
                          <li class="sidebar-title">ADDITIONAL INFO</li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('jadwal-imunisasi*') || request()->is('jadwal-imunisasi*') ? 'active' : '' }} ">
                              <a href="{{ route('jadwal-imunisasi') }}" class="sidebar-link ">
                                  <i data-feather="calendar" width="20"></i>
                                  <span>Jadwal Imunisasi</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('faq*') || request()->is('faq*') ? 'active' : '' }} ">
                              <a href="{{ route('faq') }}" class="sidebar-link ">
                                  <i data-feather="help-circle" width="20"></i>
                                  <span>FAQ</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('laporan*') || request()->is('laporan*') ? 'active' : '' }} ">
                              <a href="{{ route('laporan') }}" class="sidebar-link ">
                                  <i data-feather="file" width="20"></i>
                                  <span>Laporan</span>
                              </a>
                          </li>
                      @endif

                      @if (Auth::user()->role === 'kordinator')
                          <li class="sidebar-title">Utility</li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('users*') || request()->is('users*') ? 'active' : '' }} ">
                              <a href="{{ route('users') }}" class="sidebar-link ">
                                  <i data-feather="users" width="20"></i>
                                  <span>Role Users</span>
                              </a>
                          </li>

                          <li
                              class="sidebar-item  {{ request()->routeIs('profil*') || request()->is('profil*') ? 'active' : '' }} ">
                              <a href="{{ route('profil') }}" class="sidebar-link ">
                                  <i data-feather="user" width="20"></i>
                                  <span>Info Akun Saya</span>
                              </a>
                          </li>
                          <li class="sidebar-item">
                              <a href="{{ route('logout') }}" class="sidebar-link ">
                                  <i data-feather="power" width="20"></i>
                                  <span>Logout</span>
                              </a>
                          </li>
                      @endif

                      @if (Auth::user()->role === 'orang_tua')
                          <li class="sidebar-item  {{ request()->routeIs('profil*') ? 'active' : '' }} ">
                              <a href="{{ route('profil') }}" class="sidebar-link ">
                                  <i data-feather="user" width="20"></i>
                                  <span>Profil</span>
                              </a>
                          </li>
                          <li class="sidebar-item">
                              <a href="{{ route('logout') }}" class="sidebar-link ">
                                  <i data-feather="power" width="20"></i>
                                  <span>Logout</span>
                              </a>
                          </li>
                          <li class="sidebar-title">Orang Tua</li>
                          <li class="sidebar-item  {{ request()->routeIs('my.profile-anak*') ? 'active' : '' }} ">
                              <a href="{{ route('my.profile-anak') }}" class="sidebar-link ">
                                  <i data-feather="smile" width="20"></i>
                                  <span>Profil Anak</span>
                              </a>
                          </li>
                          {{-- <li
                              class="sidebar-item  {{ request()->routeIs('profil*') || request()->is('profil*') ? 'active' : '' }} ">
                              <a href="{{ route('profil') }}" class="sidebar-link ">
                                  <i data-feather="thermometer" width="20"></i>
                                  <span>Riwayat Imunisasi</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('riwayat.vitamin-a*') || request()->is('riwayat.vitamin-a*') ? 'active' : '' }} ">
                              <a href="{{ route('riwayat.vitamin-a') }}" class="sidebar-link ">
                                  <i data-feather="check-square" width="20"></i>
                                  <span>Riwayat Vitamin A</span>
                              </a>
                          </li>
                          <li
                              class="sidebar-item  {{ request()->routeIs('profil*') || request()->is('profil*') ? 'active' : '' }} ">
                              <a href="{{ route('profil') }}" class="sidebar-link ">
                                  <i data-feather="bar-chart" width="20"></i>
                                  <span>Riwayat KMS</span>
                              </a>
                          </li> --}}
                      @endif

                  </ul>
              </div>
              <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
          </div>
      </div>
