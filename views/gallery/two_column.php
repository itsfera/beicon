<?php
use app\models\ImageSizes;
$galleryItems = [];
foreach ($gallery->items as $ITEM)
    $galleryItems[] = $ITEM;


$article->name = str_replace('"', '', $article->name);
?>
<div class="gallery-tile">
    <div class="gallery-tile-prev">
        <!-- Add class .items_%photos_number% to show correct block of photos -->
        <ul class="gallery-tile-prev__list items_5">
            <? if(isset($galleryItems[0])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[0]["url"], '1_1_516')?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">
                </li>
            <? } ?>
            <? if(isset($galleryItems[1])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[1]["url"], '1_1_516')?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">
                </li>
            <? } ?>
            <? if(isset($galleryItems[2])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[2]["url"], '16_9_830')?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">
                </li>
            <? } ?>
            <? if(isset($galleryItems[3])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[3]["url"], '16_9_830')?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">
                </li>
            <? } ?>
            <? if(isset($galleryItems[4])){ ?>
                <li class="gallery-tile-prev__item" data-gallery="<?=$gallery["id"]?>">
                    <img src="<?=UPLOAD_DIR.ImageSizes::getResizesName($galleryItems[4]["url"], '16_9_830')?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">

                    <? if(count($galleryItems) > 5){ ?>
                        <span class="photo-counter">+<?=count($galleryItems)-5?></span>
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
                                    <img src="/uploads/<?=$item["url"]?>" alt="<?=(!empty($item['content']))?$item['content']:$article->name?>">
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

                                                <a class="social-login__item11 fb-share-button" id="facebookGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#fb"></use></svg></a>
                                                <a class="social-login__item11" id='vkGalleryShare' rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#vk"></use></svg></a>
                                                <a class="social-login__item11" id='twitterGalleryShare' rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#twitter"></use></svg></a>
                                                <a class="social-login__item11" id="okGalleryShare" rel="nofollow "><svg class="inline-svg social-svg"><use xlink:href="#ok"></use></svg></a>
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


</style>