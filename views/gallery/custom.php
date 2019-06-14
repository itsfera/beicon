<?php
use app\models\ImageSizes;
$galleryItems = [];
foreach ($gallery->items as $ITEM)
    $galleryItems[] = $ITEM;


$firstSize = 'gallery_only_main';
$secondSize = 'gallery_only_other';

if($view_type == 'gallery-one-column' || $view_type == 'gallery-only-one-column'){
    $firstSize = 'gallery_one_main';
    $secondSize = 'gallery_one_other';
}

$firstSize = '16_9_1040';
$secondSize = '16_9_830';

$article->name = str_replace('"', '', $article->name);


?>
<div class="gallery-tile">
    <div class="gallery-tile-prev">
        <ul class="gallery-tile-prev__list items_3">
            <? if(isset($galleryItems[0])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[0]["url"], $firstSize, $gallery["id"])?>" alt="<?=$article->name?>" >
                </li>
            <? } ?>
            <? if(isset($galleryItems[1])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[1]["url"], $secondSize, $gallery["id"])?>" alt="<?=$article->name?>">
                </li>
            <? } ?>
            <? if(isset($galleryItems[2])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[2]["url"], $secondSize, $gallery["id"])?>" alt="<?=$article->name?>">

                    <? if(count($galleryItems) > 3){ ?>
                        <span class="photo-counter">+<?=count($galleryItems)-3?></span>
                    <? } ?>
                </li>
            <? } ?>


        </ul>
    </div>

    <div class="gallery-fullscreen">
        <div class="gallery-fullscreen__wrapper">
            <div class="gallery-fullscreen__inner">
                <div class="swiper-container gallery-fullscreen__swiper">
                    <div class="swiper-wrapper gallery-fullscreen__content">
                        <? foreach ($gallery->items as $item) { ?>
                        <div class="swiper-slide">
                            <div class="gallery-fullscreen__image-container">
                                <img src="/uploads/<?=$item["url"]?>" alt="<?=$article->name?>">
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
                    <!-- Add Arrows -->
                    <div class="swiper-button swiper-button-next"><svg class="inline-svg arrow-svg"><use xlink:href="#arrow"></use></svg></div>
                    <div class="swiper-button swiper-button-prev"><svg class="inline-svg arrow-svg"><use xlink:href="#arrow"></use></svg></div>
                </div>
            </div>
        </div>
        <div class="close-btn" role="button"><svg class="close-icon"><use xlink:href="#close"></use></svg></div>
    </div>
</div>

