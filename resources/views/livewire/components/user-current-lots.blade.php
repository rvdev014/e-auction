@php
    use App\Models\Lot;use App\Enums\LotStatus;
    /** @var Lot[] $lots */
@endphp

<div class="current-lots">
    <div class="current-lots-header">
        <h3 class="current-lots-header">Лотлар рўйхати</h3>
        <a download="oferta.pdf" href="{{ asset('auction-app/pdf/oferta.pdf') }}" class="btn--sm btn--primary">Оферта
            юклаб олиш</a>
    </div>
    <div class="table-wrapper">
        @if ($lots->isEmpty())
            <div class="alert alert-warning">
                Сизнинг лотларингиз мавжуд эмас
            </div>
        @else
            <table class="eg-table order-table table mb-0">
                <thead>
                <tr>
                    <th>Расми</th>
                    <th>Лот рақами</th>
                    <th>Товар</th>
                    <th>Бошланиш нархи</th>
                    <th>Сизнинг кадамингиз</th>
                    <th>Холати</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lots as $lot)
                    <tr>
                        <td>@include('livewire.components.lot-image', ['lot' => $lot])</td>
                        <td><a href="{{ route('lot.details', $lot->id) }}" wire:navigate>#{{ $lot->number }}</a></td>
                        <td><a href="{{ route('lot.details', $lot->id) }}" wire:navigate>{{ $lot->lotable->name }}</a>
                        </td>
                        <td>{{ $lot->starting_price }} сўм</td>
                        <td>{{ $lot->winner?->lastStep?->price ? "{$lot->winner?->lastStep?->price} сўм" : '---'}}</td>
                        <td>
                            @php
                                if ($lot->isStarted()) {
                                    echo '<span class="text-success">Бошланган</span>';
                                } elseif ($lot->status === LotStatus::Active) {
                                    echo '<span class="text-warning">Бошланмаган</span>';
                                } elseif ($lot->is_cancelled) {
                                    echo '<span class="text-danger">Бекор килинди</span>';
                                } elseif ($lot->winner?->user_id === auth()->id()) {
                                    echo '<span class="text-green">Ютилди</span>';
                                } else {
                                    echo '<span class="text-danger">Ютказилди</span>';
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
