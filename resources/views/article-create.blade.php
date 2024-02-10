@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="p-5 bg-body-tertiary rounded-3">
                <div class="container-fluid py-3">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf

                        <h2 class="mb-4">Синхронное создание статьи</h2>

                        <div class="mb-2">
                            <label
                                for="article-create-sync-title-input"
                                class="form-label"
                            >
                                Заголовок
                            </label>
                            <input
                                id="article-create-sync-title-input"
                                class="form-control"
                                type="text"
                                name="title"
                                placeholder="Заголовок"
                                required
                            >
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-sync-file-input"
                                class="form-label"
                            >
                                Изображение
                            </label>

                            <input
                                id="article-create-sync-file-input"
                                class="form-control"
                                type="file"
                                name="file"
                                required
                                accept="image/*"
                            >
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-sync-preview-input"
                                class="form-label"
                            >
                                Анонс
                            </label>
                            <textarea
                                id="article-create-sync-preview-input"
                                class="form-control"
                                name="preview"
                                rows="4"
                                required
                                placeholder="Анонс"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-sync-content-input"
                                class="form-label"
                            >
                                Текст статьи
                            </label>
                            <textarea
                                id="article-create-sync-content-input"
                                class="form-control"
                                name="content"
                                rows="4"
                                required
                                placeholder="Текст статьи"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-sync-categories-input"
                                class="form-label"
                            >
                                Рубрики
                            </label>
                            <select
                                id="article-create-sync-categories-input"
                                class="form-control"
                                name="categories[]"
                                multiple
                                required
                            >
                                {!! \App\Helpers\Html::categoryTreeOptions($categoryTree) !!}
                            </select>

                            <div class="pt-2">
                                <p><em>Для выделения нескольких рубрик удерживайте <kbd>CTRL</kbd></em></p>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg">
            <div class="p-5 bg-body-tertiary rounded-3">
                <div class="container-fluid py-3">
                    <form id="article-create-async-form">
                        <h2 class="mb-4">Асинхронное создание статьи</h2>

                        <div class="mb-2">
                            <label
                                for="article-create-async-title-input"
                                class="form-label"
                            >
                                Заголовок
                            </label>
                            <input
                                id="article-create-async-title-input"
                                class="form-control"
                                type="text"
                                name="title"
                                placeholder="Заголовок"
                                required
                            >
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-async-file-input"
                                class="form-label"
                            >
                                Изображение
                            </label>

                            <input
                                id="article-create-async-file-input"
                                class="form-control"
                                type="file"
                                name="file"
                                required
                                accept="image/*"
                            >
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-async-preview-input"
                                class="form-label"
                            >
                                Анонс
                            </label>
                            <textarea
                                id="article-create-async-preview-input"
                                class="form-control"
                                name="preview"
                                rows="4"
                                required
                                placeholder="Анонс"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-async-content-input"
                                class="form-label"
                            >
                                Текст статьи
                            </label>
                            <textarea
                                id="article-create-async-content-input"
                                class="form-control"
                                name="content"
                                rows="4"
                                required
                                placeholder="Текст статьи"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="article-create-async-categories-input"
                                class="form-label"
                            >
                                Рубрики
                            </label>

                            <select
                                id="article-create-async-categories-input"
                                class="form-control"
                                name="categories[]"
                                multiple
                                required
                            >
                                {!! \App\Helpers\Html::categoryTreeOptions($categoryTree) !!}
                            </select>

                            <div class="pt-2">
                                <p><em>Для выделения нескольких рубрик удерживайте <kbd>CTRL</kbd></em></p>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
