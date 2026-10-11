@extends('kb-help::layout')

@php use Rcoenen\KnowledgeBaseHelpCenter\Support\HelpRoutes; @endphp

@section('title', $page->name)

@if ($description = $page->translation->getAttribute('description'))
    @section('description', $description)
@endif

@section('content')
    <div class="kb-wrap kb-page">
        <nav aria-label="{{ __('kb-help::help.breadcrumb') }}">
            <ol class="kb-crumbs">
                <li><a href="{{ HelpRoutes::url('home', $locale) }}">{{ __('kb-help::help.help') }}</a></li>
                <li aria-current="page">{{ $page->name }}</li>
            </ol>
        </nav>

        <h1 class="kb-title">{{ $page->name }}</h1>

        @if ($description = $page->translation->getAttribute('description'))
            <p class="kb-lead">{{ $description }}</p>
        @endif

        @if ($page->children !== [])
            <ul class="kb-chips" aria-label="{{ __('kb-help::help.subtopics') }}">
                @foreach ($page->children as $child)
                    <li><a href="{{ HelpRoutes::url('category', $locale, ['slug' => $child->slug]) }}">{{ $child->name }} <span class="kb-count">{{ HelpRoutes::totalArticles($child) }}</span></a></li>
                @endforeach
            </ul>
        @endif

        @if ($page->articles !== [])
            @include('kb-help::partials.article-list', ['articles' => $page->articles])
        @else
            <p class="kb-empty">{{ __('kb-help::help.empty_category') }}</p>
        @endif
    </div>
@endsection
