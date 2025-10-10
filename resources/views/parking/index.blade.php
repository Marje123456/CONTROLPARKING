@extends('adminlte::page')

@section('title', 'Vehículos Estacionados')

@section('content_header')
    <h1>Vehículos Estacionados</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de vehículos actualmente estacionados</h3>
            <div class="card-tools">
                <a href="{{ route('parking.entry.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Registrar Entrada
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Placa</th>
                        <th>Hora de Entrada</th>
                        <th>Tiempo Estacionado</th>
                        <th>Fiscal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parkedVehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->ticket_number }}</td>
                            <td>{{ $vehicle->formatted_plate_number }}</td>
                            <td>{{ $vehicle->entry_time->format('d/m/Y H:i:s') }}</td>
                            <td>
                                {{ $vehicle->entry_time->diffForHumans(now(), true) }}
                                <small class="text-muted">({{ $vehicle->entry_time->diffInMinutes(now()) }} minutos)</small>
                            </td>
                            <td>{{ $vehicle->prosecutor->name }} {{ $vehicle->prosecutor->last_name }}</td>
                            <td>
                                <a href="{{ route('parking.ticket', $vehicle->id) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-print"></i> Ticket
                                </a>
                                <a href="{{ route('parking.exit.create') }}?ticket_number={{ $vehicle->ticket_number }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-sign-out-alt"></i> Registrar Salida
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay vehículos estacionados actualmente</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($parkedVehicles->hasPages())
            <div class="card-footer clearfix">
                {{ $parkedVehicles->links() }}
            </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .table td {
            vertical-align: middle;
        }
        .btn-sm {
            margin-right: 5px;
        }
    </style>
@stop
