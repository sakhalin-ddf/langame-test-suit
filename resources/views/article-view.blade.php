@extends('layouts.app')

@section('content')
    <div class="article-view">
        <div class="p-5 bg-body-tertiary rounded-3">
            <div class="container-fluid py-3">
                @if($article !== null)
                    <h1>{{$article->title}}</h1>

                    <div class="published">Опубликовано: {{$article->created_at->format('d.m.Y H:i')}}</div>

                    @if($article->categories->count() > 0)
                        <div class="categories mb-4">
                            @foreach($article->categories as $category)
                                <span class="btn btn-secondary">{{$category->name}}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($article->original_url)
                        <div class="original-link">
                            Читать оригинальную статью на
                            <a href="{{$article->original_url}}" target="_blank" rel="noreferrer nofollow noopener">
                                {{\str_replace('www.', '', \parse_url($article->original_url, \PHP_URL_HOST))}}
                            </a>
                        </div>
                    @endif

                    @if($article->image)
                        <div class="image">
                            <img src="{{$article->image}}" alt="">
                        </div>
                    @endif

                    <div class="content">
                        {!! \nl2br($article->content) !!}
                    </div>
                @else
                    <h1>Что то пошло не так</h1>

                    <div class="content">
                        Статья не найдена =(

                        <br>
                        <br>

                        Что бы продолжить работу <a href="/">вернитесь на главную</a> или
                        <form action="/" method="GET" class="inline-search-form">
                            <div class="inline-search-form-inner">
                                <input type="text" name="query" placeholder="поищите что вам интересно">
                                <button type="submit" class="btn btn-primary">Искать</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
