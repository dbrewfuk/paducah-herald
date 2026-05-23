@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'name' => 'hero',
        'label' => 'Immagine principale',
    ])

    @formField('wysiwyg', [
        'name' => 'body',
        'label' => 'Testo articolo',
        'toolbarOptions' => [
            ['header' => [2, 3, false]],
            'bold', 'italic', 'underline',
            ['list' => 'ordered'], ['list' => 'bullet'],
            'link', 'blockquote', 'clean',
        ],
        'placeholder' => 'Scrivi il tuo articolo...',
    ])
@stop
