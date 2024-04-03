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
        Schema::table('transports', function (Blueprint $table) {
            $table->string('body_number')->nullable();
            $table->string('curb_weight')->nullable();
            $table->string('unladen_weight')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('engine_power')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('seats_amount')->nullable();
            $table->string('standings_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn('body_number');
            $table->dropColumn('curb_weight');
            $table->dropColumn('unladen_weight');
            $table->dropColumn('engine_number');
            $table->dropColumn('engine_power');
            $table->dropColumn('fuel_type');
            $table->dropColumn('seats_amount');
            $table->dropColumn('standings_amount');
        });
    }
};
