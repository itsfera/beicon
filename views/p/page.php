<?

$title = 'BeIcon – события, мода, красота, путешествие, стиль жизни, рестораны';
$description = 'BeIcon.ru – сайт о моде, красоте, стиле жизни и культурных событиях Москвы. Самые актуальные репортажи со всех знаковых культурных мероприятий столицы. Лучшие модные обзоры. Экспертные комментарии в области красоты и здоровья. Самые интересные направления для путешествий. Ресторанные новости.';

$this->title = $title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $description
]);


?>
<main class="main-content page-wrapper ">
    <div class="bl-wrapper">
        <div class="error-logo-wrapper">
            <a href="/"><img src="/img/assets/logo.svg" width="175" height="59" alt="Be-icon logo"></a>
        </div>
        <div class="error-type">
            <?= $page->content ?>
        </div>
    </div>
</main>