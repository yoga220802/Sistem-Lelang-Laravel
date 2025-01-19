@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #232526, #414345);">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 d-flex flex-wrap shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <!-- Form Section -->
            <div class="col-md-12 bg-dark text-white p-4">
                <h1 class="mb-4 text-center">{{ __('Create an Account!') }}</h1>
                <p class="text-center">{{ __('Register to get started') }}</p>
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                  name="address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="profile_image" class="form-label">{{ __('Profile Image') }}</label>
                        <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                               name="profile_image">
                        @error('profile_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">{{ __('Register') }}</button>
                </form>

                <div class="text-center mt-4">
                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Already have an account? Login!') }}
                    </a>
                </div>
            </div>

            <!-- Info Section -->
            <div class="col-md-12 p-4" style="background: linear-gradient(135deg, #414345, #232526); color: #ccc;">
                <h1 class="text-white">{{ __('Welcome to Our Platform') }}</h1>
                <p>{{ __('Register to access your account and manage your tasks efficiently.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection