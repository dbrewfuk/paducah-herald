<?php

namespace App\Providers;

use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Facades\TwillNavigation;
use A17\Twill\Services\Settings\SettingsGroup;
use A17\Twill\View\Components\Navigation\NavigationLink;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        TwillAppSettings::registerSettingsGroup(
            SettingsGroup::make()
                ->name('siteSettings')
                ->label('Site Settings')
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('articles')
                ->title('Articles')
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('sections')
                ->title('Sections')
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('weeklyEditions')
                ->title('Weekly Editions')
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('worldInBriefs')
                ->title('World in Brief')
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('insiderEpisodes')
                ->title('Insider Episodes')
        );
    }
}
