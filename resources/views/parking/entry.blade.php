@extends('adminlte::page')

@section('title', 'Registrar Entrada de Vehículo')

@section('content_header')
    <h1>Registrar Entrada de Vehículo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('parking.entry.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="plate_number">Placa del Vehículo</label>
                    <input type="text" name="plate_number" id="plate_number" 
                           class="form-control @error('plate_number') is-invalid @enderror" 
                           value="{{ old('plate_number') }}" 
                           placeholder="Ej: ABC123" required autofocus>
                    @error('plate_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Fiscal a Cargo</label>
                    <div class="form-control bg-light">
                        <i class="fas fa-user-tie mr-2"></i>
                        {{ $prosecutor->name }} {{ $prosecutor->last_name }} ({{ $prosecutor->dni }})
                    </div>
                    <input type="hidden" name="prosecutor_id" value="{{ $prosecutor->id }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Entrada
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Convertir la placa a mayúsculas automáticamente
        document.getElementById('plate_number').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
@stop
