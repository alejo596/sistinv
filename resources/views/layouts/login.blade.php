<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
 
        <main class="py-4">
            @yield('content')
        </main>
    </div>
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
</body>
</html>
