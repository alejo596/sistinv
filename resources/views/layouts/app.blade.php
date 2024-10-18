<!DOCTYPE html>
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

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        .dashboard-container::before {
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
        .sidebar {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            height: 100vh;
            padding-top: 2rem;
        }
        .sidebar .nav-link {
            color: #333;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }
        .main-content {
            padding: 2rem;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-gradient {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(to right, #764ba2, #667eea);
            color: white;
        }
    </style>

    <!-- Scripts -->

</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row dashboard-container my-4">
                <div class="col-md-3 col-lg-2 px-0 sidebar">
                    <h3 class="text-center mb-4">Dashboard</h3>
                    <ul class="nav flex-column">
                     <li class="nav-item">
                      <a class="nav-link {{ Request::url() === url('/home') ? 'active' : '' }}" href="{{ url('/home') }}"><i class="bi bi-house-door me-2"></i> Inicio</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ Request::url() === url('/productos') ? 'active' : '' }}" href="{{ url('/productos') }}"><i class="bi bi-bag me-2"></i> Productos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link {{ Request::url() === url('/requerimientos') ? 'active' : '' }}" href="{{ url('/requerimientos') }}" ><i class="bi bi-graph-up me-2"></i> Tareas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-gear me-2"></i> Configuración</a>
                </li>
                <li class="nav-item mt-auto">
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="col-md-9 col-lg-10 main-content">
        <div id="vue-app">
            @yield('content')
        </div>
    </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        // Gráfico de ventas de ejemplo
    document.addEventListener('DOMContentLoaded', function() {
        const salesChartElement = document.getElementById('salesChart');
        if (salesChartElement) {
            const ctx = salesChartElement.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Ventas',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: 'rgb(102, 126, 234)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@vite('resources/js/app.js')
</body>
</html>