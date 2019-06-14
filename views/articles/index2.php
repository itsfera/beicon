<?php

use yii\helpers\Url;
use app\models\Socials;

?>
    <!-- Start Articles top filter -->
    <div class="articles-filter content-wrapper">
        <ul class="articles-filter__list">
            <li class="articles-filter__item article__date"><time datetime="2018-04-12"><? if($article["date_publish"] != '0000-00-00 00:00:00') { ?><?=date('d.m.Y', strtotime($article["date_publish"]))?><? } ?></time></li>

            <li class="articles-filter__item article__tag">
                <? if($article["other_author"]) {?>
                    <?=$article["other_author"]?>
                <? } else {
                    $author = $article->getPublisher()->One();

                    ?>

                    <?=$author["name"]?>

                <? } ?>
            </li>

            <li class="articles-filter__item article__tag"><a href="<?=Url::to(['sections/view/', 'url' => $section["url"]])?>"><?=$section["name"]?></a></li>

        </ul>
    </div>
    <!-- End Articles top filter -->

    <!-- Start Article -->
    <article class="article content-wrapper clearfix">
        <div class="article-wrapper clearfix">

            <!-- Start Article announce -->
            <div class="article-announce clearfix">
                <h1><?=$article["name"]?></h1>
                <div class="article__keywords">
                    <? foreach ($article->tags as $tag){ ?>

                        <a href="<?=Url::to(['tags/view/', 'url' => $tag["url"]])?>"><?=$tag->name?></a>
                    <? } ?>




                </div>
                <div class="left-block">
                    <!-- Add the .added class if the Article was added in Favorites articles list. And remove .added if the article was removed from the favorites list -->
                    <button class="article__favorites added"><svg class="inline-svg fav-article-svg"><use xlink:href="#favArticle"></use></svg></button>
                    <div class="social-share__list_top">
                        <?
                        $socials = Socials::find()->orderBy(['sort' => SORT_ASC])->all();

                        foreach ($socials as $social) {
                            ?>
                            <a class="social-login__item" href="<?=$social["href"]?>" target="_blank"><svg class="inline-svg social-svg"><use xlink:href="#<?=$social["name"]?>"></use></svg></a>
                        <? } ?>
                    </div>
                    <? if($article["views"] >= 5000) { ?><div class="article__views"><svg class="inline-svg views__icon"><use xlink:href="#visibility"></use></svg><span class="views__num"><?=$article["views"]?></span></div><? }?>
                </div>

                <div class="article__announce-wrapper col_c">
                    <div class="article__announce-image">               <? if($article["preview_img"] != '' || $article["header_img"] != ''){ ?>
                            <img src="<? if($article["header_img"]) {

                                if(file_exists($_SERVER["DOCUMENT_ROOT"].UPLOAD_DIR.$article["header_img"]))
                                    echo UPLOAD_DIR.$article["header_img"];

                            } else {
                                if(file_exists($_SERVER["DOCUMENT_ROOT"].UPLOAD_DIR.$article["preview_img"]))
                                    echo UPLOAD_DIR.$article["preview_img"];

                            } ?>" alt="" width="399" height="600"><? } ?></div>

                    <?=$article["preview_content"]?>
                </div>

            </div>
            <!-- End Article announce -->

            <!-- Start Article Body -->
            <div class="article-body col_c">
                <?=$article["content"]?>

                <? if($article["other_source"]){ ?>
                    <div><strong>Источник:</strong> <?=$article["other_source"]?></div>
                <? } ?>
                <? if($article["photographer"]){ ?>
                    <div><strong>Фотограф:</strong> <?=$article["photographer"]?></div>
                <? } ?>
                <? if($article["other_author"]) {?>
                    <div><strong>Автор:</strong> <?=$article["other_author"]?></div>
                <? } else {
                    $author = $article->getPublisher()->One();
//                    print_r($author);

                    if($author["id"] != 1){
                        ?>

                        <div><strong>Автор:</strong> <?=$author["name"]?></div>

                    <? } ?>

                <? } ?>

                <!-- Start Recommendation Rich Block -->

                <!-- End Recommendation Rich Block -->



                <!-- Start Recommendation Block -->

                <!-- End Recommendation Block -->

                <!-- Start Inline-Banner -->

                <!-- End Inline Banner -->


                <div class="article__keywords article__keywords_bottom">  <? foreach ($article->tags as $tag){ ?>
                        <a href="<?=Url::to(['tags/view/', 'url' => $tag["url"]])?>"><?=$tag->name?></a>
                    <? } ?></div>
            </div>
            <!-- End Article Body -->


        </div>

        <!--<div class="article__keywords article__keywords_bottom"><a href="#">ММКФ</a><a href="#">Звезды</a><a href="#">Кино</a><a href="#">Серебряников</a></div>-->
        <div class="share-block">
            <div class="share-block__inner">
                <span class="share-block__shared">Поделись статьей</span>
                <!--                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
                <!--                <script src="//yastatic.net/share2/share.js"></script>-->
                <!--                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-bare="false"></div>-->
                <div class="social-share__list_bottom">

                    <a class="social-login__item fb-share-button" href="https://www.facebook.com/sharer.php?src=sp&u=<?=Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true)?>&title=<?=$article["name"]?>&utm_source=share2" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#fb"></use></svg></a>
                    <a class="social-login__item" href="https://vk.com/share.php?url=<?=Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true)?>&title=<?=$article["name"]?>&utm_source=share2" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#vk"></use></svg></a>
                    <a class="social-login__item" href="https://twitter.com/intent/tweet?url=<?=Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true)?>&text=<?=$article["name"]?>&utm_source=share2" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#twitter"></use></svg></a>
                    <a class="social-login__item" href="https://connect.ok.ru/offer?url=<?=Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true)?>&title=<?=$article["name"]?>&utm_source=share2" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#ok"></use></svg></a>
                </div>
            </div>
        </div>
    </article>
    <!-- End Article -->

    <!-- Start Subscribe aside -->
    <aside class="subscribe-block bl-wrapper">
        <div class="el-wrapper">
            <div class="subscribe-block__wrapper">
                <div class="subscribe-block__col subscribe-block__col_l">
                    <h2>Не пропусти самые вкусные новости</h2>
                    <span class="subscribe-block__description">С нашей рассылкой не пропустишь</span>
                    <form name="subscribeForm" id="subscribeForm" action="#" method="post">
                        <div class="input-in-line">
                            <input type="email" id="userEmailSubscribe" class="" name="userEmailSubscribe" value="" placeholder="E-mail">
                            <button type="submit" class="btn" name="subscribeBtn">Подписаться</button>
                        </div>
                    </form>
                </div>
                <div class="subscribe-block__col subscribe-block__col_r">
                    <div class="subscribe-block__bg"></div>
                </div>
            </div>
        </div>
    </aside>
    <!-- End Subscribe aside -->


