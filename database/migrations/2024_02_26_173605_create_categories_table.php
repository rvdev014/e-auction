<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название категории');
            $table->integer('type')->comment('Тип категории (Авто и др. товары)');
            $table->foreignId('parent_id')->nullable()->comment('ID родительской категории')->constrained('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
