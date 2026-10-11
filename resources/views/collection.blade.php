@extends('kb-help::layout')

@php use Rcoenen\KnowledgeBaseHelpCenter\Support\HelpRoutes; @endphp

@section('title', $page->translation->getAttribute('name'))

@if ($description = $page->translation->getAttribute('description'))
    @section('description', $description)
@endif

@section('content')
    <div class="kb-wrap kb-page">
        <nav aria-label="{{ __('kb-help::help.breadcrumb') }}">
            <ol class="kb-crumbs">
                <li><a href="{{ HelpRoutes::url('home', $locale) }}">{{ __('kb-help::help.help') }}</a></li>
                <li aria-current="page">{{ $page->translation->getAttribute('name') }}</li>
            </ol>
        </nav>

        <h1 class="kb-title">{{ $page->translation->getAttribute('name') }}</h1>

        @if ($description = $page->translation->getAttribute('description'))
            <p class="kb-lead">{{ $description }}</p>
        @endif

        @if ($page->articles !== [])
            <div class="kb-faq kb-faq--page">
                @foreach ($page->articles as $item)
                    <details>
                        <summary>
                            <span>
                                {{ $item->translation->getAttribute('title') }}
                                @if ($item->locale !== $locale)
                                    <span class="kb-tag" lang="{{ $item->locale }}">{{ __('kb-help::help.in_language', ['language' => HelpRoutes::languageName($item->locale, $locale)]) }}</span>
                                @endif
                            </span>
                        </summary>
                        <div class="kb-faq__answer" lang="{{ $item->locale }}">
                            @if ($excerpt = $item->translation->getAttribute('excerpt'))
                                <p>{{ $excerpt }}</p>
                            @endif
                            <a href="{{ HelpRoutes::url('article', $locale, ['slug' => $item->slug]) }}">{{ __('kb-help::help.read_full_answer') }}</a>
                        </div>
                    </details>
                @endforeach
            </div>
        @else
            <p class="kb-empty">{{ __('kb-help::help.empty_category') }}</p>
        @endif
    </div>
@endsection
