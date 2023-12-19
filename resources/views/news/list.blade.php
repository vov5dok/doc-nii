@extends('layouts.app')

@section('content')
    <div class="board">
        <h1 class="page-title">Новости</h1>
        <div class="news-list">
            <div class="news__item">
                <!-- Ваш код для отображения новости -->
            </div>
        </div>
        <div id="load-more-wrapper">
            @if($posts->hasMorePages())
                <div class="section-button mb-4">
                    <a id="load-next-page"
                       data-page-url="{{ url('api/new-page') }}?page={{ $posts->currentPage() + 1 }}"
                       data-page="{{ $posts->currentPage() + 1 }}"
                       class="btn">Показать еще {{ $posts->count() }}</a>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            const loadNextPageButton = document.querySelector('#load-next-page');
            const container = document.querySelector('.board');
            const loadMoreWrapper = document.querySelector('#load-more-wrapper');
            let currentPage = {{ $posts->currentPage() + 1 }};
            let isFirstPageLoaded = false;

            loadNextPageButton.addEventListener('click', function () {
                const url = loadNextPageButton.dataset.pageUrl;
                const nextPage = parseInt(loadNextPageButton.dataset.page);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const newItems = data.data.map(post => {
                            // Преобразуем строку даты в объект Date
                            const date = new Date(post.created_at);

                            // Форматируем дату с помощью метода toLocaleDateString
                            const formattedDate = date.toLocaleDateString('ru-RU', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });

                            const item = document.createElement('div');
                            item.classList.add('news__item');
                            item.innerHTML = `
                <a href="/news/${post.slug}" class="news-card">
                    <div class="card-image">
                        <img src="/storage/${post.image}" alt="${post.name}">
                    </div>
                    <div class="card-body">
                        <div class="news-body">
                            <h4 class="card-title">${post.name}</h4>
                            <div class="card-text">${post.preview}</div>
                        </div>
                        <div class="news-footer">
                            <time class="news-date">${formattedDate}</time>
                            <div class="news-views">${post.counter}</div>
                        </div>
                    </div>
                </a>`;
                            return item;
                        });

                        newItems.forEach(item => container.appendChild(item));

                        if (data.next_page_url) {
                            // Обновляем URL курсора и номер следующей страницы
                            loadNextPageButton.dataset.pageUrl = data.next_page_url;
                            loadNextPageButton.dataset.page = nextPage + 1;
                            currentPage = nextPage;
                        } else {
                            // Удаляем кнопку "Показать еще", если больше нет страниц
                            loadNextPageButton.remove();
                        }

                        // Перемещаем кнопку после всех подгруженных элементов
                        container.appendChild(loadMoreWrapper);

                        // Скроллим к кнопке "Показать еще", если это не первая подгрузка данных
                        if (isFirstPageLoaded) {
                            window.scrollTo({
                                top: loadMoreWrapper.offsetTop - 50,
                                behavior: 'smooth'
                            });
                        } else {
                            isFirstPageLoaded = true;
                        }
                    })
                    .catch(error => console.error(error));
            });

            // Запускаем код подгрузки новых данных после загрузки страницы
            window.addEventListener('load', function () {
                loadNextPageButton.click();
            });
        </script>
    @endpush

@endsection
