@extends('layouts.login')

@section('content')
    <div class="login">
      <div
        class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center
          bg-dark
        "
        >
        <div class="auth-box bg-dark border-secondary">
          <div id="loginform">
            <div class="text-center pt-3 pb-2">
              <span class="db"
                ><img src="{{ asset('assets/images/softhr.png') }}"></span>
            </div>
            <form
              class="form-horizontal mt-3"
              id="login"
              action="{{ route('login') }}"
              method="POST"
            >
            @csrf
              <div class="row pb-4">
                <div class="col-12">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-success text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-account fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="email"
                      class="form-control form-control-lg @error('email') is-invalid @enderror"
                      placeholder="Username"
                      aria-label="Username"
                      aria-describedby="basic-addon1"
                      required=""
                      id="email"
                      name="email"
                      value="{{ old('email') }}"
                    />
                  <!--   @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror -->
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-warning text-white h-100"
                        id="basic-addon2"
                        ><i class="mdi mdi-lock fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="password"
                      class="form-control form-control-lg @error('password') is-invalid @enderror"
                      placeholder="Password"
                      aria-label="Password"
                      aria-describedby="basic-addon1"
                      required=""
                      name="password"
                      id="password"
                    />
                       @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                  </div>
                </div>
              </div>
              <div class="row border-top border-secondary">
                <div class="col-12">
                  <div class="form-group">
                    <div class="pt-3">
                      <a
                        class="btn btn-info password-btn"
                        id="remember"
                        type="submits"
                        href="{{ route('forget.password.get') }}"
                      > 
                        <i class="mdi mdi-lock fs-4 me-1"></i> Lost password?
                      </a>
                      <button
                        class="btn btn-success float-end text-white login-btn"
                        type="submit"
                      >
                        Login
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
