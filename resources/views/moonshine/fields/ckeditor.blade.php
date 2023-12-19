<textarea id="ckeditor5"
          aria-label="{{ $field->label() ?? '' }}"
          placeholder="{{ $field->label() ?? '' }}"
          name="{{ $field->name() }}"

       {{ $field->isRequired() ? "required" : "" }}
    {{ $field->isDisabled() ? "disabled" : "" }}
    {{ $field->isReadonly() ? "readonly" : "" }}
>
    {!! $field->formViewValue($item) ?? '' !!}
</textarea>

<script>
    ClassicEditor
        .create(document.querySelector('#ckeditor5'))
        .catch(error => {
            console.error(error);
        });
</script>
