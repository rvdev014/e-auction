<div class="current-lots">
    <h3>Жорий лотлар</h3>
    @foreach($lots as $lot)
        @include('livewire.components.lot-item-card', ['lot' => $lot])
    @endforeach
</div>
