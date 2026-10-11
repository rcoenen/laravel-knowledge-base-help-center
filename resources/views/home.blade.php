@extends('kb-help::layout')

@php use Rcoenen\KnowledgeBaseHelpCenter\Support\HelpRoutes; @endphp

@section('description', __('kb-help::help.search_heading'))

@section('content')
    <section class="kb-hero">
        <div class="kb-wrap">
            <h1>{{ __('kb-help::help.search_heading') }}</h1>
            @include('kb-help::partials.search-form', ['id' => 'home', 'autofocus' => false])
        </div>
    </section>

    <div class="kb-wrap kb-home">
        @if ($faq && $faq->articles !== [])
            <section aria-labelledby="kb-quick-answers">
                <h2 class="kb-section-title" id="kb-quick-answers">{{ __('kb-help::help.quick_answers') }}</h2>
                <div class="kb-faq">
                    @foreach (array_slice($faq->articles, 0, 6) as $item)
                        <details>
                            <summary>
                                <span lang="{{ $item->locale }}">
                                    {{ $item->translation->getAttribute('title') }}
                                    @if ($item->locale !== $locale)
                                        <span class="kb-tag" lang="{{ $locale }}">{{ __('kb-help::help.in_language', ['language' => HelpRoutes::languageName($item->locale, $locale)]) }}</span>
                                    @endif
                                </span>
                            </summary>
                            <div class="kb-faq__answer">
                                @if ($excerpt = $item->translation->getAttribute('excerpt'))
                                    <p>{{ $excerpt }}</p>
                                @endif
                                <a href="{{ HelpRoutes::url('article', $locale, ['slug' => $item->slug]) }}">{{ __('kb-help::help.read_full_answer') }}</a>
                            </div>
                        </details>
                    @endforeach
                </div>
                <a class="kb-more" href="{{ HelpRoutes::url('collection', $locale, ['slug' => $faq->slug]) }}">{{ __('kb-help::help.see_all_questions') }}</a>
            </section>
        @endif

        @if ($categories !== [])
            <section aria-labelledby="kb-topics">
                <h2 class="kb-section-title" id="kb-topics">{{ __('kb-help::help.browse_topics') }}</h2>
                <ul class="kb-topics">
                    @foreach ($categories as $node)
                        <li>
                            <div class="kb-topic">
                                <a href="{{ HelpRoutes::url('category', $locale, ['slug' => $node->slug]) }}">{{ $node->name }}</a>
                                <span class="kb-count">{{ trans_choice('kb-help::help.articles_count', HelpRoutes::totalArticles($node)) }}</span>
                            </div>
                            @if ($node->children !== [])
                                <ul class="kb-subtopics">
                                    @foreach ($node->children as $child)
                                        <li><a href="{{ HelpRoutes::url('category', $locale, ['slug' => $child->slug]) }}">{{ $child->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
@endsection
