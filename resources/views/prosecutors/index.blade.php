@extends('adminlte::page')

@section('title', 'Lista de Fiscales')

@section('content_header')
    <h1>Lista de Fiscales</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('prosecutors.create') }}" class="btn btn-primary">Nuevo Fiscal</a>
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
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prosecutors as $prosecutor)
                        <tr>
                            <td>{{ $prosecutor->id }}</td>
                            <td>{{ $prosecutor->name }}</td>
                            <td>{{ $prosecutor->last_name }}</td>
                            <td>{{ $prosecutor->dni }}</td>
                            <td>{{ $prosecutor->phone }}</td>
                            <td>
                                <a href="{{ route('prosecutors.show', $prosecutor) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('prosecutors.edit', $prosecutor) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('prosecutors.destroy', $prosecutor) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de desactivar este fiscal?')">Desactivar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay fiscales registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $prosecutors->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Lista de fiscales cargada'); </script>
@stop
