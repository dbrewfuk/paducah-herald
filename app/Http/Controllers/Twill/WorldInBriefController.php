<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class WorldInBriefController extends BaseModuleController
{
    protected $moduleName = 'worldInBriefs';

    protected function setUpController(): void {}

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('region')->label('Region')->placeholder('e.g. United States, Middle East')
        );

        $form->add(
            DatePicker::make()->name('publish_start_date')->label('Published at')
        );

        $form->add(
            Medias::make()->name('hero')->label('Hero image')
        );

        $form->add(
            Wysiwyg::make()->name('body')->label('Brief text')
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();
        $table->add(Text::make()->field('region')->title('Region'));
        $table->add(Text::make()->field('publish_start_date')->title('Published'));
        return $table;
    }
}
