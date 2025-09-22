@extends('adminlte::page')

@section('title', 'Editar Fiscal')

@section('content_header')
    <h1>Editar Fiscal</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('prosecutors.update', $prosecutor) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $prosecutor->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Apellido:</label>
                    <input type="text" name="last_name" id="last_name" 
                           class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $prosecutor->last_name) }}" required>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" name="dni" id="dni" 
                           class="form-control @error('dni') is-invalid @enderror" 
                           value="{{ old('dni', $prosecutor->dni) }}" required>
                    @error('dni')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="text" name="phone" id="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $prosecutor->phone) }}" required>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">Usuario Asociado:</label>
                    <select name="user_id" id="user_id" 
                            class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id', $prosecutor->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" 
                               name="is_active" value="1" 
                               {{ old('is_active', $prosecutor->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Activo</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('prosecutors.show', $prosecutor) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar select2 si lo estás usando
            $('#user_id').select2({
                placeholder: 'Seleccione un usuario',
                allowClear: true
            });

            // Inicializar los tooltips de Bootstrap
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
