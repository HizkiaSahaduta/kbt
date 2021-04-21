@extends('layouts.app')

@section('content')
<img src="{{ asset('outside/assets/img/kbt2.png') }}" class="kbt-logo" alt="logo">
<h4 class="text-white">Sign In</h4>
<p class="text-white">Log in to your account to continue.</p>
<form class="text-left" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form">
        <div id="username-field" class="field-wrapper input">
           <label for="username" class="text-white">USERNAME</label>
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
           </svg>
           <input id="username" name="username" type="text" class="form-control" placeholder="Username" required>
        </div>
        <div id="password-field" class="field-wrapper input mb-2">
           <label for="password" class="text-white">PASSWORD</label>
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
           </svg>
           <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
           </svg>
        </div>
        <div class="d-sm-flex justify-content-between">
           <div class="field-wrapper">
              <button type="submit" class="btn btn-dark " value="">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Login</button>
           </div>
        </div>
        {{-- <div class="division">
           <span>OR</span>
        </div>
        <div class="social">
           <a href="javascript:void(0);" class="btn social-fb">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                 <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
              </svg>
              <span class="brand-name">Facebook</span>
           </a>
           <a href="javascript:void(0);" class="btn social-github">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
                 <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
              </svg>
              <span class="brand-name">Github</span>
           </a>
        </div>
        <p class="signup-link">Not registered ? <a href="auth_register_boxed.html">Create an account</a></p> --}}
     </div>
</form>
@if(\Session::has('alert'))
    <script>
        var error = "{{ Session::get('alert') }}"
        swal("Sign In Error", error, "error")
            .then((value) => {
                document.getElementById("username").focus();
        });

    </script>
@endif
@endsection

