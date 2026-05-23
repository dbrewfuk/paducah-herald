<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Form;

class WritingPersonaController extends ModuleController
{
    protected $moduleName = 'writingPersonas';

    protected function setUpController(): void
    {
        $this->enableReorder();
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Medias::make()
                ->name('avatar')
                ->label('Avatar')
        );

        $form->add(
            Input::make()
                ->name('specialty')
                ->label('Specialty')
                ->placeholder('e.g. News, Long-form, Opinion, Interview, Review')
                ->required()
        );

        $form->add(
            Input::make()
                ->name('voice_description')
                ->label('Voice Description')
                ->type('textarea')
                ->rows(8)
                ->note('Describe the tone, style, audience, and rules. This is sent to Claude as the writing instruction.')
                ->required()
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('specialty')->title('Specialty')
        );

        return $table;
    }
}
