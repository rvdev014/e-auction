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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
            $table->string('additional_phone')->nullable();
            $table->foreignId('region_id')->nullable()->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->string('passport')->nullable();
            $table->date('passport_date')->nullable();
            $table->string('passport_given')->nullable();
            $table->string('pinfl')->nullable();
            $table->string('lots_member_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_date');
            $table->dropColumn('additional_phone');
            $table->dropConstrainedForeignId('region_id');
            $table->dropConstrainedForeignId('district_id');
            $table->dropColumn('passport');
            $table->dropColumn('passport_date');
            $table->dropColumn('passport_given');
            $table->dropColumn('pinfl');
            $table->dropColumn('lots_member_number');
        });
    }
};
