<?php

namespace App\MoonShine\Fields;

use Leeto\MoonShine\Fields\Field;

class CKEditorField extends Field
{

    protected static string $view = 'moonshine.fields.ckeditor';

    // Необходимые дополнительные assets
    protected array $assets = [
        '/ckeditor/ckeditor.js',
    ];
}
