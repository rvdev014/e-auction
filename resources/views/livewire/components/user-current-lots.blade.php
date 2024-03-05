@php
    use App\Models\Lot;
    /** @var Lot[] $lots */
@endphp

<div class="current-lots">
    <div class="current-lots-header">
        <h3 class="current-lots-header">Лотлар рўйхати</h3>
    </div>
    <div class="table-wrapper">
        <table class="eg-table order-table table mb-0">
            <thead>
            <tr>
                <th>Расми</th>
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
                    <td>
                        <a href="{{ route('lot.details', $lot->id) }}" wire:navigate>{{ $lot->lotable->name }}</a>
                    </td>
                    <td>{{ $lot->starting_price }} сўм</td>
                    <td>{{ $lot->latestStep->price ? "{$lot->latestStep->price} сўм" : '---'}}</td>
                    <td>
                        @php
                            $lastStep = $lot->steps()->orderBy('price', 'desc')->firstOrFail();

                            if ($lot->starts_at > now()) {
                                echo '<span class="text-warning">Бошланмаган</span>';
                            } elseif ($lot->ends_at > now()) {
                                echo '<span class="text-success">Давом этмоқда</span>';
                            } elseif ($lot->is_cancelled) {
                                echo '<span class="text-danger">Бекор килинди</span>';
                            } elseif ($lastStep->user_id === auth()->id()) {
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
    </div>
</div>
