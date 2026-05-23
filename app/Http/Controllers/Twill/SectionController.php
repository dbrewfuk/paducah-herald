<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class SectionController extends BaseModuleController
{
    protected $moduleName = 'sections';

    protected function setUpController(): void
    {
        $this->enableReorder();
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('description')->label('Description')->type('textarea')->rows(3)
        );

        $form->add(
            Medias::make()->name('hero')->label('Hero image')
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();
        $table->add(Text::make()->field('description')->title('Description'));
        return $table;
    }
}
