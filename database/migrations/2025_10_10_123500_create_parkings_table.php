<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number');
            $table->foreignId('prosecutor_id')->constrained()->onDelete('cascade');
            $table->foreignId('rate_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();
            $table->integer('minutes_parked')->nullable();
            $table->decimal('amount_charged', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('ticket_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
