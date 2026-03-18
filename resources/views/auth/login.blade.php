@extends('layouts.app')

@section('content')


<style>
    .navbar {
    background: rgb(255, 255, 255) !important;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}
.container {
    margin-top: 100px;
}

.card {
    background-color: #3c4248 !important; 
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    color: white;
    margin-right:80px;
    width: 800px ;
}

.card-header {
    background-color: transparent !important;
    border-bottom: none !important;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
}

.card-body {
    padding: 30px;
}

.form-control {
    background: #495057 !important;
    border: none;
    color: white !important;
    border-radius: 5px;
}

.form-control:focus {
    background: #5a6268 !important;
    color: white !important;
    box-shadow: none !important;
    border: 1px solid #f8f9fa;
}

.btn-primary {
    background-color: rgb(196, 46, 116); !important;
    border: none !important;
    padding: 10px 20px;
    font-weight: bold;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background-color:rgb(150, 54, 118) !important;
}

.btn-link {
    color: #f8f9fa !important;
    text-decoration: none;
}

.btn-link:hover {
    color: #f1c40f !important;
}


    </style>
<div class="container pt-10">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
