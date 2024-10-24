<nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  {{ auth()->user()->name }}
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('assets/img/avatars/6.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset('assets/img/avatars/6.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                            <small class="text-muted">Disty Invoice</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item link-change-pass"
                            href="javascript: void(0);" data-bs-toggle="modal"
                            data-bs-target="#modalChangePass">
                            <i class="bx bx-key"></i> Ubah Password
                        </a>
                    </li>
                    <li>
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit"><i class="bx bx-power-off"></i>Logout</button>

                      </form>
                     
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

<!-- Modal -->
<div class="modal fade" id="modalChangePass" tabindex="-1" aria-labelledby="modalChangePassLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalChangePassLabel">Ubah Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('change_pass') }}" method="POST" id="formChangePass">
          @csrf
          <!-- Error Alert -->
          <div class="alert alert-danger d-none alert-message" role="alert">
            <!-- Error message will go here -->
          </div>

          <!-- Old Password -->
          <div class="mb-3">
            <label for="old_password" class="form-label">Password Lama</label>
            <div class="input-group">
              <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Masukkan password lama" autocomplete="off">
              <button class="btn btn-outline-secondary" type="button" id="btn-old-password"><i class="fas fa-regular fa-eye"></i></button>
            </div>
            <div class="invalid-feedback">
              <!-- Error message for old password -->
            </div>
          </div>

          <!-- New Password -->
          <div class="mb-3">
            <label for="new_password" class="form-label">Password Baru</label>
            <div class="input-group">
              <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru" autocomplete="off">
              <button class="btn btn-outline-secondary" type="button" id="btn-new-password"><i class="fas fa-regular fa-eye"></i></button>
            </div>
            <div class="invalid-feedback">
              <!-- Error message for new password -->
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru" autocomplete="off">
              <button class="btn btn-outline-secondary" type="button" id="btn-confirm-password"><i class="fas fa-regular fa-eye"></i></button>
            </div>
            <div class="invalid-feedback">
              <!-- Error message for confirm password -->
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- END MODAL CHANGE PASS --}}