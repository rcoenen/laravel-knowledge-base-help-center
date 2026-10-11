<?php

namespace Rcoenen\KnowledgeBaseHelpCenter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HelpCenterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('knowledge-base-help-center')
            ->hasConfigFile()
            ->hasViews('kb-help');
    }

    public function packageBooted(): void
    {
        // Interface text lives under the same short namespace as the views:
        // __('kb-help::help.search_button'). Override per app in lang/vendor/kb-help.
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'kb-help');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/kb-help'),
            ], 'knowledge-base-help-center-translations');
        }

        if (config('knowledge-base-help-center.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }
}
