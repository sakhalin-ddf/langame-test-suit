@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="p-5 bg-body-tertiary rounded-3">
                <div class="container-fluid py-3">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf

                        <h2 class="mb-4">Синхронное создание статьи</h2>

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
                                for="create-article-sync-file-input"
                                class="form-label"
                            >
                                Изображение
                            </label>

                            <input
                                id="create-article-sync-file-input"
                                class="form-control"
                                type="file"
                                name="file"
                                required
                                accept="image/*"
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

        <div class="col">
            <div class="p-5 bg-body-tertiary rounded-3">
                <div class="container-fluid py-3">
                    <form id="create-article-async-form">
                        <h2 class="mb-4">Синхронное создание статьи</h2>

                        <div class="mb-2">
                            <label
                                for="create-article-async-title-input"
                                class="form-label"
                            >
                                Заголовок
                            </label>
                            <input
                                id="create-article-async-title-input"
                                class="form-control"
                                type="text"
                                name="title"
                                placeholder="Заголовок"
                                required
                            >
                        </div>

                        <div class="mb-2">
                            <label
                                for="create-article-async-preview-input"
                                class="form-label"
                            >
                                Анонс
                            </label>
                            <textarea
                                id="create-article-async-preview-input"
                                class="form-control"
                                name="preview"
                                rows="4"
                                required
                                placeholder="Анонс"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="create-article-async-content-input"
                                class="form-label"
                            >
                                Текст статьи
                            </label>
                            <textarea
                                id="create-article-async-content-input"
                                class="form-control"
                                name="content"
                                rows="4"
                                required
                                placeholder="Текст статьи"
                            ></textarea>
                        </div>

                        <div class="mb-2">
                            <label
                                for="create-article-async-categories-input"
                                class="form-label"
                            >
                                Рубрики
                            </label>
                            <select
                                id="create-article-async-categories-input"
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
