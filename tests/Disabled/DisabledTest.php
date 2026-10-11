<?php

use Illuminate\Support\Facades\Route;

it('registers no routes until it is enabled', function () {
    expect(Route::has('kb-help.home'))->toBeFalse();

    $this->get('/en/help')->assertNotFound();
});
