@php
/** @var App\Models\Lot $lot */
@endphp

<div class="lot-report">
    <h1>Лот №{{ $lot->id }}</h1>
    <p>Мулк: {{ $lot->lotable->name }}</p>
    <p>Описание: {{ $lot->description }}</p>
    <p>Начальная цена: {{ $lot->starting_price }}</p>
    <p>Дата начала: {{ $lot->starts_at->format('d-M H:i') }}</p>
    <p>Дата окончания: {{ $lot->ends_at->format('d-M H:i') }}</p>
    <p>Победитель: {{ $lot->winner->user->name ?? 'Не определен' }}</p>
</div>
