<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error-wrapper">
    <div class="error-logo-wrapper">
        <a href="/"><img src="/img/assets/logo.svg" width="175" height="59" alt="Be-icon logo"></a>
    </div>
    <div class="error-type">
        <div class="error-type__img error-type__img_404"></div>
        <h3>Cтраница не найдена</h3>
        <p>К сожалению, страница, на которую вы пытались зайти, не существует.</p>
        <a href="/" class="error-wrapper__link">Вернуться на главную</a>
    </div>

    <div class="bottom-block">
        <p>Или воспользуйтесь поиском</p>
        <!-- Start Search form -->
        <form name="search" id="searchForm" action="#" method="get" class="search-form">
            <div class="fields-wrapper">
                <input type="text" id="searchRequest" name="searchRequest" placeholder="Поиск" value="" autofocus>
                <button type="submit" id="searchRequestSubmit" name="searchRequestSubmit"><svg class="inline-svg search-icon-dark"><use xlink:href="#searchDark"></use></svg></button>
            </div>
        </form>
        <!-- End Search form -->
    </div>
</div>
