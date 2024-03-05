<?php

use App\Enums\LotStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lots', function(Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Название лота');
            $table->integer('type')->comment('Тип лота (На повышение, На понижение, Свободная продажа)');
            $table->unsignedBigInteger('lotable_id')->comment('ID товара');
            $table->string('lotable_type')->comment('Тип товара');
            $table->dateTime('apply_deadline')->comment('Дата окончания приема заявок');
            $table->dateTime('starts_at')->comment('Дата начала аукциона');
            $table->dateTime('ends_at')->nullable()->comment('Дата окончания аукциона');
            $table->bigInteger('starting_price')->comment('Начальная цена');
            $table->integer('deposit_amount')->comment('Сумма депозита');
            $table->integer('step_amount')->comment('Шаг ставки');
            //            $table->boolean('is_ended')->default(false)->comment('Закончен ли лот');
            $table->integer('status')->default(LotStatus::Active->value)->comment('Статус лота');
            $table->boolean('is_cancelled')->default(false)->comment('Отменен ли лот');
            $table->string('cancel_reason')->nullable()->comment('Причина отмены');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
