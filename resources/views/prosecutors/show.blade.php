@extends('adminlte::page')

@section('title', 'Detalles del Fiscal')

@section('content_header')
    <h1>Detalles del Fiscal</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información Personal</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $prosecutor->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $prosecutor->name }}</td>
                        </tr>
                        <tr>
                            <th>Apellido:</th>
                            <td>{{ $prosecutor->last_name }}</td>
                        </tr>
                        <tr>
                            <th>DNI:</th>
                            <td>{{ $prosecutor->dni }}</td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td>{{ $prosecutor->phone }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge {{ $prosecutor->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $prosecutor->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Usuario Asociado:</th>
                            <td>
                                {{ $prosecutor->user->name }} ({{ $prosecutor->user->email }})
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Creación:</th>
                            <td>{{ $prosecutor->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ $prosecutor->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('prosecutors.edit', $prosecutor) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('prosecutors.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 1em;
            padding: 0.5em 0.8em;
        }
    </style>
@stop
