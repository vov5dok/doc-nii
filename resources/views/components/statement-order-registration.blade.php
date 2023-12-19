@php use App\Models\StatementStatus; @endphp
<div class="order-registration">
    <h2 class="application-title">Регистрация заявления</h2>
    @if ($errors->any())
        <div class="mt-4 alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('statements.register', $statement) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group-row js-registration">
            <div class="col-form-check">
                <div class="form-check">
                    <input class="form-check-input js-consideration" type="radio"
                           id="registrationType1"
                           name="statement_status_id"
                           value="{{StatementStatus::UNDER_CONSIDERATION}}"
                           checked
                    >
                    <label class="form-check-label" for="registrationType1">
                        Рассмотреть на заседании
                    </label>
                </div>
            </div>

            <div class="col-form-check">
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                           value="{{StatementStatus::TAKEN_INTO_CONSIDERATION}}"
                           name="statement_status_id" id="registrationType2"
                    >
                    <label class="form-check-label" for="registrationType2">
                        Принять к сведению
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group-row">
            <label class="col-form-label">Регистрационный номер *</label>
            <div class="col-form-input">
                <input name="registration_number" type="text" class="form-control" required>
            </div>
        </div>

        <div class="form-group-row">
            <label class="col-form-label">Дата регистрации *</label>
            <div class="col-form-input">
                <input name="registration_date" type="date" class="form-control" required>
            </div>
        </div>

        <div class="form-group-row show-consideration">
            <label class="col-form-label">Дата заседания</label>
            <div class="col-form-input">
                <input name="session_date" type="date" class="form-control">
            </div>
            <div class="col-form-text">
                Дата заседания, на котором будет рассмотрено заявление
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Файлы документов о регистрации *</label>
            <div class="small mb-2">Прикрепите один или несколько файлов. Размер файла не должен превышать 10 Mb.</div>
            <input type="file" name="file[]" class="form-control" required>
            <div class="application__add-btn">
                <button type="button" class="btn js-add-file">+ Добавить еще файл</button>
            </div>
        </div>

        <div class="form-group show-consideration">
            <label class="form-label">Эксперты по заявлению</label>
            <select name="statement_experts[]" class="selectpicker" title="выберите" multiple>
                @foreach($statementExperts as $expert)
                    <option value="{{ $expert->id }}">
                        {{ $expert->second_name }} {{ $expert->name }} {{ $expert->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="application__submit">
            <button type="submit" class="btn btn-submit">Зарегистрировать</button>
        </div>
    </form>
</div>
