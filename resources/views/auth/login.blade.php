@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-10">
            <div class="login-card">
                <div class="card-body">
                    <h2 class="text-center mb-5">Inventory Management System</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@ejemplo.com">
                            <label for="floatingInput">Correo electrónico</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            <label for="floatingPassword">Contraseña</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>
                        <button class="btn btn-login w-100" type="submit">Iniciar Sesión</button>
                    </form>
                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-muted">¿Olvidaste tu contraseña?</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }
    .login-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, #ff00cc, #3333ff, #00ff99);
        transform: rotate(45deg);
        z-index: -1;
        animation: glowing 20s linear infinite;
    }
    @keyframes glowing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .card-body {
        padding: 3rem;
    }
    .form-floating {
        margin-bottom: 1rem;
    }
    .btn-login {
        background: linear-gradient(to right, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 0.75rem 0;
        font-weight: bold;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush