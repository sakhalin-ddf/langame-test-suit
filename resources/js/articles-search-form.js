(function () {
    'use strict';

    const $form = document.getElementById('articles-search-form');
    const $articlesList = document.getElementById('articles-list');
    const $articlesTemplate = document.getElementById('article-template');

    if (!$form) {
        return;
    }

    $form.addEventListener('submit', (e) => {
        e.preventDefault();

        const query = e.target.query.value.trim();
        const url = new URL(location.href);

        e.target.query.value = query;

        if (query) {
            url.searchParams.set('query', query);
        } else {
            url.searchParams.delete('query');
        }

        history.replaceState({}, document.title, url);

        fetch('/api/articles', {
            method: 'POST',
            body: new FormData(e.target),
        })
            .then(res => res.json())
            .then(({ data }) => {
                $articlesList.innerHTML = data.map(renderArticle).join('');
            });
    });

    function renderArticle(article) {
        return $articlesTemplate.innerHTML
            .replaceAll('{id}', article.id)
            .replaceAll('{title}', article.title)
            .replaceAll('{original_url}', article.original_url)
            .replaceAll('{image}', article.image)
            .replaceAll('{preview}', article.preview)
            .replaceAll(
                '{categories}',
                article.categories.map(category => `<a class="btn btn-secondary" href="/category/${category.code ?? ''}">${category.name}</a>`).join(''),
            )
        ;
    }
})();
