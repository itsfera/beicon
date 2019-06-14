<?
use yii\widgets\ActiveForm;

?>

<?php

\yii\widgets\Pjax::begin([]);
?>



<!-- Start Subscribe aside -->
<aside class="subscribe-block bl-wrapper">
    <div class="el-wrapper">
        <div class="subscribe-block__wrapper">
            <div class="subscribe-block__col subscribe-block__col_l">
                <h2>Не пропусти самые вкусные новости</h2>
<!--                <span class="subscribe-block__description">С нашей рассылкой не пропустишь</span>-->

                <? if(isset($status) && $status == 'ok') { ?>

                    <!-- Start Sign in and Sign up Popup -->
                    <div class="popup " id="subscribePopup">
                        <!-- Start Sign Popup Header -->
                        <div class="slide-page__header">
                            <div class="slide-page-menu sp-content-wrapper">

                            </div>
                            <button class="close-btn"><svg class="close-icon"><use xlink:href="#close"></use></svg></button>
                        </div>
                        <!-- End Sign Popup Header -->
                        <div class="sp-content-wrapper slide-page__body">
                            <p>Спасибо! На ваш e-mail направлено письмо для подтверждения подписки.</p>
                        </div>

                    </div>
                <script>

                    $(function () {

                        $('.overlay-bg_dark').fadeIn(300);
                        $('#subscribePopup').fadeIn(300);
                        $('body').addClass('stop-scroll');


                        $('#subscribePopup .close-btn').click(function () {
                            $('.overlay-bg_dark').fadeOut(300);
                            $('#subscribePopup').fadeOut(300);
                            $('body').removeClass('stop-scroll');
                        });
                    });
                </script>
                    <style>
                        #subscribePopup {
                            padding: 6px 13px;
                            background-color: #fff;
                            z-index: 1000;
                            min-height: 365px;
                            text-align: center;
                            max-width: 450px;
                            font-family: 'Spectral', serif;
                        }
                        #subscribePopup .sp-content-wrapper {
                            display: block;
                        }
                    </style>
                <? } ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'subscribeForm',
                    'options' => [
                        'class' => '',
                        'data' => [
                                'pjax' => true
                        ]
                    ],
                    'fieldConfig' => [
                        'options' => [
                        ],
                    ]
                ]);

                $formModel = $model;
                ?>

                <div class="input-in-line">
                    <?= $form->field($formModel, 'email')->textInput(['autofocus' => false, 'placeholder' => 'E-mail', 'class' => '', 'id' => 'userEmailSubscribe'])->label(false) ?>
                    <?= \yii\helpers\Html::submitButton('Подписаться', ['class' => 'btn']); ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
            <div class="subscribe-block__col subscribe-block__col_r">
                <div class="subscribe-block__bg"></div>
            </div>
        </div>
    </div>
</aside>

<? \yii\widgets\Pjax::end(); ?>
<!-- End Subscribe aside -->