@php use App\Enums\LotStatus; @endphp

<div>
    @if ($getRecord()->is_cancelled)
        <x-filament::badge
            color="{{ LotStatus::Cancelled->getColor() }}"
            icon="{{ LotStatus::Cancelled->getIcon() }}"
        >
            {{ LotStatus::Cancelled->getLabel() }}
        </x-filament::badge>
    @elseif ($getRecord()->ends_at->isPast())
        <x-filament::badge
            color="{{ LotStatus::Ended->getColor() }}"
            icon="{{ LotStatus::Ended->getIcon() }}"
        >
            {{ LotStatus::Ended->getLabel() }}
        </x-filament::badge>
    @else
        <x-filament::badge
            color="{{ LotStatus::Active->getColor() }}"
            icon="{{ LotStatus::Active->getIcon() }}"
        >
            {{ LotStatus::Active->getLabel() }}
        </x-filament::badge>
    @endif
</div>
