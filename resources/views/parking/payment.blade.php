@extends('adminlte::page')

@section('title', 'Pago de Estacionamiento')

@section('content_header')
    <h1>Detalle de Pago</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Comprobante de Pago</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información del Vehículo</h5>
                            <p class="mb-1"><strong>Placa:</strong> {{ $parking->formatted_plate_number }}</p>
                            <p class="mb-1"><strong>Ticket:</strong> {{ $parking->ticket_number }}</p>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <h5>Detalles del Tiempo</h5>
                            <p class="mb-1"><strong>Entrada:</strong> {{ $parking->entry_time->format('d/m/Y H:i:s') }}</p>
                            <p class="mb-1"><strong>Salida:</strong> {{ $parking->exit_time->format('d/m/Y H:i:s') }}</p>
                            <p class="mb-0"><strong>Tiempo Estacionado:</strong> {{ $parking->minutes_parked }} minutos</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Concepto</th>
                                    <th class="text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>Tarifa de Estacionamiento</strong><br>
                                        <small class="text-muted">
                                            {{ $parking->minutes_parked < 30 ? 'Menos de 30 minutos' : '30 minutos o más' }}
                                        </small>
                                    </td>
                                    <td class="text-right align-middle">
                                        ${{ number_format($parking->amount_charged, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Total a Pagar:</strong></td>
                                    <td class="text-right"><strong>${{ number_format($parking->amount_charged, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i> 
                        @if($parking->is_paid)
                            Pago registrado el {{ $parking->payment_time->format('d/m/Y H:i:s') }}
                        @else
                            Por favor, proceda con el pago.
                        @endif
                    </div>
                    
                    <div class="text-center mt-4">
                        @if(!$parking->is_paid)
                            <form action="{{ route('parking.payment.process', $parking->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-credit-card"></i> Registrar Pago
                                </button>
                            </form>
                        @endif
                        
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-lg ml-2">
                            <i class="fas fa-print"></i> Imprimir Comprobante
                        </button>
                        
                        <a href="{{ route('parking.exit.create') }}" class="btn btn-outline-primary btn-lg ml-2">
                            <i class="fas fa-car"></i> Nueva Salida
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
            .card-header {
                border-bottom: 2px solid #000;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        }
    </style>
@stop
