@extends('layouts.app')

@section('content')

        <div class="col-md-9 col-lg-10 main-content">
            <h1 class="mb-4">Bienvenido al Dashboard</h1>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text display-4">1,234</p>
                            <a href="#" class="btn btn-sm btn-gradient">Ver detalles</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ingresos</h5>
                            <p class="card-text display-4">$5,678</p>
                            <a href="#" class="btn btn-sm btn-gradient">Ver detalles</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <p class="card-text display-4">42</p>
                            <a href="#" class="btn btn-sm btn-gradient">Ver detalles</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pedidos</h5>
                            <p class="card-text display-4">89</p>
                            <a href="#" class="btn btn-sm btn-gradient">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gráfico de ventas</h5>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Actividad reciente</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Nuevo usuario registrado</li>
                                <li class="list-group-item">Pedido #1234 completado</li>
                                <li class="list-group-item">Actualización de inventario</li>
                                <li class="list-group-item">Nuevo comentario en el producto A</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

