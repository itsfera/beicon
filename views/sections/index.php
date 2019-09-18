<?php

use yii\helpers\Url;
use app\models\ImageSizes;

?>
<? if (!$ajax) { ?>
    <section class="catalog-section">
    <h1><?= $section["name"] ?></h1>

    <script>
		var page = 1;
		var loading = false;
		$(function () {


            <? if(isset($_GET["page"])) { ?>
			page = <?=$_GET["page"]; ?>;
            <? } ?>

			$(window).scroll(function () {
				if ($(window).scrollTop() + ($(window).height() + 50) >= $(document).height() && !loading && page < <?=$limit?>) {
					console.log('page - ' + page);
					console.log('Подгрузка страницы ' + page);
					loading = true;
					$('.catalog-section').eq(0).append('<div id="loader"><img src="/basic/web/img/loader.gif"></div>');
					$.ajax({
						type: 'get',
						url: '/<?=$section["url"]?>?page=' + (page + 1),
						dataType: 'html',
						success: function (res) {
							loading = false;

							console.log('Успешная подгрузка страницы ' + page);
							// console.log(res);
							$('#loader').remove();
							$('.catalog-section').eq(0).append(res);
							window.history.replaceState("object or string", "Title", '/<?=$section["url"]?>?page=' + page);
							page = page + 1;
						},
						error: function (res) {
							$('.catalog-section').eq(0).append('<h1>Ошибка загрузки данных.</h1>');

							console.log('Ошибка');
							console.log(res);
						}
					})
				}
			});

		});
    </script>

<? } ?>

    <!-- Start Articles Block view 4 -->
    <div class="articles-block articles-block_v4 bl-wrapper">
        <?php
        $n = 0;
        foreach ($articles as $k => $article) { ?>


            <article class="article__item article__teaser_vertical <? if ($n == 0) { ?>x2<? } ?> el-wrapper clearfix">
                <a href="<?= Url::to(['articles/view', 'url' => strtolower($article["url"]), 'section' => $article->sectionData->url]) ?>">
                    <div class="article-overlay"></div>
                    <img src="<? if ($article["preview_img"]) {
                        if ($n == 0) {
                            if ($article["preview_img"])
                                echo UPLOAD_DIR . ImageSizes::getResizesName($article["preview_img"], '16_9_1040');
                        } else {
                            if ($article["preview_img"])
                                echo UPLOAD_DIR . ImageSizes::getResizesName($article["preview_img"], '1_1_690');
                        }
                    } else {
                        if ($n == 0) {
                            if ($article["header_img"])
                                echo UPLOAD_DIR . ImageSizes::getResizesName($article["header_img"], '16_9_1040');
                        } else {
                            if ($article["header_img"])
                                echo UPLOAD_DIR . ImageSizes::getResizesName($article["header_img"], '1_1_690');
                        }
                    } ?>" width="" height="" alt="<?= $article["name"] ?>" title="<?= $article["name"] ?>"
                         class="article-img-full">

                    <img class="article-img-small" alt="<?= $article["name"] ?>" title="<?= $article["name"] ?>"
                         src="<? if ($article["preview_img"]) {


                             echo UPLOAD_DIR . ImageSizes::getResizesName($article["preview_img"], '16_9_1040');


                         } else {


                             echo UPLOAD_DIR . ImageSizes::getResizesName($article["header_img"], '16_9_1040');

                         } ?>">


                    <div class="article-overlay_bottom">
                        <div class="h3"><?= $article["name"] ?></div>
                        <div class="article__teaser__info">
                            <? if ($article["date_publish"] != '0000-00-00 00:00:00') { ?>
                                <div class="article__teaser__date"><?= date('d.m.Y', strtotime($article["date_publish"])) ?></div><? } ?>

                            <? if ($article["views"] >= 5000) { ?>
                                <div class="article__teaser__views"><span
                                        class="views__num"><?= $article["views"] ?></span>
                                <svg class="inline-svg views__icon">
                                    <use xlink:href="#visibility"></use>
                                </svg></div><? } ?>
                        </div>
                    </div>
                </a>
            </article>
            <? $n++;
            unset($articles[$k]);
            if ($n == 7) break;
        } ?>

        <!--        <div class="banner-240-400">-->
        <!--            <a href="#" target="_blank"><div class="banner-240-400__inner" style="background-image: url('/basic/web/img/banner-240-400.jpg')"></div></a>-->
        <!--        </div>-->
    </div>
    <!-- End Articles Block view 4 -->

    <!-- Start Inline-Banner -->
    <div class="inline-banner bl-wrapper">
        <div class="el-wrapper">
            <a href="#" target="_blank">
                <!-- Add background-image for banne and background-color for banner-wrapper -->
                <div class="inline-banner__inner" style=" background-color: #eeedf2"></div>
            </a>
        </div>
    </div>
    <!-- End Inline Banner -->


    <div class="top-articles articles-block articles-block_v5 bl-wrapper">
        <div class="el-wrapper">
            <? if ($topic) {

                $topicImg = $topic->header_img;
                if ($topicImg == '') $topicImg = $topic->preview_img;
                $img = ImageSizes::getResizesName($topicImg, '16_9_1040');

                $bg2 = ImageSizes::getResizesName($topicImg, '9_16_352');
                ?>
            <? } ?>
            <!-- Background Image has to added as a style by script -->
            <div class="top-articles__bg" style="background-image: url('/uploads/<?= $img ?>')"></div>
            <div class="top-articles__bg top-articles__bg-mobile"
                 style="background-image: url('/uploads/<?= $bg2 ?>')"></div>
            <div class="article-overlay"></div>
            <div class="top-articles-wrapper">

                <div class="h2">
                    <a href="<?= Url::to(['articles/view', 'url' => strtolower($topic["url"]), 'section' => $topic->sectionData->url]) ?>"><?= $topic["name"] ?></a>
                </div>

                <div class="top-articles__list bl-wrapper">
                    <?php
                    $n = 1;
                    foreach ($articles as $k => $article) {

                        ?>
                        <article class="top-article__item">
                            <div class="h3">
                                <a href="<?= Url::to(['articles/view', 'url' => strtolower($article["url"]), 'section' => $article->sectionData->url]) ?>"><?= $article["name"] ?></a>
                            </div>
                            <div class="article__teaser__info clearfix">
                                <? if ($article["date_publish"] != '0000-00-00 00:00:00') { ?>
                                    <div class="article__teaser__date"><?= date('d.m.Y', strtotime($article["date_publish"])) ?></div><? } ?>
                                <? if ($article["views"] >= 5000) { ?>
                                    <div class="article__teaser__views"><span
                                            class="views__num"><?= $article["views"] ?></span>
                                    <svg class="inline-svg views__icon">
                                        <use xlink:href="#visibility"></use>
                                    </svg></div><? } ?>
                            </div>
                        </article>
                        <? unset($articles[$k]);
                        $n++;
                        if ($n == 4) break;
                    } ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Start Articles Block Type 6 -->
    <div class="articles-block articles-block_v6 bl-wrapper">
        <div class="article-list">
            <? foreach ($articles as $article) {
                $img = ImageSizes::getResizesName($article->preview_img, 'mini');
                ?>
                <article class="article__teaser_small el-wrapper clearfix">
                    <a href="<?= Url::to(['articles/view', 'url' => strtolower($article["url"]), 'section' => $article->sectionData->url]) ?>">
                        <div class="article__teaser__image-container">
                            <div class="article-overlay"></div>
                            <img src="/uploads/<?= $img ?>" width="80" height="80" alt="<?= $article["name"] ?>"
                                 title="<?= $article["name"] ?>"></div>
                        <div class="article__teaser__wrapper">
                            <div class="h3"><?= $article["name"] ?></div>
                            <div class="article__teaser__info">
                                <? if ($article["date_publish"] != '0000-00-00 00:00:00') { ?>
                                    <div class="article__teaser__date"><?= date('d.m.Y', strtotime($article["date_publish"])) ?></div><? } ?>

                                <? if ($article["views"] >= 5000) { ?>
                                    <div class="article__teaser__views"><span
                                            class="views__num"><?= $article["views"] ?></span>
                                    <svg class="inline-svg views__icon">
                                        <use xlink:href="#visibility"></use>
                                    </svg></div><? } ?>
                            </div>
                        </div>
                    </a>
                </article>
            <? } ?>
        </div>
    </div>
    <!-- End Articles Block view 6 -->

<? if (!$ajax) { ?>
    </section>

<? } ?>