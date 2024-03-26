@php
    use App\Models\Lot;
    /** @var Lot[] $reports */
@endphp

<div class="current-lots">
    <div class="current-lots-header">
        <h3 class="current-lots-header">Голиблик баённомалари</h3>
    </div>
    <div class="table-wrapper">
        @if ($reports->isEmpty())
            <div class="alert alert-warning">Голиблик баённомалари мавжуд эмас</div>
        @else
            <table class="eg-table order-table table mb-0">
                <thead>
                <tr>
                    <th>Лот</th>
                    <th>Мулк</th>
                    <th>Сана</th>
                    <th>Бошлангич нарх</th>
                    <th>Голиб чиқарилган нарх</th>
                    <th>Аукцион бошланган вақт</th>
                    <th>Баённома</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td><a href="{{ route('lot.details', $report->id) }}" wire:navigate>#{{ $report->number }}</a></td>
                        <td><a href="{{ route('lot.details', $report->id) }}" wire:navigate>{{ $report->lotable->name }}</a></td>
                        <td style="white-space: nowrap">{{ $report->created_at->format('d-M H:i') }}</td>
                        <td>{{ $report->starting_price }} сўм</td>
                        <td>{{ $report->winner?->lastStep?->price }} сўм</td>
                        <td style="white-space: nowrap">{{ $report->starts_at->format('d-M H:i') }}</td>
                        <td>
                            <a href="#">PDF форматда юклаш</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
