@extends('adminlte::page')

@section('title', 'Ticket de Estacionamiento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center mb-0">TICKET DE ESTACIONAMIENTO</h3>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <h4 class="mb-0">CONTROL PARKING</h4>
                        <p class="mb-1">Sistema de Control de Estacionamiento</p>
                        <p class="mb-0">N° Ticket: {{ $parking->ticket_number }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="text-left mb-3">
                        <div class="d-flex justify-content-between">
                            <span><strong>Placa:</strong></span>
                            <span>{{ $parking->formatted_plate_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Hora de Entrada:</strong></span>
                            <span>{{ $parking->entry_time->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Fiscal:</strong></span>
                            <span>{{ $parking->prosecutor->name }} {{ $parking->prosecutor->last_name }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center mb-3">
                        <p class="mb-1">Conserve este ticket</p>
                        <p class="mb-0">Para retirar su vehículo, presente este ticket</p>
                        <p class="mb-0">o proporcione el número de placa al fiscal</p>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('parking.exit.create') }}" class="btn btn-primary">
                            <i class="fas fa-sign-out-alt"></i> Registrar Salida
                        </a>
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
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
            .no-print, .no-print * {
                display: none !important;
            }
            .card-header {
                border-bottom: 2px solid #000;
            }
        }
    </style>
@stop
