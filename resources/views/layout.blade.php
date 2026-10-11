@php
    use Rcoenen\KnowledgeBaseHelpCenter\Support\HelpRoutes;

    $brand = config('knowledge-base-help-center.brand') ?: config('app.name');
    $homeUrl = config('knowledge-base-help-center.home_url');
    $switch = $switch ?? [];
    $pageTitle = trim($__env->yieldContent('title'));
@endphp
<!doctype html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle !== '' ? $pageTitle.' | ' : '' }}{{ __('kb-help::help.help') }} | {{ $brand }}</title>
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @endif
    @if (! empty($canonical))
        <link rel="canonical" href="{{ $canonical }}">
    @endif
    @foreach ($switch as $alternateLocale => $alternateUrl)
        <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}">
    @endforeach
    @include('kb-help::partials.styles')
    @if (config('knowledge-base-help-center.custom_css'))
        <style>{!! config('knowledge-base-help-center.custom_css') !!}</style>
    @endif
</head>
<body class="kb">
    <a class="kb-skip" href="#kb-main">{{ __('kb-help::help.skip') }}</a>

    <header class="kb-header">
        <div class="kb-wrap kb-header__inner">
            <a class="kb-brand" href="{{ HelpRoutes::url('home', $locale) }}">
                <span class="kb-brand__name">{{ $brand }}</span>
                <span class="kb-brand__section">{{ __('kb-help::help.help') }}</span>
            </a>

            <div class="kb-header__tools">
                @if ($homeUrl)
                    <a class="kb-header__back" href="{{ $homeUrl }}">{{ __('kb-help::help.back_to_site', ['brand' => $brand]) }}</a>
                @endif

                @if (count(HelpRoutes::locales()) > 1)
                    <nav class="kb-langs" aria-label="{{ __('kb-help::help.language') }}">
                        @foreach (HelpRoutes::locales() as $candidate)
                            @if ($candidate === $locale)
                                <span class="kb-langs__item" aria-current="true" lang="{{ $candidate }}" title="{{ HelpRoutes::languageName($candidate) }}">{{ strtoupper($candidate) }}</span>
                            @elseif (isset($switch[$candidate]))
                                <a class="kb-langs__item" href="{{ $switch[$candidate] }}" hreflang="{{ $candidate }}" lang="{{ $candidate }}" title="{{ HelpRoutes::languageName($candidate) }}">{{ strtoupper($candidate) }}</a>
                            @else
                                <span class="kb-langs__item kb-langs__item--off" lang="{{ $candidate }}" title="{{ HelpRoutes::languageName($candidate) }}">{{ strtoupper($candidate) }}</span>
                            @endif
                        @endforeach
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <main id="kb-main" class="kb-main" tabindex="-1">
        @yield('content')
    </main>

    <footer class="kb-footer">
        <div class="kb-wrap">
            <a href="{{ HelpRoutes::url('home', $locale) }}">{{ $brand }} {{ __('kb-help::help.help') }}</a>
        </div>
    </footer>
</body>
</html>
