@php use App\Models\StatementStatus; @endphp
<div class="history">
    <ul class="history__list">
        @foreach($statement->history as $step)
            <li class="history__item @if($step->status->id === StatementStatus::COMPLETED) order-complete @endif">
                <div class="status-point"></div>
                <div class="status-name">{{ $step->status->name }}</div>
                <div class="status-date">{{ $step->created_at }}</div>
            </li>
        @endforeach
    </ul>
</div>