<? if($recomended) { ?>
    <!-- Start Editor's choice articles Section -->
    <section class="e-ch-articles-section">
        <h2>Рекомендуем</h2>
        <div class="recommend-slider swiper-container swiper-container-horizontal swiper-container-free-mode">
            <ul class="e-ch-articles__list swiper-wrapper" style="">

                <? foreach ($recomended as $recItem) { ?>
                    <li class="article__item swiper-slide" style="">
                        <a href="<?=Url::to(['articles/view/', 'url' => $recItem["url"], 'section' => $recItem->sectionData->url])?>">
                            <div class="article__teaser_half">
                                <div class="image-container">
                                    <? if($recItem["preview_img"] != '' || $recItem["header_img"] != ''){ ?>
                                        <img src="<? if($recItem["preview_img"]) {

                                            echo '/uploads/'.$recItem["preview_img"];

                                        } else echo '/uploads/'.$recItem["header_img"]; ?>" width="768" height="1200" alt="">
                                    <? } ?>
                                </div>

                                <div class="info-wrapper">
                                    <h3><?=$recItem["name"]?></h3>
                                    <div class="article__teaser__info clearfix">
                                        <div class="article__teaser__date"><? if($recItem["date_publish"] != '0000-00-00 00:00:00') { ?><?=date('d.m.Y', strtotime($recItem["date_publish"]))?><? } ?></div>
                                        <? if($recItem["views"] >= 5000) { ?> <div class="article__teaser__views"><span class="views__num"><?=$recItem["views"]?></span><svg class="inline-svg views__icon"><use xlink:href="#visibility"></use></svg></div><? } ?>
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

<? if($topic) { ?>

    <div class="article-progress" style="background: linear-gradient(to right, rgb(179, 161, 112) 35%, rgba(234, 203, 198, 0.3) 0%);">
        <span class="article-progress-bar"><a href="<?=Url::to(['articles/view', 'url' => $topic["url"], 'section' => $topic->sectionData->url])?>"><?=$topic["name"]?></a> </span>
    </div>

<? } ?>
    <!-- End Next Article Progress-bar -->

<?php

$nextArticleUrl = $article->getNext();

if($nextArticleUrl) {
    ?>

    <? if(!isset($preview) || $preview != 'y') { ?>

        <script>
            $(function () {
                var article<?=$article["id"]?> = false;
                $(window).scroll(function () {
                    if(!article<?=$article["id"]?>){
                        if($(window).scrollTop()+$(window).height()>=($(document).height()-500)){
                            article<?=$article["id"]?> = true;
                            $.ajax({
                                type: 'get',
                                url: '<?=$nextArticleUrl?>',
                                dataType: 'html',
                                success: function (res) {
                                    console.log(res);
                                    $('.main-content.page-wrapper').eq(0).append(res);
                                    window.history.pushState("object or string", "Title", '<?=$nextArticleUrl?>');

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
        $(document).ready(function() {
            initSimpleSlider('.simple-slider', 30, 16, 16, 8, 8);
            initSimpleSlider('.recommend-slider', 16, 16, 16, 12, 12);
            initRichSlider(48);

            // Call 'articleProgress(percent)' function to set the percent value for the progress-bar
            articleProgress(35);
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
            }) ;
        });


    </script>
<? if(!isset($ajax)) { ?>
    <style>
        .article-body img {
            max-width: 100%;
        }
    </style>
<? } ?>