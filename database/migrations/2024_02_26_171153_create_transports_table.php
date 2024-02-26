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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner')->nullable();
            $table->string('car_number')->nullable();
            $table->string('year_of_issue')->nullable();
            $table->string('color')->nullable();
            $table->string('technical_condition')->nullable();
            $table->string('contract')->nullable();
            $table->string('address')->nullable();
            $table->text('additional_info')->nullable();
            $table->text('additional_info2')->nullable();
            $table->text('additional_info3')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
