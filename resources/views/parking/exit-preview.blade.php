@extends('adminlte::page')

@section('title', 'Confirmar Salida de Vehículo')

@section('content_header')
    <h1>Confirmar Salida de Vehículo</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen del Estacionamiento</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información del Vehículo</h5>
                            <p><strong>Placa:</strong> {{ $parking->plate_number }}<br>
                            <strong>Ticket:</strong> {{ $parking->ticket_number }}<br>
                            <strong>Hora de Entrada:</strong> {{ $parking->entry_time->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Tiempo Estacionado</h5>
                            @php
                                $now = now();
                                $duration = $now->diffInMinutes($parking->entry_time);
                                $hours = floor($duration / 60);
                                $minutes = $duration % 60;
                            @endphp
                            <p class="h3">
                                {{ $hours }}h {{ $minutes }}m
                            </p>
                            <p class="text-muted">
                                {{ $parking->entry_time->diffForHumans($now, true) }}
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5>Seleccionar Tarifa</h5>
                        <form action="{{ route('parking.exit.process', ['id' => $parking->id]) }}" method="POST" id="exitForm">
                            @csrf
                            <div class="row">
                                @foreach($rates as $rate)
                                    <div class="col-md-6 mb-3">
                                        <div class="card rate-card {{ $loop->first ? 'border-primary' : '' }}" style="cursor: pointer;" onclick="selectRate({{ $rate->id }})">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="rate_id" 
                                                           id="rate_{{ $rate->id }}" 
                                                           value="{{ $rate->id }}" 
                                                           {{ $loop->first ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="rate_{{ $rate->id }}">
                                                        <h5 class="card-title">{{ $rate->name }}</h5>
                                                        <p class="card-text">
                                                            <strong>Primeros 30 min:</strong> {{ number_format($rate->amount, 2) }}<br>
                                                            <strong>Por minuto adicional:</strong> {{ number_format($rate->amount_exceeded, 2) }}
                                                        </p>
                                                        @if($rate->description)
                                                            <small class="text-muted">{{ $rate->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check-circle"></i> Confirmar Salida
                                </button>
                                <a href="{{ route('parking.exit.create') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .rate-card {
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
        }
        .rate-card:hover {
            border-color: #6c757d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-check-input:checked + .form-check-label .card {
            border-color: #007bff !important;
            background-color: #f8f9fa;
        }
        .form-check {
            margin-bottom: 0;
        }
        .form-check-input {
            position: absolute;
            opacity: 0;
        }
        .form-check-input:checked + .form-check-label .rate-card {
            border-color: #007bff !important;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('js')
    <script>
        function selectRate(rateId) {
            // Marcar el radio button correspondiente
            document.getElementById('rate_' + rateId).checked = true;
            
            // Actualizar estilos
            document.querySelectorAll('.rate-card').forEach(card => {
                card.classList.remove('border-primary');
            });
            document.querySelector(`#rate_${rateId}`).closest('.rate-card').classList.add('border-primary');
        }

        // Inicializar el primer elemento como seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const firstRate = document.querySelector('input[name="rate_id"]:checked');
            if (firstRate) {
                firstRate.closest('.rate-card').classList.add('border-primary');
            }
        });
    </script>
@endpush
