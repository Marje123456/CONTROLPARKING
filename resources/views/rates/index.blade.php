@extends('adminlte::page')

@section('title', 'Lista de Tarifas')

@section('content_header')
    <h1>Lista de Tarifas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('rates.create') }}" class="btn btn-primary">Nueva Tarifa</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Monto Excedente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rates as $rate)
                        <tr>
                            <td>{{ $rate->id }}</td>
                            <td>{{ $rate->name }}</td>
                            <td>{{ number_format($rate->amount, 2) }}</td>
                            <td>{{ number_format($rate->amount_exceeded, 2) }}</td>
                            <td>
                                <span class="badge {{ $rate->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $rate->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('rates.show', $rate) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('rates.edit', $rate) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('rates.destroy', $rate) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de desactivar esta tarifa?')"
                                            title="Desactivar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay tarifas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $rates->links() }}
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
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
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
