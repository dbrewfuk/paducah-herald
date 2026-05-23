<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Browser;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ArticleController extends BaseModuleController
{
    protected $moduleName = 'articles';

    protected function setUpController(): void
    {
        $this->setPermalinkBase('articles');
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('fly_title')->label('Fly title (section label)')
                ->placeholder('e.g. United States')
        );

        $form->add(
            Input::make()->name('standfirst')->label('Standfirst')->type('textarea')->rows(2)
        );

        $form->add(
            Input::make()->name('read_time')->label('Read time (minutes)')->type('number')
        );

        $form->add(
            Browser::make()->name('section')->label('Section')
                ->modules([\App\Models\Section::class])->max(1)
        );

        $form->add(
            DatePicker::make()->name('publish_start_date')->label('Publish date')->withoutTime()
        );

        $form->add(
            Medias::make()->name('hero')->label('Hero image')
        );

        $form->add(
            Wysiwyg::make()->name('body')->label('Body')
                ->placeholder('Write the article...')
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();
        $table->add(Text::make()->field('fly_title')->title('Section'));
        $table->add(Text::make()->field('publish_start_date')->title('Published'));
        return $table;
    }
}
