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
                <img src="{{$article->image}}" alt="{{$article->title}}" class="card-img">
                <div class="card-body">
                    <div class="card-title">{{$article->title}}</div>
                    <p class="card-text">{{$article->preview}}</p>

                    <div class="card-read-more">
                        <a href="{{$article->original_url}}" class="btn btn-primary">Читать дальше</a>
                    </div>

                    <div class="card-categories">
                        @foreach($article->categories as $category)
                            <a class="btn btn-secondary" href="/category/{{ $category->code }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <template id="article-template">
        <div class="card">
            <img src="{image}" alt="{title}" class="card-img">
            <div class="card-body">
                <div class="card-title">{title}</div>
                <p class="card-text">{preview}</p>

                <div class="card-read-more">
                    <a href="{original_url}" class="btn btn-primary">Читать дальше</a>
                </div>

                <div class="card-categories">{categories}</div>
            </div>
        </div>
    </template>
@endsection
