@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #00AA13,rgb(67, 182, 115));
        min-height: 100vh;
    }

    .register-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        max-width: 600px;
        margin: 50px auto;
        animation: fadeIn 0.5s ease-in-out;
    }

    .register-card h2 {
        text-align: center;
        color:rgb(0, 0, 0);
        margin-bottom: 30px;
        font-weight: bold;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-primary {
        background-color:rgb(16, 98, 192);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color:rgb(13, 196, 202);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="register-card">
    <h2>🚀 Daftar Akun Baru</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" required autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="form-label">Konfirmasi Kata Sandi</label>
            <input id="password-confirm" type="password"
                class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                📥 Daftar Sekarang
            </button>
        </div>
    </form>
</div>
@endsection
