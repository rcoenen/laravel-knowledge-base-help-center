<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable the public help center
    |--------------------------------------------------------------------------
    |
    | Off by default: installing the package registers no routes until you
    | switch this on. The pages are served in every language configured in
    | knowledge-base.locales, under /{locale}/{prefix}.
    |
    */
    'enabled' => env('KB_HELP_CENTER_ENABLED', false),

    'prefix' => env('KB_HELP_CENTER_PREFIX', 'help'),

    'middleware' => ['web'],

    // Route names become kb-help.home, kb-help.article, ...
    'route_name' => 'kb-help.',

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | `brand` defaults to config('app.name'). `home_url` adds a link back to
    | your main site in the header. Colours live in CSS custom properties: set
    | `custom_css` to a short stylesheet that overrides them (see README), or
    | publish the views for full control.
    |
    */
    'brand' => null,

    'home_url' => null,

    'custom_css' => null,

    /*
    |--------------------------------------------------------------------------
    | Content
    |--------------------------------------------------------------------------
    |
    | `faq_collection` is the slug (in the default language) of the collection
    | shown as quick answers on the home page; null hides the section.
    |
    */
    'faq_collection' => 'frequently-asked-questions',

    // Tell readers when the version they read was flagged outdated.
    'show_outdated_notice' => true,

    // "Was this helpful?" under every article (uses the core's feedback).
    'feedback' => true,

    'search_min_length' => 2,

    'search_limit' => 20,

];
