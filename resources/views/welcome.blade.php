@extends('layouts.app')

@section('content')
    <form id="articles-search-form">
        <div class="input-group input-group-lg mb-5">
            <input type="search" name="query" class="form-control" value="{{ $query }}" placeholder="Введите ваш поисковый запрос">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <div id="articles-list" class="article-list">
        @foreach($articles as $article)
            <div class="card">
                <img src="{{$article->image ?: '/img/no-preview.jpeg'}}" alt="{{$article->title}}" class="card-img">
                <span class="original-link-host">{{$article->original_url ? \str_replace('www.', '', \parse_url($article->original_url, \PHP_URL_HOST)) : ''}}</span>
                <div class="card-body">
                    <div class="card-title">{{$article->title}}</div>
                    <p class="card-text">{!! $article->preview !!}</p>

                    <div class="card-read-more">
                        <a href="/article/{{$article->code}}" class="btn btn-primary">Читать дальше</a>
                    </div>

                    <div class="card-categories">
                        @foreach($article->categories as $category)
                            <span class="btn btn-secondary">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <template id="article-template">
        <div class="card">
            <img src="{image}" alt="{title}" class="card-img">
            <span class="original-link-host">{original_url_host}</span>
            <div class="card-body">
                <div class="card-title">{title}</div>
                <p class="card-text">{preview}</p>

                <div class="card-read-more">
                    <a href="/article/{code}" class="btn btn-primary">Читать дальше</a>
                </div>

                <div class="card-categories">{categories}</div>
            </div>
        </div>
    </template>
@endsection
