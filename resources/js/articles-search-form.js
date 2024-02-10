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

        const query = $form.query.value.trim();
        const url = new URL(location.href);

        $form.query.value = query;

        if (query) {
            url.searchParams.set('query', query);
        } else {
            url.searchParams.delete('query');
        }

        history.replaceState({}, document.title, url);

        fetch('/api/articles/search', {
            method: 'POST',
            body: new FormData($form),
        })
            .then(res => res.json())
            .then(({ data }) => {
                $articlesList.innerHTML = data.map(renderArticle).join('');
            });
    });

    function renderArticle(article) {
        let original_url_host = '';

        try {
            original_url_host = article.original_url ? new URL(article.original_url).hostname.replace('www.', '') : '';
        } catch (e) {
            console.error(e);
        }

        return $articlesTemplate.innerHTML
            .replaceAll('{id}', article.id)
            .replaceAll('{code}', article.code)
            .replaceAll('{title}', article.title)
            .replaceAll('{original_url}', article.original_url)
            .replaceAll('{original_url_host}', original_url_host)
            .replaceAll('{image}', article.image || '/img/no-preview.jpeg')
            .replaceAll('{preview}', article.preview)
            .replaceAll(
                '{categories}',
                article.categories.map(category => `<span class="btn btn-secondary">${category.name}</span>`).join(''),
            )
            ;
    }
})();
