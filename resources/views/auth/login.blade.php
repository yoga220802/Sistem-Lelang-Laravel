@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #232526, #414345);">
    <div class="row justify-content-center w-100">
        <div class="col-md-10 d-flex flex-wrap shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <!-- Form Section -->
            <div class="col-md-6 bg-dark text-white p-4">
                <h1 class="mb-4 text-center">{{ __('Welcome Back!') }}</h1>
                <p class="text-center">{{ __('Login to your account') }}</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">{{ __('Login') }}</button>
                </form>

                <div class="text-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                <div class="text-center mt-4">
                    <a class="btn btn-link" href="{{ route('register') }}">
                        {{ __('Create an Account!') }}
                    </a>
                </div>
            </div>

            <!-- Info Section -->
            <div class="col-md-6 p-4" style="background: linear-gradient(135deg, #414345, #232526); color: #ccc;">
                <h1 class="text-white">{{ __('Welcome to Our Platform') }}</h1>
                <p>{{ __('Login to access your account and manage your tasks efficiently.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection