<?php

use yii\helpers\Json;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Socials;


if ($article["header_img"]) {

    if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $article["header_img"]))
        $socialImage = UPLOAD_DIR . $article["header_img"];

} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $article["preview_img"]))
        $socialImage = UPLOAD_DIR . $article["preview_img"];

} ?>

<script>

	// Функция для разбора урла
	function getUrlVars() {
		return window.location.href.slice(window.location.href.indexOf('?')).split(/[&?]{1}[\w\d]+=/);
	}
</script>

<div class="article-ajax-wraper" data-id="/<?= $article->sectionData->url . '/' . $article["url"] ?>">
    <!-- Start Articles top filter -->
    <div class="articles-filter content-wrapper">
        <ul class="articles-filter__list">
            <li class="articles-filter__item article__date">
                <time datetime="2018-04-12"><? if ($article["date_publish"] != '0000-00-00 00:00:00') { ?><?= date('d.m.Y', strtotime($article["date_publish"])) ?><? } ?></time>
            </li>

            <li class="articles-filter__item article__tag">
                <? if ($article["other_author"]) { ?>
                    <?= $article["other_author"] ?>
                <? } else {


                    $author = $article->getPublisher()->One();
                    if ($author["id"] != 1) {
                        ?><?= $author["name"] ?><? }
                } ?>
            </li>

            <li class="articles-filter__item article__tag"><a
                        href="<?= Url::to(['sections/view/', 'url' => $section["url"]]) ?>"><?= $section["name"] ?></a>
            </li>

        </ul>
    </div>
    <!-- End Articles top filter -->

    <!-- Start Article -->
    <article
            class="article content-wrapper clearfix <? if ($article["view_type"] == 'gallery-one-column') echo 'galery-one-column'; ?>">
        <div class="article-wrapper clearfix">

            <!-- Start Article announce -->
            <div class="article-announce clearfix">

                <h1><?= $article->oldAttributes["name"] ?></h1>
                <div class="article__keywords">
                    <? foreach ($article->tags as $tag) { ?>

                        <a href="<?= Url::to(['tags/view/', 'url' => $tag["url"]]) ?>"><?= $tag->name ?></a>
                    <? } ?>


                </div>
                <div class="left-block">
                    <!-- Add the .added class if the Article was added in Favorites articles list. And remove .added if the article was removed from the favorites list -->
                    <a id="fav"
                       rel="sidebar"
                       href=""
                       title="<?= $article['name'] ?>"
                       onclick="addFav();return false"
                       class="link article__favorites AddFavViaSheens">
                        <svg class="inline-svg fav-article-svg">
                            <use xlink:href="#favArticle"></use>
                        </svg>
                    </a>
                    <div class="social-share__list_top">
                        <?
                        $socials = Socials::find()->orderBy(['sort' => SORT_ASC])->all();

                        foreach ($socials as $social) {

                            if ($social["href"] == '#' || !$social["href"]) continue;
                            ?>
                            <a class="social-login__item" href="<?= $social["href"] ?>" target="_blank">
                                <svg class="inline-svg social-svg">
                                    <use xlink:href="#<?= $social["name"] ?>"></use>
                                </svg>
                            </a>
                        <? } ?>
                    </div>
                    <? if ($article["views"] >= 5000) { ?>
                        <div class="article__views">
                        <svg class="inline-svg views__icon">
                            <use xlink:href="#visibility"></use>
                        </svg>
                        <span class="views__num"><?= $article["views"] ?></span></div><? } ?>
                </div>

                <div class="article__announce-wrapper <? if ($article["view_type"] == 'article' || $article["view_type"] == 'gallery-only') echo 'col_c'; ?>">
                    <? if ($article["preview_img"] != '' || $article["header_img"] != '') { ?>
                        <div class="article__announce-image">

                        <? $imgSrc = false;
                        if ($article["header_img"]) {

                            if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $article["header_img"]))
                                $imgSrc = UPLOAD_DIR . $article["header_img"];

                        } else {
                            if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $article["preview_img"]))
                                $imgSrc = UPLOAD_DIR . $article["preview_img"];

                        } ?>
                        <a href="<?= $imgSrc ?>" class="lightbox-lnk">

                            <img itemprop="image" src="<?= $imgSrc ?>" alt="<?= $article['name'] ?>"
                                 title="<?= $article['name'] ?>">
                        </a>
                        </div><? } ?>

                    <p><?= $article["preview_content"] ?></p>
                </div>

                <? if ($article["view_type"] == 'article' || $article["view_type"] == 'gallery-only') { ?>
                    <div class="banner-240-400-wrapper col_r">
                        <div class="bl-wrapper">
                            <div class="banner-240-400">
                                <a href="https://www.instagram.com/beicon.ru/" target="_blank">
                                    <div class="banner-240-400__inner"
                                         style="background-image: url('/basic/web/img/banner-240-400.jpg')"></div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Add class .sponsor_format-1 or .sponsor_format-2 to show sponsor block in format you need -->
                    <div class="sponsor sponsor_format-1 col_r">
                        <div class="bl-wrapper">
                            <!-- Start Sponsor Block Format 1 -->
                            <!--                        <div class="sponsor_inner">-->
                            <!--                            <div class="sponsor__text">-->
                            <!--                                <p class="sponsor__text_main">При поддержке Vichy</p>-->
                            <!--                            </div>-->
                            <!--                            <div class="sponsor__img"><img src="/basic/web/img/sponsor-img-format-1.jpg" alt="" width="216" height="79"></div>-->
                            <!--                        </div>-->
                            <!-- End Sponsor Block Format 1 -->

                            <!-- Start Sponsor Block Format 2 -->
                            <!--<div class="sponsor_inner">
                                <div class="sponsor__text">
                                    <p class="sponsor__text_main">Евгений Федько</p>
                                    <p class="sponsor__text_add">Ювелир, основатель ювелирного бренда E. Fedko</p>
                                </div>
                                <div class="sponsor__img"><img src="img/sponsor-img-format-2.jpg" alt="" width="80" height="80"></div>
                            </div>-->
                            <!-- End Sponsor Block Format 2 -->
                        </div>
                    </div>
                <? } ?>
            </div>
            <!-- End Article announce -->

            <? if ($article["view_type"] != 'gallery-only' && $article["view_type"] != 'gallery-only-one-column') { ?>

                <!-- Start Article Body -->
                <div class="article-body <? if (($article["view_type"] == 'article' || $article["view_type"] == 'gallery-only') && ((int)$article["section"] != 5)) echo 'col_c'; ?>">
                    <?
                    //echo '<pre>', print_r($article, true), '</pre>';
                    ?>

                    <?= $article["content"] ?>

                    <? if ($article["other_source"]) { ?>
                        <p style="margin: 0 0 10px;"><strong>Источник:</strong> <?= $article["other_source"] ?></p>
                    <? } ?>
                    <? if ($article["photographer"]) { ?>
                        <p style="margin: 0 0 10px;"><strong>Фотограф:</strong> <?= $article["photographer"] ?></p>
                    <? } ?>
                    <? if ($article["other_author"]) { ?>
                        <p style="margin: 0 0 10px;"><strong>Автор:</strong> <?= $article["other_author"] ?></p>
                    <? } else {
                        $author = $article->getPublisher()->One();
//                    print_r($author);

                        if ($author["id"] != 1) {
                            ?>

                            <p style="margin: 0 0 10px;"><strong>Автор:</strong> <?= $author["name"] ?></p>

                        <? } ?>

                    <? } ?>


                    <!-- Start Recommendation Rich Block -->

                    <!-- End Recommendation Rich Block -->


                    <!-- Start Recommendation Block -->

                    <!-- End Recommendation Block -->

                    <!-- Start Inline-Banner -->

                    <!-- End Inline Banner -->


                    <div class="article__keywords article__keywords_bottom">  <? foreach ($article->tags as $tag) { ?>
                            <a href="<?= Url::to(['tags/view/', 'url' => $tag["url"]]) ?>"><?= $tag->name ?></a>
                        <? } ?></div>

                    <div class="share-block mobile-only">
                        <div class="share-block__inner">
                            <span class="share-block__shared">Поделись статьей</span>
                            <!--                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
                            <!--                <script src="//yastatic.net/share2/share.js"></script>-->
                            <!--                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-bare="false"></div>-->
                            <div class="social-share__list_bottom">

                                <a class="social-login__item fb-share-button"
                                   href="https://www.facebook.com/sharer.php?src=sp&u=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                                   rel="nofollow ">
                                    <svg class="inline-svg social-svg">
                                        <use xlink:href="#fb"></use>
                                    </svg>
                                </a>
                                <a class="social-login__item"
                                   href="https://vk.com/share.php?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                                   rel="nofollow ">
                                    <svg class="inline-svg social-svg">
                                        <use xlink:href="#vk"></use>
                                    </svg>
                                </a>
                                <a class="social-login__item"
                                   href="https://twitter.com/intent/tweet?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&text=<?= $article["name"] ?>&utm_source=share2"
                                   rel="nofollow ">
                                    <svg class="inline-svg social-svg">
                                        <use xlink:href="#twitter"></use>
                                    </svg>
                                </a>
                                <a class="social-login__item"
                                   href="https://connect.ok.ru/offer?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                                   rel="nofollow ">
                                    <svg class="inline-svg social-svg">
                                        <use xlink:href="#ok"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>


            <? } ?>
            <!-- End Article Body -->

            <? if ($article["view_type"] == 'article' && (int)$article["section"] != 5) { ?>
            <!-- Start Right Column -->
            <aside class="right-column col_r">
                <? if ($not_miss) { ?>
                    <div class="related-articles">
                        <div class="bl-wrapper">
                            <div class="related-article__inner">

                                <h2>Не пропустите</h2>

                                <? foreach ($not_miss as $art) { ?>
                                    <article class="article__teaser_small el-wrapper clearfix">
                                        <a href="<?= Url::to(['articles/view', 'url' => $art["url"], 'section' => $art->sectionData->url]) ?>">
                                            <div class="article__teaser__image-container">
                                                <div class="article-overlay"></div>
                                                <? if ($art["preview_img"] != '' || $art["header_img"] != '') { ?><img
                                                    src="<? if ($art["preview_img"]) echo '/uploads/' . $art["preview_img"]; else echo '/uploads/' . $art["header_img"]; ?>"
                                                    width="80" height="80" alt="<?= $art["name"] ?>"
                                                    title="<?= $art["name"] ?>"><? } ?></div>
                                            <div class="article__teaser__wrapper">
                                                <h3><?= $art["name"] ?></h3>
                                                <div class="article__teaser__info">
                                                    <div class="article__teaser__date"><? if ($art["date_publish"] != '0000-00-00 00:00:00') { ?><?= date('d.m.Y', strtotime($art["date_publish"])) ?><? } ?></div>
                                                    <? if ($art["views"] >= 5000) { ?>
                                                        <div class="article__teaser__views"><span
                                                                class="views__num"><?= $art["views"] ?></span>
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
                    </div>

                <? } ?>
                <div class="banner-240-400-wrapper">
                    <div class="bl-wrapper">
                        <div class="banner-240-400">
                            <a href="https://www.instagram.com/beicon.ru/" target="_blank">
                                <div class="banner-240-400__inner"
                                     style="background-image: url('/basic/web/img/banner-240-400.jpg')"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Асинхронный код информера news.gnezdo.ru -->
                    <div id="gnezdo_ru_18690">Загрузка...</div>
                    <script language='JavaScript'>
						var s = document.createElement("script"),
							f = function () {
								document.getElementsByTagName("head")[0].appendChild(s);
							};
						s.type = "text/javascript";
						s.async = true;
						s.src = 'https://news.gnezdo.ru/show/18690/block_a.js';
						if (window.opera == "[object Opera]") {
							document.addEventListener("DOMContentLoaded", f);
						} else {
							f();
						}
                    </script>
                    <!-- Конец кода информера news.gnezdo.ru -->
                </div>
            </aside>
            <!-- End Right Column -->
        </div>
        <? } ?>

        <!--<div class="article__keywords article__keywords_bottom"><a href="#">ММКФ</a><a href="#">Звезды</a><a href="#">Кино</a><a href="#">Серебряников</a></div>-->
        <div class="share-block mobile-hide">
            <div class="share-block__inner">
                <span class="share-block__shared">Поделись статьей</span>
                <!--                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
                <!--                <script src="//yastatic.net/share2/share.js"></script>-->
                <!--                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-bare="false"></div>-->
                <div class="social-share__list_bottom">

                    <a class="social-login__item fb-share-button"
                       href="https://www.facebook.com/sharer.php?src=sp&u=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                       rel="nofollow ">
                        <svg class="inline-svg social-svg">
                            <use xlink:href="#fb"></use>
                        </svg>
                    </a>
                    <a class="social-login__item"
                       href="https://vk.com/share.php?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                       rel="nofollow ">
                        <svg class="inline-svg social-svg">
                            <use xlink:href="#vk"></use>
                        </svg>
                    </a>
                    <a class="social-login__item"
                       href="https://twitter.com/intent/tweet?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&text=<?= $article["name"] ?>&utm_source=share2"
                       rel="nofollow ">
                        <svg class="inline-svg social-svg">
                            <use xlink:href="#twitter"></use>
                        </svg>
                    </a>
                    <a class="social-login__item"
                       href="https://connect.ok.ru/offer?url=<?= Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true) ?>&title=<?= $article["name"] ?>&utm_source=share2"
                       rel="nofollow ">
                        <svg class="inline-svg social-svg">
                            <use xlink:href="#ok"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </article>
    <!-- End Article -->

    <?php

    echo \app\widgets\Subscribe::widget();
    ?>


    <? if ($recomended) { ?>
        <!-- Start Editor's choice articles Section -->
        <section class="e-ch-articles-section">
            <h2>Рекомендуем</h2>
            <div class="recommend-slider swiper-container swiper-container-horizontal swiper-container-free-mode">
                <ul class="e-ch-articles__list swiper-wrapper" style="">

                    <? foreach ($recomended as $recItem) { ?>
                        <li class="article__item swiper-slide" style="">
                            <a href="<?= Url::to(['articles/view/', 'url' => $recItem["url"], 'section' => $recItem->sectionData->url]) ?>">
                                <div class="article__teaser_half">
                                    <div class="image-container">
                                        <? if ($recItem["preview_img"] != '' || $recItem["header_img"] != '') { ?>
                                            <img src="<? if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $recItem["header_img"])) {
                                                echo UPLOAD_DIR . $recItem["header_img"];
                                            } elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $recItem["preview_img"])) echo UPLOAD_DIR . $recItem["preview_img"]; ?>"
                                                 alt="<?= $recItem["name"] ?>" title="<?= $recItem["name"] ?>">
                                        <? } ?>
                                    </div>


                                    <div class="info-wrapper">
                                        <h3><?= $recItem["name"] ?></h3>
                                        <div class="article__teaser__info clearfix">
                                            <div class="article__teaser__date"><? if ($recItem["date_publish"] != '0000-00-00 00:00:00') { ?><?= date('d.m.Y', strtotime($recItem["date_publish"])) ?><? } ?></div>
                                            <? if ($recItem["views"] >= 5000) { ?>
                                                <div class="article__teaser__views"><span
                                                        class="views__num"><?= $recItem["views"] ?></span>
                                                <svg class="inline-svg views__icon">
                                                    <use xlink:href="#visibility"></use>
                                                </svg></div><? } ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <? } ?>
                </ul>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </section>
        <!-- End Editor's choice articles -->
    <? } ?>
    <!-- Start Next Article Progress-bar -->
    <!-- Call 'articleProgress(percent)' function to set the percent value for the progress-bar -->

    <? if ($topic) { ?>

        <div class="article-progress"
             style="background: linear-gradient(to right, rgb(179, 161, 112) 35%, rgba(234, 203, 198, 0.3) 0%);">
            <span class="article-progress-bar"><a
                        href="<?= Url::to(['articles/view', 'url' => $topic["url"], 'section' => $topic->sectionData->url]) ?>"><?= $topic["name"] ?></a> </span>
        </div>

    <? } ?>
    <!-- End Next Article Progress-bar -->
