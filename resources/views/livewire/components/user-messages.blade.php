@php
    use App\Models\Message;
    /** @var Message[] $messages */
@endphp

<div class="current-lots">
    <div class="current-lots-header">
        <h3 class="current-lots-header">Хабарлар</h3>
    </div>
    <div class="table-wrapper">
        @if ($messages->isEmpty())
            <div class="alert alert-warning">
                Сизга хабарлар келмаган
            </div>
        @else
            <table class="eg-table order-table table mb-0">
                <thead>
                <tr>
                    <th>Вақт</th>
                    <th>Хабар</th>
                    <th>Мавзу</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td style="white-space: nowrap">{{ $message->created_at->format('d-M H:i') }}</td>
                        <td>{{ $message->title }}</td>
                        <td>{{ $message->body }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
