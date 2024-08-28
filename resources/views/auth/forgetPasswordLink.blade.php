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

              @if (Session::has('error'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

          
            
            <form
              class="form-horizontal mt-3"
              action="{{ route('reset.password.post') }}"
              method="POST"
            >
            @csrf
             <input type="hidden" name="token" value="{{ $token }}">
              <div class="row pb-4">
                <div class="col-12">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-danger text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-email fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="email"
                      class="form-control form-control-lg"
                      placeholder="Email Address"
                      aria-describedby="basic-addon1"
                      id="email_address"
                      name="email"
                      required 
                      autofocus
                    />
                     @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                  </div>

                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-danger text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-lock fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="password"
                      class="form-control form-control-lg"
                      placeholder="Password"
                      aria-describedby="basic-addon1"
                      id="password"
                      name="password"
                      required 
                      autofocus

                    />
                  </div>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text bg-danger text-white h-100"
                        id="basic-addon1"
                        ><i class="mdi mdi-lock fs-4"></i
                      ></span>
                    </div>
                    <input
                      type="password"
                      class="form-control form-control-lg"
                      placeholder="Confirm Password"
                      aria-describedby="basic-addon1"
                      id="password-confirm"
                      name="password_confirmation"
                      required 
                      autofocus

                    />
                  </div>
                </div>
              </div>
              <div class="row border-top border-secondary">
                <div class="col-12">
                  <div class="form-group form-control-lg">
                    <div class="pt-3">
                      <button
                        class="btn btn-success text-white"
                        type="submits"
                      >
                       <a href=""></a> Reset Password
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
