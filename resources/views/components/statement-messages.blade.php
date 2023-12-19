<div class="comments">
    <h2 class="application-title">Комментарии к заявлению</h2>

    <div class="row">
        <div class="comments__form">
            <form class="comments__form-layout" method="post"
                  action="{{ route('statements.add_message', $statement) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Ваш комментарий</label>
                    <textarea name="message" class="form-control"></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn">Отправить</button>
                </div>
            </form>
        </div>

        <div class="comments__history">
            <div class="comment-list">
                @foreach($messages as $messageData)
                    @can('view', $messageData)
                        @if($messageData->moonshineUser->id === auth('moonshine')->user()->id)
                            <div class="comment my-comment">
                                <div class="comment-author">Вы:</div>
                                <div class="comment-message">{{ $messageData->message }}</div>
                                <div class="comment-data">{{ $messageData->date }}</div>
                            </div>
                        @else
                            <div class="comment">
                                <div class="comment-author">
                                    {{ $messageData->moonshineUser->second_name }} {{ $messageData->moonshineUser->name }} {{ $messageData->moonshineUser->last_name }}
                                </div>
                                <div class="comment-message">{{ $messageData->message }}</div>
                                <div class="comment-data">{{ $messageData->date }}</div>
                            </div>
                        @endif
                    @endcan
                @endforeach
            </div>
        </div>
    </div>
</div>
