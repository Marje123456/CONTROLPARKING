<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'prosecutor_id',
        'rate_id',
        'entry_time',
        'exit_time',
        'minutes_parked',
        'amount_charged',
        'is_paid',
        'ticket_number'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'is_paid' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($parking) {
            $parking->ticket_number = 'TKT-' . strtoupper(Str::random(8));
            // Asegurarse de que entry_time sea una instancia de Carbon
            if (is_string($parking->entry_time)) {
                $parking->entry_time = Carbon::parse($parking->entry_time);
            }
        });
        
        static::updating(function ($parking) {
            // Asegurarse de que exit_time sea una instancia de Carbon al actualizar
            if ($parking->isDirty('exit_time') && is_string($parking->exit_time)) {
                $parking->exit_time = Carbon::parse($parking->exit_time);
            }
        });
    }

    /**
     * Relación con el fiscal que registró el estacionamiento
     */
    public function prosecutor()
    {
        return $this->belongsTo(Prosecutor::class);
    }

    /**
     * Relación con la tarifa aplicada
     */
    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    /**
     * Calcular el tiempo estacionado en minutos
     */
    public function calculateParkingTime()
    {
        if (!$this->exit_time) {
            return null;
        }
        
        $entry = Carbon::parse($this->entry_time);
        $exit = Carbon::parse($this->exit_time);
        
        return $exit->diffInMinutes($entry);
    }

    /**
     * Calcular el monto a pagar según el tiempo estacionado
     */
    public function calculateAmount()
    {
        $minutes = $this->calculateParkingTime();
        
        if ($minutes === null) {
            return null;
        }
        
        // Obtener la tarifa asignada al registro
        $rate = $this->rate;
        
        if (!$rate) {
            // Si no hay tarifa asignada, intentar obtener la tarifa activa
            $rate = Rate::where('is_active', true)->first();
            
            if (!$rate) {
                return null;
            }
            
            // Asignar la tarifa activa al registro
            $this->rate_id = $rate->id;
        }
        
        // Si el tiempo es menor a 30 minutos, usar amount, de lo contrario amount_exceeded
        $amount = $minutes < 30 ? $rate->amount : $rate->amount_exceeded;
        
        // Guardar los datos calculados
        $this->minutes_parked = $minutes;
        $this->amount_charged = $amount;
        
        $this->save();
        
        return $amount;
    }

    /**
     * Registrar la salida del vehículo
     */
    public function checkOut()
    {
        $this->exit_time = now();
        $this->save();
        
        return $this->calculateAmount();
    }

    /**
     * Obtener el estado del pago
     */
    public function getPaymentStatusAttribute()
    {
        return $this->is_paid ? 'Pagado' : 'Pendiente';
    }

    /**
     * Obtener la placa formateada
     */
    public function getFormattedPlateNumberAttribute()
    {
        return strtoupper($this->plate_number);
    }
}
