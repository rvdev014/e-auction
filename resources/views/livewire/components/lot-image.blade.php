@if (!$lot->lotable->mediaAttachments->isEmpty())
    <img alt="image" src="{{ asset('storage/' . $lot->lotable->mediaAttachments[0]?->file_path) }}">
@else
    <img alt="image" src="{{ asset('auction-app/assets/images/empty.jpg') }}">
@endif
