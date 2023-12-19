@extends('layouts.app')

@section('content')
    <!-- Start content page -->
    <div class="board">
        <h1 class="page-title">Новое заявление</h1>
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
        <div class="application">
            <form method="post" action="{{ route('statements.store') }} " enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Наименование</label>
                    <input name="name" type="text" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Тип процедуры *</label>
                    <select name="current_procedure_id" class="selectpicker" title="выберите">
                        @foreach($procedures as $procedure)
                            <option value="{{ $procedure->id }}" @selected(old('current_procedure_id' == $procedure->id))>{{ $procedure->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Файлы *</label>
                    <div class="small mb-2">Прикрепите один или несколько файлов. Размер файла не должен превышать 10
                        Mb.
                    </div>
                    <input type="file" name="file[]" class="form-control">
                    <div class="application__add-btn">
                        <button type="button" class="btn js-add-file">+ Добавить еще файл</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Комментарий</label>
                    <textarea name="comment" class="form-control"></textarea>
                </div>

                <div class="application__submit">
                    <button type="submit" class="btn btn-submit" id="submitApplication">Отправить</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End content page -->
@endsection
