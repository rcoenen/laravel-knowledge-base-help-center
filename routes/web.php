<?php

use Illuminate\Support\Facades\Route;
use JeffersonGoncalves\KnowledgeBase\Support\Locales;
use Rcoenen\KnowledgeBaseHelpCenter\Http\Controllers\HelpCenterController;

$prefix = trim((string) config('knowledge-base-help-center.prefix', 'help'), '/');
$name = (string) config('knowledge-base-help-center.route_name', 'kb-help.');

Route::middleware(config('knowledge-base-help-center.middleware', ['web']))
    ->name($name)
    ->group(function () use ($prefix) {
        // /help without a language: send readers to the app's current language.
        Route::get($prefix, [HelpCenterController::class, 'entry'])->name('entry');

        Route::prefix('{locale}/'.$prefix)
            ->whereIn('locale', Locales::all())
            ->group(function () {
                Route::get('/', [HelpCenterController::class, 'home'])->name('home');
                Route::get('/search', [HelpCenterController::class, 'search'])->name('search');
                Route::get('/articles/{slug}', [HelpCenterController::class, 'article'])->name('article');
                Route::post('/articles/{slug}/feedback', [HelpCenterController::class, 'feedback'])
                    ->middleware('throttle:10,1')
                    ->name('feedback');
                Route::get('/categories/{slug}', [HelpCenterController::class, 'category'])->name('category');
                Route::get('/collections/{slug}', [HelpCenterController::class, 'collection'])->name('collection');
            });
    });
