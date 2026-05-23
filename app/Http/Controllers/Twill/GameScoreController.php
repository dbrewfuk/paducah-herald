<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class GameScoreController extends BaseModuleController
{
    protected $moduleName = 'gameScores';
    protected $titleColumnKey = 'home_team';

    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->setModuleName('gameScores');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        return TableColumns::make([
            Text::make()->field('away_team')->title('Away Team'),
            Text::make()->field('sport')->title('Sport'),
            Text::make()->field('status')->title('Status'),
            Text::make()->field('game_date')->title('Date'),
        ]);
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Select::make()->name('sport')->label('Sport')
                ->options([
                    ['value' => 'Baseball',   'label' => 'Baseball'],
                    ['value' => 'Softball',   'label' => 'Softball'],
                    ['value' => 'Basketball', 'label' => 'Basketball'],
                    ['value' => 'Football',   'label' => 'Football'],
                    ['value' => 'Soccer',     'label' => 'Soccer'],
                    ['value' => 'Tennis',     'label' => 'Tennis'],
                    ['value' => 'Track',      'label' => 'Track & Field'],
                    ['value' => 'Golf',       'label' => 'Golf'],
                ])
        );

        $form->add(
            Select::make()->name('status')->label('Status')
                ->options([
                    ['value' => 'upcoming',   'label' => 'Upcoming'],
                    ['value' => 'final',      'label' => 'Final'],
                    ['value' => 'postponed',  'label' => 'Postponed'],
                ])
        );

        $form->add(
            DatePicker::make()->name('game_date')->label('Date & Time')
        );

        $form->add(
            Input::make()->name('home_team')->label('Home Team')
                ->placeholder('e.g. McCracken County')
        );

        $form->add(
            Input::make()->name('away_team')->label('Away Team')
                ->placeholder('e.g. Murray')
        );

        $form->add(
            Input::make()->name('home_score')->label('Home Score')->type('number')
        );

        $form->add(
            Input::make()->name('away_score')->label('Away Score')->type('number')
        );

        $form->add(
            Input::make()->name('venue')->label('Venue')
                ->placeholder('e.g. Graves County HS')
        );

        $form->add(
            Input::make()->name('notes')->label('Notes')
                ->placeholder('e.g. Region Quarterfinal, OT, 8 inn.')
        );

        return $form;
    }
}
