@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #00AA13,rgb(67, 182, 115));
        font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        padding: 2rem;
        width: 100%;
        max-width: 450px;
    }

    .login-card .form-control {
        border-radius: 0.75rem;
    }

    .login-header {
        font-size: 1.75rem;
        font-weight: bold;
        text-align: center;
        color: #4a4a4a;
        margin-bottom: 1.5rem;
    }

    .login-icon {
        font-size: 3rem;
        color: #667eea;
        text-align: center;
        margin-bottom: 1rem;
    }

    .btn-login {
        width: 100%;
        border-radius: 0.75rem;
    }

    .forgot-link {
        display: block;
        text-align: right;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-icon">
            <i class="bi bi-person-circle"></i>
        </div>
        <div class="login-header">{{ __('Login') }}</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus>

                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required>

                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 remember-me">
                <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-login">
                    {{ __('Login') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <a class="forgot-link text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
</div>
@endsection
