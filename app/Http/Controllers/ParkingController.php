<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Prosecutor;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ParkingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra el listado de vehículos actualmente estacionados
     */
    public function index()
    {
        $parkedVehicles = Parking::with(['prosecutor', 'rate'])
            ->whereNull('exit_time')
            ->orderBy('entry_time', 'desc')
            ->paginate(10); // 10 items por página
            
        return view('parking.index', compact('parkedVehicles'));
    }
    /**
     * Muestra el formulario para registrar la entrada de un vehículo
     */
    public function createEntry()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener o crear el fiscal asociado al usuario
        $prosecutor = $user->prosecutor;
        
        if (!$prosecutor) {
            // Si no existe un fiscal, crear uno por defecto
            $prosecutor = Prosecutor::create([
                'name' => $user->name,
                'last_name' => $user->last_name,
                'dni' => $user->dni,
                'phone' => '000-000-0000', // Número por defecto, el usuario podrá actualizarlo después
                'user_id' => $user->id,
                'is_active' => true
            ]);
            
            // Asociar el fiscal al usuario
            $user->prosecutor()->save($prosecutor);
            
            // Recargar la relación
            $user->load('prosecutor');
            $prosecutor = $user->prosecutor;
            
            // Mostrar mensaje informativo
            session()->flash('info', 'Se ha creado un perfil de fiscal con sus datos. Por favor, verifique y actualice la información si es necesario.');
        }
        
        return view('parking.entry', compact('prosecutor'));
    }

    /**
     * Registra la entrada de un vehículo
     */
    public function storeEntry(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Registrar inicio del proceso
        Log::info('Inicio de storeEntry', ['user_id' => $user->id]);
        
        // Validar los datos del formulario
        $validated = $request->validate([
            'plate_number' => 'required|string|max:10',
            'prosecutor_id' => 'required|exists:prosecutors,id',
        ]);
        
        // Registrar datos validados
        Log::info('Datos validados', $validated);
        
        // Obtener el fiscal asociado al usuario
        $prosecutor = $user->prosecutor;
        
        // Verificar si el usuario tiene un fiscal asociado
        if (!$prosecutor) {
            Log::error('Usuario sin fiscal asociado', ['user_id' => $user->id]);
            return redirect()->back()
                ->with('error', 'No se pudo identificar al fiscal. Por favor, contacte al administrador.');
        }

        // Verificar si ya existe un registro de estacionamiento activo para esta placa
        $existingParking = Parking::where('plate_number', $validated['plate_number'])
            ->whereNull('exit_time')
            ->first();

        if ($existingParking) {
            return redirect()->back()
                ->with('error', 'Ya existe un vehículo con esta placa estacionado.');
        }

        // Obtener la tarifa activa
        $rate = Rate::where('is_active', true)->first();

        if (!$rate) {
            return redirect()->back()
                ->with('error', 'No hay una tarifa configurada. Por favor, contacte al administrador.');
        }

        // Crear el registro de estacionamiento
        $parking = Parking::create([
            'plate_number' => strtoupper($validated['plate_number']),
            'prosecutor_id' => $prosecutor->id, // Usar el ID del fiscal autenticado
            'rate_id' => $rate->id,
            'entry_time' => now(),
            'is_paid' => false,
        ]);

        return redirect()->route('parking.ticket', $parking->id)
            ->with('success', 'Entrada registrada correctamente.');
    }

    /**
     * Muestra el ticket de estacionamiento
     */
    public function showTicket($id)
    {
        $parking = Parking::with(['prosecutor', 'rate'])->findOrFail($id);
        return view('parking.ticket', compact('parking'));
    }

    /**
     * Muestra el formulario para registrar la salida de un vehículo
     */
    public function createExit()
    {
        return view('parking.exit');
    }

    /**
     * Procesa la salida de un vehículo
     */
    public function processExit(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string|exists:parkings,ticket_number',
        ]);

        $parking = Parking::with('rate')
            ->where('ticket_number', $request->ticket_number)
            ->whereNull('exit_time')
            ->first();

        if (!$parking) {
            return redirect()->back()
                ->with('error', 'Ticket no encontrado o el vehículo ya ha salido.');
        }

        // Registrar la salida y calcular el monto
        $parking->checkOut();

        return redirect()->route('parking.payment', $parking->id)
            ->with('success', 'Salida registrada correctamente.');
    }

    /**
     * Muestra el detalle del pago
     */
    public function showPayment($id)
    {
        $parking = Parking::with(['prosecutor', 'rate'])->findOrFail($id);
        
        if (is_null($parking->exit_time)) {
            return redirect()->back()
                ->with('error', 'El vehículo aún no ha registrado su salida.');
        }

        return view('parking.payment', compact('parking'));
    }

    /**
     * Registra el pago
     */
    public function processPayment($id)
    {
        $parking = Parking::findOrFail($id);
        
        if (is_null($parking->exit_time)) {
            return redirect()->back()
                ->with('error', 'No se puede registrar el pago sin registrar la salida del vehículo.');
        }

        $parking->update([
            'is_paid' => true,
            'payment_time' => now(),
        ]);

        return redirect()->route('parking.payment', $parking->id)
            ->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
