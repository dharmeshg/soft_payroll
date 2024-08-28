@extends('layouts.app')

@section('content')

<style>


</style>

<div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Change Password</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                <!--   <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol> -->
                </nav>
              </div>
            </div>
          </div>
        </div>
     
        <div class="container-fluid">
          <div class="card">
            <div class="card-body wizard-content">
              <!--<h4 class="card-title">Change Password</h4>-->
              <form id="example-form" action="{{ route('changePasswordPost')}}" method="POST" class="mt-3">
                {{ csrf_field() }}

                 <!--<div class="steps clearfix">
                       <a href="{{ route('index')}}">Account</a>
                       <a href="{{ route('changepasswordget')}}">Change Password</a>
                  </div>-->
                <div role="application" class="wizard clearfix" id="steps-uid-0">
                  <div class="content clearfix">
              
                  <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body current">
                   <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="name">Old Password*</label>
                    <input
                      id="password"
                      name="password"
                      type="password"
                      class="required form-control"
                      required
                    />
                     @if ($errors->has('password'))
                        <span class="help-block">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                     @endif
                    </div>
                    <div class="form-group {{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <label for="new-password">New Password *</label>
                    <input
                      id="new-password"
                      name="new-password"
                      type="password"
                      class="required form-control"
                      required
                    />
                     @if ($errors->has('new-password'))
                       <span class="help-block">
                           <strong>{{ $errors->first('new-password') }}</strong>
                       </span>
                     @endif
                    </div>
                    <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input
                      id="password_confirmation"
                      name="password_confirmation"
                      type="password"
                      class="required form-control"
                    />
                    </div>
                  </section>
                  </div>
                  <div class="row">
                    <div class="col-12 change-btn">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                  
                </div>
              </form>
            </div>
          </div>
        
        </div>
      </div>
      @endsection
        