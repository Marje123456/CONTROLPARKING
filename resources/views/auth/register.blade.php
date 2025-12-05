@extends('adminlte::page')

@section('title', 'Registrar Nuevo Usuario')

@section('content_header')
    <h1>Registrar Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('register') }}" method="post">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        {{-- Nombre --}}
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Ingrese el nombre" required autofocus>
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- Apellido --}}
                        <div class="form-group">
                            <label for="last_name">Apellido</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="last_name" id="last_name" 
                                       class="form-control @error('last_name') is-invalid @enderror" 
                                       value="{{ old('last_name') }}" 
                                       placeholder="Ingrese el apellido" required>
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {{-- DNI --}}
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" name="dni" id="dni" 
                                       class="form-control @error('dni') is-invalid @enderror" 
                                       value="{{ old('dni') }}" 
                                       placeholder="Ingrese el DNI" required>
                            </div>
                            @error('dni')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="Ingrese el correo electrónico" required>
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {{-- Contraseña --}}
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Ingrese la contraseña" required>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- Confirmar Contraseña --}}
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Confirme la contraseña" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Registrar Usuario
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Inicio de Sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            border: none;
        }
        
        .card-header {
            background-color: #4e73df;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.25rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 5px;
            border: 1px solid #d1d3e2;
            padding: 0.5rem 0.75rem;
            height: calc(2.25rem + 2px);
        }
        
        .input-group-text {
            background-color: #f8f9fc;
            border: 1px solid #d1d3e2;
            border-right: none;
            border-radius: 5px 0 0 5px;
        }
        
        .btn {
            border-radius: 5px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        
        .btn i {
            margin-right: 0.5rem;
        }
    </style>
@stop