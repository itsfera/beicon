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
        <div class="gallery-mosaic__col-width"></div>'
        <div class="gallery-mosaic__space-items"></div>


        <?php
        $n = 1;
        foreach ($galleryItems as $item){
            ?>
            <div class="gallery-mosaic__item"  data-gallery="<?=$gallery["id"]?>">

                <? if ($n == 1) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="536">
                <? } ?>
                <? if ($n == 2) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size2)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="256">
                <? } ?>
                <? if ($n == 3) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="536">
                <? } ?>
                <? if ($n == 4) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size3)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="550">
                <? } ?>
                <? if ($n == 5) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="536">
                <? } ?>
                <? if ($n == 6) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size1)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="536">
                <? } ?>
                <? if ($n == 7) { ?>
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($item["url"], $size2)?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?> width="352" height="256">
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
                                    <img src="<?=UPLOAD_DIR.$item["url"]?>" <?=(!empty($item['content']))?'alt="'.$item['content'].'"':''?>>
                                </div>
                                <div class="right-aside">
                                    <p class="swiper-slide__description"><?=strip_tags($item->content)?></p>
                                    <div class="article__teaser_buy">
                                        <!--                                    <div class="image-container">-->
                                        <!--                                        <a href="#"><img src="/web/img/article-teaser-vert2.jpg" width="768" height="1200" alt=""></a>-->
                                        <!--                                    </div>-->

                                    </div>
                                    <div class="share-block1">
                                        <div class="share-block__inner1">
                                            <!--                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>-->
                                            <!--                <script src="//yastatic.net/share2/share.js"></script>-->
                                            <!--                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-bare="false"></div>-->
                                            <div class="social-share__list_bottom">

                                                <a class="social-login__item11 fb-share-button facebookGalleryShare"  rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#fb"></use></svg></a>
                                                <a class="social-login__item11 vkGalleryShare"  rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#vk"></use></svg></a>
                                                <a class="social-login__item11 twitterGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#twitter"></use></svg></a>
                                                <a class="social-login__item11 okGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#ok"></use></svg></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <? } ?>

                    </div>
                    <!-- Ads Slides Counter -->
                    <div class="swiper-slide-count"><span class="swiper-slide__current"></span>/<span class="swiper-slide__total"></span></div>

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

    .share-block1 {
        /* position: absolute; */
        /* bottom: 70px; */
        left: calc(100% - 234px);
        right: auto;
        z-index: 1;
        margin-bottom: 25px;
    }

    @media screen and (max-width: 768px) {
        .social-share__list_bottom {
            margin-left:10px;
        }
    }

</style>

<script>
    $(function () {
        initGalleryMosaic();
    });
</script>