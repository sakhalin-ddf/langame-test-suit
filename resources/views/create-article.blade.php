@extends('layouts.app')

@section('content')
    <form method="POST">
        @csrf

        <div class="mb-2">
            <label
                for="create-article-sync-title-input"
                class="form-label"
            >
                Заголовок
            </label>
            <input
                id="create-article-sync-title-input"
                class="form-control"
                type="text"
                name="title"
                placeholder="Заголовок"
                required
            >
        </div>

        <div class="mb-2">
            <label
                for="create-article-sync-preview-input"
                class="form-label"
            >
                Анонс
            </label>
            <textarea
                id="create-article-sync-preview-input"
                class="form-control"
                name="preview"
                rows="4"
                required
                placeholder="Анонс"
            ></textarea>
        </div>

        <div class="mb-2">
            <label
                for="create-article-sync-content-input"
                class="form-label"
            >
                Текст статьи
            </label>
            <textarea
                id="create-article-sync-content-input"
                class="form-control"
                name="content"
                rows="4"
                required
                placeholder="Текст статьи"
            ></textarea>
        </div>

        <div class="mb-2">
            <label
                for="create-article-sync-categories-input"
                class="form-label"
            >
                Рубрики
            </label>
            <select
                id="create-article-sync-categories-input"
                class="form-control"
                name="categories"
                multiple
                required
            >
                {!! \App\Helpers\Html::categoryTreeOptions($categoryTree) !!}
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
