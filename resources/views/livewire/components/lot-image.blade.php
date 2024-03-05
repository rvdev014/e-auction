@if (!$lot->lotable->mediaAttachments->isEmpty())
    <img alt="image" src="{{ asset('storage/' . $lot->lotable->mediaAttachments[0]?->file_path) }}">
@endif
