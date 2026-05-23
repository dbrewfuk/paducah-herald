<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class WeeklyEditionController extends BaseModuleController
{
    protected $moduleName = 'weeklyEditions';

    protected function setUpController(): void {}

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            DatePicker::make()->name('edition_date')->label('Edition date')->withoutTime()
        );

        $form->add(
            DatePicker::make()->name('publish_start_date')->label('Publish date')->withoutTime()
        );

        $form->add(
            Medias::make()->name('cover')->label('Cover image')
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();
        $table->add(Text::make()->field('edition_date')->title('Edition date'));
        return $table;
    }
}
