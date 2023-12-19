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
    <form method="post" action="{{ route('statements.decide.expert', $statement) }}" enctype="multipart/form-data">
        @csrf


        <div class="form-group">
            <label class="form-label">Комментарий эксперта *</label>
            <textarea name="text" class="form-control"
                      rows="5">{!! $statement->expertOpinions()->first()->text ?? '' !!}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Файлы с ответом эксперта *</label>
            <ul class="application-files">

                @foreach($files as $file)
                    <li>
                        <a href="{{ Storage::url($file->file) }}" target="blank" title="Скачать">
                            {{ $file->name }} <br>
                        </a>
                        @if($statement->hasAnyStatus(['na-rassmotrenii']))
                            <button type="button" class="btn btn-delete" data-id="{{ $file->id }}"
                                    title="Удалить"></button>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="small mb-2">Прикрепите один или несколько файлов. Размер файла не должен превышать 10
                Mb.
            </div>
            <input name="file[]" type="file" class="form-control" required>
            <div class="application__add-btn">
                <button type="button" class="btn js-add-file">+ Добавить еще файл</button>
            </div>
        </div>

        <div class="application__submit">
            <button type="submit" class="btn btn-submit">Сохранить</button>
        </div>
    </form>
</div>
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
