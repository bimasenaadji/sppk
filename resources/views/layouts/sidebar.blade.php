<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="40" class="me-2">
        <span class="app-brand-text demo menu-text fw-bolder ms-2">Worksafe</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ route('report.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">All Reports</div>
            </a>
          </li>

        <li class="menu-item {{ Request::is('user') || Request::is('admin') ? 'open active' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-folder"></i>
            <div data-i18n="Layouts">Data Master</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ Request::is('user') ? 'active' : '' }}">
              <a href="{{ route('user.index') }}" class="menu-link">
                <div data-i18n="User">Pegawai</div>
              </a>
            </li>

          </ul>
        </li>
        <li class="menu-item {{ Request::is('inspect') || Request::is('order') || Request::is('tax-category') || Request::is('transaction-status') ? 'open active' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-clipboard"></i>
            <div data-i18n="Layouts">Inspeksi Laporan</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ Request::is('inspect') ? 'active' : '' }}">
              <a href="{{ route('inspect.index') }}" class="menu-link">
                <div data-i18n="Data Transaksi">Laporan Inspeksi</div>
              </a>
            </li>
          </ul>
        </li>
        <li class="menu-item {{ Request::is('grafik') ? 'active' : '' }}">
  <a href="{{ route('report.chart') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-line-chart"></i>
    <div data-i18n="Grafik">Grafik</div>
  </a>
</li>

      </ul>
</aside>
