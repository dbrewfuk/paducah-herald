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

class InsiderEpisodeController extends BaseModuleController
{
    protected $moduleName = 'insiderEpisodes';

    protected function setUpController(): void {}

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('episode_summary')->label('Episode summary')->type('textarea')->rows(4)
        );

        $form->add(
            Input::make()->name('sponsor_name')->label('Sponsor name')
        );

        $form->add(
            Input::make()->name('video_url')->label('Video URL')->type('url')
        );

        $form->add(
            DatePicker::make()->name('publish_start_date')->label('Publish date')->withoutTime()
        );

        $form->add(
            Medias::make()->name('thumbnail')->label('Video thumbnail')
        );

        $form->add(
            Medias::make()->name('sponsor_logo')->label('Sponsor logo')
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();
        $table->add(Text::make()->field('sponsor_name')->title('Sponsor'));
        $table->add(Text::make()->field('publish_start_date')->title('Published'));
        return $table;
    }
}
