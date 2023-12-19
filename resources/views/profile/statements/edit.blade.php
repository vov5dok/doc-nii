@php use App\Models\StatementFileType; @endphp
@extends('layouts.app')

@section('content')
    <div class="board">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('statements.list') }}">&larr; Назад к списку</a>
            </li>
        </ol>

        <x-statement-history-list :statement="$statement"/>

        <div class="application">
            {{--        TODO : вынести на более высокий уровень--}}
            @if ($errors->any())
                <div class="mt-4 alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h1 class="application-title">Редактирование заявления</h1>
            <form method="post" action="{{ route('statements.update', $statement) }} " enctype="multipart/form-data">
                <input hidden name="moonshine_user_role"
                       value="{{auth('moonshine')->user()->moonshineUserRole->id}}"
                >
                @csrf
                @if($statement->hasAnyStatus(['na-rassmotrenii', 'priniato-resenie', 'zaverseno']) && auth('moonshine')->user()->hasAnyRole(['employee']))
                    <div class="form-group-row">
                        <label class="col-form-label">Регистрационный номер *</label>
                        <div class="col-form-input">
                            <input type="text"
                                   class="form-control"
                                   value="{{ $statement->registration_number }}"
                                   name="registration_number"
                                   required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label class="col-form-label">Дата регистрации *</label>
                        <div class="col-form-input">
                            <input name="registration_date" type="date" class="form-control"
                                   value="{{ $statement->registration_date }}" required>
                        </div>
                    </div>

                    <div class="form-group-row show-consideration">
                        <label class="col-form-label">Дата заседания</label>
                        <div class="col-form-input">
                            <input name="session_date" type="date" class="form-control"
                                   value="{{ $statement->session_date }}">
                        </div>
                        <div class="col-form-text">
                            Дата заседания, на котором будет рассмотрено заявление
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Файлы документов о регистрации *</label>

                        <ul class="application-files registration-files">
                            @foreach($statement->files as $file)
                                @if($file->type->code  === StatementFileType::REGISTER)
                                    <li>
                                        <a href="{{ Storage::url($file->file) }}" target="blank" class="file-name"
                                           title="Скачать">
                                            {{ $file->name }}
                                        </a>
                                        <button id="reg" type="button" class="btn btn-delete" title="Удалить"
                                                data-id="{{ $file->id }}"></button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="application__add-btn">
                            <button type="button" id="reg" class="btn add-file">+ Добавить еще файл</button>
                        </div>
                    </div>
                    @if($statement->hasAnyStatus(['priniato-resenie', 'zaverseno']))

                        <div class="form-group">
                            <label class="form-label">Файлы документов о принятом решении *</label>

                            <ul class="application-files registration-files">
                                @foreach($statement->files as $file)
                                    @if($file->type->code  === StatementFileType::DECIDE)
                                        <li>
                                            <a href="{{ Storage::url($file->file) }}" target="blank" class="file-name"
                                               title="Скачать">
                                                {{ $file->name }}
                                            </a>
                                            <button id="dec" type="button" class="btn btn-delete" title="Удалить"
                                                    data-id="{{ $file->id }}"></button>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="application__add-btn">
                                <button type="button" id="dec" class="btn add-file">+ Добавить еще файл</button>
                            </div>
                        </div>
                    @endif
                    <div class="form-group show-consideration">
                        <label class="form-label">Эксперты по заявлению</label>
                        <select name="statement_experts[]" class="selectpicker" title="выберите" multiple>
                            @foreach($experts as $expert)
                                <option
                                    value="{{ $expert->id }}"
                                    @if($statement->experts()->get()->pluck('id')->contains($expert->id))
                                        selected
                                    @endif
                                >{{ $expert->second_name }} {{ $expert->name }} {{ $expert->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif


                <div class="form-group">
                    <label class="form-label">Наименование</label>
                    <input name="name" type="text" class="form-control" value="{{ $statement->name }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Тип процедуры</label>
                    <select name="current_procedure_id" class="selectpicker" title="выберите">
                        @foreach($procedures as $procedure)
                            <option
                                {{ $statement->currentProcedure->id === $procedure->id ? 'selected' : '' }}
                                value="{{ $procedure->id }}">
                                {{ $procedure->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Файлы *</label>
                    <ul class="application-files">
                        @foreach($statement->files as $file)
                            @if($file->type->code === StatementFileType::DEFAULT)
                                <li>
                                    <a href="{{ Storage::url($file->file) }}" target="blank" class="file-name"
                                       title="Скачать">
                                        {{ $file->name }}
                                    </a>
                                    @if(auth('moonshine')->user()->hasAnyRole(['applicant', 'employee']))
                                        <button type="button" class="btn btn-delete" data-id="{{ $file->id }}"
                                                title="Удалить"></button>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    @if(auth('moonshine')->user()->hasAnyRole(['applicant', 'employee']))
                        <div class="application__add-btn">
                            <button type="button" class="btn js-add-file">+ Добавить еще файл</button>
                        </div>
                    @endif

                </div>

                <div class="application__submit">
                    <button type="submit" class="btn btn-submit" id="submitApplication">Сохранить изменения</button>
                </div>
            </form>

            <x-statement-messages :statement="$statement"/>
        </div>
    </div>
    @if(auth('moonshine')->user()->hasAnyRole(['applicant', 'employee', 'admin']))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const filesLists = document.querySelectorAll('.application-files');

                    filesLists.forEach(function (filesList) {
                        filesList.addEventListener('click', function (event) {
                            const target = event.target;
                            const listItem = target.closest('li');

                            if (!listItem) return;

                            if (target.classList.contains('btn-delete')) {
                                handleDelete(target, listItem);
                            } else if (target.classList.contains('btn-undo')) {
                                handleUndo(listItem);
                            }
                        });
                    });

                    function handleDelete(button, listItem) {
                        const documentId = button.getAttribute('data-id');

                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';

                        if (button.hasAttribute('id')) {
                            const idValue = button.getAttribute('id');
                            hiddenInput.name = `${idValue}_delete_files[]`;
                        } else {
                            hiddenInput.name = 'delete_files[]';
                        }

                        hiddenInput.value = documentId;

                        listItem.setAttribute('data-original-content', listItem.innerHTML);
                        listItem.innerHTML = 'Файл удален <button type="button" class="btn btn-undo" title="Отменить">Отменить</button>';
                        listItem.appendChild(hiddenInput);
                    }

                    function handleUndo(listItem) {
                        const hiddenInput = listItem.querySelector('input[name$="_delete_files[]"]');
                        if (hiddenInput) {
                            hiddenInput.remove();
                        }

                        listItem.innerHTML = listItem.getAttribute('data-original-content');
                    }

                    const addButtons = document.querySelectorAll('.add-file');

                    addButtons.forEach(function (addButton) {
                        addButton.addEventListener('click', function () {
                            const fileInputDiv = document.createElement('div');
                            fileInputDiv.classList.add('file-input');

                            const fileInput = document.createElement('input');
                            fileInput.type = 'file';
                            fileInput.classList.add('form-control');

                            if (addButton.hasAttribute('id')) {
                                const idValue = addButton.getAttribute('id');
                                fileInput.name = `${idValue}_files[]`;
                            } else {
                                fileInput.name = 'file[]';
                            }

                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.classList.add('btn');

                            fileInputDiv.appendChild(fileInput);
                            fileInputDiv.appendChild(removeButton);

                            removeButton.addEventListener('click', function () {
                                fileInputDiv.remove();
                            });

                            const registrationFiles = this.parentNode.previousElementSibling;
                            const addBtnWrapper = this.parentNode;

                            registrationFiles.parentNode.insertBefore(fileInputDiv, addBtnWrapper);
                        });
                    });
                });

            </script>
        @endpush
    @endif
@endsection
