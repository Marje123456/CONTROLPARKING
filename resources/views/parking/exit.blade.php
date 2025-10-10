@extends('adminlte::page')

@section('title', 'Registrar Salida de Vehículo')

@section('content_header')
    <h1>Registrar Salida de Vehículo</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('parking.exit.preview') }}" method="POST" id="exitForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="ticket_number">Número de Ticket</label>
                            <div class="input-group">
                                <input type="text" name="ticket_number" id="ticket_number" 
                                       class="form-control form-control-lg text-uppercase text-center @error('ticket_number') is-invalid @enderror" 
                                       value="{{ old('ticket_number') }}" 
                                       placeholder="Ingrese el número de ticket" 
                                       required autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="scanQR">
                                        <i class="fas fa-qrcode"></i> Escanear QR
                                    </button>
                                </div>
                            </div>
                            @error('ticket_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                Ingrese el número de ticket o escanee el código QR del comprobante.
                            </small>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-out-alt"></i> Registrar Salida
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
@stop

@section('js')
    <script>
        // Convertir el número de ticket a mayúsculas automáticamente
        document.getElementById('ticket_number').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
        
        // Simulación de escaneo de QR (puedes implementar la lógica real de escaneo aquí)
        document.getElementById('scanQR').addEventListener('click', function() {
            alert('Función de escaneo de QR. En una implementación real, esto activaría la cámara para escanear el código QR.');
            // Ejemplo de cómo se podría llenar el campo con un valor de prueba
            // document.getElementById('ticket_number').value = 'TKT-ABC123';
        });
        
        // Enfocar automáticamente el campo de entrada al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('ticket_number').focus();
        });
    </script>
@stop