</div>
<?php

$nextArticleUrl = $article->getNext();

if ($nextArticleUrl) {
    ?>

    <? if (!isset($preview) || $preview != 'y') { ?>

        <script>

			var loading = false;
			var menu_selector = ".article-ajax-wraper"; // Переменная должна содержать название класса или идентификатора, обертки нашего меню.
			function onScroll() {

				var get = getUrlVars;
				//console.log(get);

				if (!get["gallery"]) {

					var scroll_top = $(document).scrollTop();
					$(menu_selector).each(function () {
						var url = $(this).data('id');
						var target = $(this);
						if (target.position().top <= scroll_top + ($(window).height() - 500) && target.position().top + target.outerHeight() > scroll_top + ($(window).height() - 500) && !loading) {

							//console.log(url);
							// console.log(window.history.state);
							if (window.history.state !== url) {
								// console.error(url);
								// console.error(window.history.state);
								window.history.replaceState(url, "Title", url);

							}

						}
					});
				}
			}

			$(function () {


				$(document).on("scroll", onScroll);
				var article<?=$article["id"]?> = false;
				$(window).scroll(function () {
					if (!article<?=$article["id"]?>) {
						if ($(window).scrollTop() + ($(window).height() * 2) >= ($(document).height() - 500) && !loading) {
							loading = true;
							$('.main-content.page-wrapper').eq(0).append('<div id="loader"><img src="/basic/web/img/loader.gif"></div>');
							article<?=$article["id"]?> = true;
							$.ajax({
								type: 'get',
								url: '<?=$nextArticleUrl?>',
								dataType: 'html',
								success: function (res) {
									// console.log(res);
									loading = false;
									$('#loader').remove();
									$('.main-content.page-wrapper').eq(0).append(res);


								}
							})

						}
					}
				});
			});
        </script>

    <? } ?>
<? } ?>


