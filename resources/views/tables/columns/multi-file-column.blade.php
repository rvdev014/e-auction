<div class="flex justify-center px-4 py-1">
    @php
    $images = $getRecord()->$relation;
    @endphp
    @if($images->count() > 0)
        <img
            alt="image"
            src="{{ asset('storage/'. $images[0]->file_path) }}"
            class="img-fluid section-bg-top"
            style="width: 70px; max-height: 100%"
        />
    @endif
</div>
