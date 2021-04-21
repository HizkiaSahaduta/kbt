@extends('layouts.app')

@section('content')
<h4 class="text-white">Change Password</h4>
<p class="text-white">Make sure password not same as your username.</p>
<form class="text-left" method="post" action="{{ url('ChangeDefPass') }}">
    @csrf
    <div class="form">
        <div id="password-field" class="field-wrapper input mb-2">
           <label for="password" class="text-white">PASSWORD</label>
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
           </svg>
           <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
           </svg>
        </div>
        <div class="d-sm-flex justify-content-between">
           <div class="field-wrapper">
              <button type="submit" class="btn btn-dark " value="">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Confirm Password
              </button>
           </div>
        </div>
     </div>
</form>

@if(\Session::has('alert'))
    <script>
        var error = "{{ Session::get('alert') }}"
        swal("Info", error, "warning")
            .then((value) => {
                document.getElementById("password").focus();
        });

    </script>
@endif

@endsection
