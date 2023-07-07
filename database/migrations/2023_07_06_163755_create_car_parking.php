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
        Schema::create('car_parking', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->unique('code');
            $table->string('car_number_plate');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->float('price')->nullable();
            $table->enum('status_parking', ['parking', 'parking_out', 'fine']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_parking');
    }
};