<script>
	$(document).ready(function () {
		initSimpleSlider('.simple-slider', 30, 16, 16, 8, 8);
		initSimpleSlider('.recommend-slider', 16, 16, 16, 12, 12);
		initSimpleSlider('.custom-slider', 16, 16, 16, 12, 12, false);
		initRichSlider(48);

		// Call 'articleProgress(percent)' function to set the percent value for the progress-bar
		articleProgress(35);

		var imgs = $('.article-body img').not(".ignore");
		imgs.each(function () {

			// if img is not gallery
			if ($(this).closest('.gallery-tile').length < 1 && $(this).closest('.gallery-mosaic').length < 1) {
				var url = $(this).attr('src');
				$(this).wrap('<a class="lightbox-lnk" href="' + url + '"></a>');
			}
		});

		$('a.lightbox-lnk').magnificPopup({
			type: 'image'
			// other options
		});
	})

</script>

<script>
	$(function () {
		initGalleryFullscreen('.gallery-tile', '.gallery-tile-prev', '.gallery-tile-prev__item', '.gallery-fullscreen');
	});
</script>

<script>
	$(function () {
		$('.social-share__list_bottom a').click(function (e) {
			e.preventDefault();
			let href = $(this).attr('href');
			window.open(href, "Поделиться", "width=450, height=450, top=auto, left=auto");
			return false;
		});
	});


</script>
<? if (!isset($ajax)) { ?>
    <style>
        .gallery-fullscreen__inner .gallery-fullscreen__image-container img {
            margin: auto;
        }

        .gallery-fullscreen__inner .gallery-fullscreen__image-container {
            /*display: flex;*/
            /*align-content: center;*/
        }
    </style>

    <?php

    $this->registerJsFile('/js/jquery.magnific-popup.min.js', ['position' => yii\web\View::POS_HEAD]);
    $this->registerCssFile('/css/magnific-popup.css');
    ?>
<? } ?>


<? if (isset($_REQUEST["gallery"]) && isset($_REQUEST["item"])) { ?>
    <script>
		$(function () {
			$('[data-gallery=<?=$_REQUEST["gallery"]?>]').eq(<?=$_REQUEST["item"]?>).click();
		});
    </script>
<? } ?>


