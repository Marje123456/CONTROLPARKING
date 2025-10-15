@extends('adminlte::page')

@section('title', 'Historial de Tickets')

@section('content_header')
    <h1>Historial de Tickets</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('parking.index') }}">Tickets Activos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Historial</a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <form action="{{ route('parking.history') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id">Usuario</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Todos los usuarios</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Todos los estados</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pagado</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rango de búsqueda</label>
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">a</span>
                                </div>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-group w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Placa Vehicular</th>
                            <th>Estado</th>
                            <th>Monto Cancelado</th>
                            <th>Hora de Entrada</th>
                            <th>Hora de Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->prosecutor->user->name ?? 'N/A' }}</td>
                                <td>{{ $ticket->plate_number }}</td>
                                <td>
                                    @if($ticket->is_paid)
                                        <span class="badge bg-success">Pagado</span>
                                    @else
                                        <span class="badge bg-warning">En Espera</span>
                                    @endif
                                </td>
                                <td>{{ number_format($ticket->amount_charged, 2) }} Bs.</td>
                                <td>{{ $ticket->entry_time->format('d/m/Y h:i A') }}</td>
                                <td>{{ $ticket->exit_time ? $ticket->exit_time->format('d/m/Y h:i A') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No se encontraron registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($tickets->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            white-space: nowrap;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
        .badge {
            font-size: 0.9em;
            padding: 0.4em 0.6em;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
@stop
