@extends('auth.app')
@section('title', 'Login')

@section('content')

    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="40" class="me-2">
                <span class="app-brand-text demo text-body fw-bolder">Worksafe</span>
            
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Welcome to Worksafe! 👋</h4>
            <p class="mb-4">Please sign-in to your account</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  autofocus
                />
                @error('email')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="auth-forgot-password-basic.html">
                    <small>Forgot Password?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
               @enderror
              </div>
             
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-success-dark d-grid w-100" type="submit">Sign in</button>
              </div>
                
            </form>

            <p class="text-center">
              <span>New on our platform?</span>
             <a href="{{ route('registerForm') }}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>

@endsection
