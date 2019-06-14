<?php
use app\models\Sections;
use yii\helpers\Url;

$this->title = 'Поиск на Be Icon: '.$query;
?>

<div class="content-wrapper">
<h1 style="margin-top: 30px">Результаты поиска</h1>

<!-- Start Search form -->
<form name="search" id="searchForm" action="/search/" method="get" class="search-form">
    <div class="fields-wrapper">
        <input type="text" id="searchRequest" name="query" placeholder="Поиск" value="<?=$query?>" autofocus>
        <button type="submit" id="searchRequestSubmit" name="searchRequestSubmit"><svg class="inline-svg search-icon-dark"><use xlink:href="#searchDark"></use></svg></button>
    </div>
</form>
<!-- End Search form -->

<!-- Start Search results -->
<div class="search-results-block">
    <div class="articles__list_simple">
        <? foreach ($result as $item) {

            $section = Sections::findOne($item["section"]);

            $article = $item; ?>
        <article class="article__item clearfix">
            <div class="article__teaser__image-container">
                <? if($article["preview_img"] != '' || $article["header_img"] != ''){ ?>
                <img src="<? if($article["header_img"]) {

                        echo UPLOAD_DIR.$article["header_img"];
                } else {

                        echo UPLOAD_DIR.$article["preview_img"];
                } ?>">
                <? } ?>
            </div>
            <div class="article__teaser__wrapper">
                <h3><a href="<?=Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url])?>"><?=$item["name"]?></a></h3>
                <div class="tags">
                    <ul class="tags__list">
                        <li class="tags__item"><a href="<?=Url::to(['sections/view', 'url' => $section["url"]])?>"><?=$section["name"]?></a></li>
                    </ul>
                </div>
                <div class="article__teaser__info">
                    <div class="article__teaser__date"><? if($article["date_publish"] != '0000-00-00 00:00:00') { ?><?=date('d.m.Y', strtotime($article["date_publish"]))?><? } ?></div>
                    <div class="article__teaser__views">

                        <? if($item["views"] > 5000) { ?>

                        <span class="views__num"><?=$item["views"]?></span><svg class="inline-svg views__icon"><use xlink:href="#visibility"></use></svg>

                        <? } ?>

                    </div>
                </div>
            </div>
        </article>
        <? } ?>
    </div>
</div>
<!-- End Search results -->
</div>