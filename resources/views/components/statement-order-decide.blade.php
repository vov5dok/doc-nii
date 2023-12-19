<div class="order-registration">
    <h2 class="application-title">Решение по заявлению</h2>
    {{--        TODO : удалить дубли--}}
    @if ($errors->any())
        <div class="mt-4 alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('statements.decide', $statement) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Файлы документов о принятом решении *</label>
            <div class="small mb-2">Прикрепите один или несколько файлов. Размер файла не должен превышать 10 Mb.</div>
            <input type="file" name="file[]" class="form-control" required>
            <div class="application__add-btn">
                <button type="button" class="btn js-add-file">+ Добавить еще файл</button>
            </div>
        </div>
        <div class="application__submit">
            <button type="submit" class="btn btn-submit">Разместить решение</button>
        </div>
    </form>
</div>
