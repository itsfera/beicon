<?php
use app\models\ImageSizes;
$galleryItems = [];
foreach ($gallery->items as $ITEM)
    $galleryItems[] = $ITEM;

$size1 = '9_16_352';
$size2 = '9_16_352_2';
$size3 = '1_1_352';


// СОБЫТИЯ
if($article["section"] == 5){

    $size1 = '9_16_352_exact';
    $size2 = '9_16_352_2_exact';
    $size3 = '1_1_352_exact';


}



$article->name = str_replace('"', '', $article->name);
?>

<div class="gallery-mosaic">

    <!-- Start Gallery Mosaic List -->
    <div class="gallery-mosaic__list">
        <div class="gallery-mosaic__col-width"></div>
        <div class="gallery-mosaic__space-items"></div>


        <?php
        $n = 1;
        foreach ($galleryItems as $item){
            ?>
            <div class="gallery-mosaic__item"  data-gallery="<?=$gallery["id"]?>">

                <? if ($n == 1) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" alt="<?=$article->name?>" width="352" height="536">
                <? } ?>
                <? if ($n == 2) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size2)?>" alt="<?=$article->name?>" width="352" height="256">
                <? } ?>
                <? if ($n == 3) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" alt="<?=$article->name?>" width="352" height="536">
                <? } ?>
                <? if ($n == 4) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size3)?>" alt="<?=$article->name?>" width="352" height="550">
                <? } ?>
                <? if ($n == 5) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" alt="<?=$article->name?>" width="352" height="536">
                <? } ?>
                <? if ($n == 6) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" alt="<?=$article->name?>" width="352" height="536">
                <? } ?>
                <? if ($n == 7) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size2)?>" alt="<?=$article->name?>" width="352" height="256">
                <? } ?>
            </div>
            <? $n++; if($n == 8) $n = 1; } ?>
    </div>
    <!-- End Gallery Mosaic List -->


    <!-- Start Gallery Mosaic Fullscreen view -->
    <div class="gallery-fullscreen gallery-mosaic-fullscreen">
        <div class="gallery-fullscreen__wrapper">
            <div class="gallery-fullscreen__inner">
                <div class="swiper-container gallery-fullscreen__swiper">
                    <div class="swiper-wrapper gallery-fullscreen__content">
                        <? foreach ($galleryItems as $item) { ?>
                            <div class="swiper-slide">
                                <div class="gallery-fullscreen__image-container">
                                    <img src="<?=UPLOAD_DIR.$item["url"]?>" alt="<?=$article->name?>">
                                </div>
                                <div class="right-aside">
                                    <p class="swiper-slide__description"><?=strip_tags($item->content)?></p>
                                    <div class="article__teaser_buy">
                                        <!--                                    <div class="image-container">-->
                                        <!--                                        <a href="#"><img src="/web/img/article-teaser-vert2.jpg" width="768" height="1200" alt=""></a>-->
                                        <!--                                    </div>-->

                                    </div>
                                </div>
                            </div>
                        <? } ?>

                    </div>
                    <!-- Ads Slides Counter -->
                    <div class="swiper-slide-count"><span class="swiper-slide__current"></span>/<span class="swiper-slide__total"></span></div>
                    <div class="share-block1">
                        <div class="share-block__inner1">
                            <!--                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
                            <!--                <script src="//yastatic.net/share2/share.js"></script>-->
                            <!--                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-bare="false"></div>-->
                            <div class="social-share__list_bottom">

                                <a class="social-login__item11 fb-share-button" id="facebookGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#fb"></use></svg></a>
                                <a class="social-login__item11" id='vkGalleryShare' rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#vk"></use></svg></a>
                                <a class="social-login__item11" id='twitterGalleryShare' rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#twitter"></use></svg></a>
                                <a class="social-login__item11" id="okGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#ok"></use></svg></a>
                            </div>
                        </div>
                    </div>

                    <!-- Add Arrows -->
                    <div class="swiper-button swiper-button-next"><svg class="inline-svg arrow-svg"><use xlink:href="#arrow"></use></svg></div>
                    <div class="swiper-button swiper-button-prev"><svg class="inline-svg arrow-svg"><use xlink:href="#arrow"></use></svg></div>
                </div>
            </div>
        </div>
        <div class="close-btn" role="button"><svg class="close-icon"><use xlink:href="#close"></use></svg></div>
    </div>

</div>
<style>

    .share-block1
    {
        position: absolute;
        top: 70px;
        left: calc(100% - 234px);
        right: auto;
        z-index: 1;
    }
    .share-block__inner1
    {
        background-color: white;
    }
    .swiper-button-prev.swiper-button-disabled, .swiper-button-next.swiper-button-disabled {
        display: none;
    }

    .social-login__item11 + .social-login__item11 {
        margin-left: 15px;
    }
    @media screen and (max-width: 1279px){
        .share-block1 .social-login__item + .social-login__item {
            margin-left: 15px;
        }}

    @media screen and (max-width: 1279px){
        .main-content.one-column .article .share-block1 {
            margin-right: 0;
            top: auto;
            left: 24px;
            bottom: 74px;
        }}

</style>

<script>
    $(function () {
        initGalleryMosaic();
    });
</script>