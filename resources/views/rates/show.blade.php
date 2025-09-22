@extends('adminlte::page')

@section('title', 'Detalles de la Tarifa')

@section('content_header')
    <h1>Detalles de la Tarifa</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información de la Tarifa</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $rate->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $rate->name }}</td>
                        </tr>
                        <tr>
                            <th>Monto Base:</th>
                            <td>${{ number_format($rate->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Monto por Hora Excedente:</th>
                            <td>${{ number_format($rate->amount_exceeded, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Descripción:</th>
                            <td>{{ $rate->description }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge {{ $rate->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $rate->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Creación:</th>
                            <td>{{ $rate->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ $rate->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Resumen de la Tarifa</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Cálculo de la Tarifa</h6>
                                <p class="mb-1"><strong>Monto Base:</strong> ${{ number_format($rate->amount, 2) }}</p>
                                <p class="mb-1"><strong>Por Hora Adicional:</strong> ${{ number_format($rate->amount_exceeded, 2) }}</p>
                                <hr>
                                <p class="mb-0">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> 
                                        Esta tarifa se aplica por tiempo estacionado.
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('rates.edit', $rate) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('rates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
        }
        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .table th {
            width: 40%;
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar tooltips
            $('[title]').tooltip();
        });
    </script>
@stop
