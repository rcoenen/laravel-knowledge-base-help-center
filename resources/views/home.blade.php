@extends('kb-help::layout')

@php use Rcoenen\KnowledgeBaseHelpCenter\Support\HelpRoutes; @endphp

@section('description', __('kb-help::help.search_heading'))
@section('no_header_search', '1')

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
                            <a class="kb-topic" href="{{ HelpRoutes::url('category', $locale, ['slug' => $node->slug]) }}">
                                <span class="kb-topic__text">
                                    <span class="kb-topic__name">{{ $node->name }}</span>
                                    @if ($topicDescription = $node->translation->getAttribute('description'))
                                        <span class="kb-topic__description">{{ $topicDescription }}</span>
                                    @endif
                                </span>
                                <span class="kb-count">{{ trans_choice('kb-help::help.articles_count', HelpRoutes::totalArticles($node)) }}</span>
                                <span class="kb-topic__chevron" aria-hidden="true">›</span>
                            </a>
                            @if ($node->children !== [])
                                <ul class="kb-chips kb-chips--small" aria-label="{{ __('kb-help::help.subtopics') }}">
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
