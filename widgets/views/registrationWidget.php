<?
use yii\widgets\ActiveForm;

?>

<?php

\yii\widgets\Pjax::begin([]);
?>
<? if(isset($status) && $status == 'ok') { ?>
    <p>Cпасибо за проявленный интерес, мы оповестим вас, когда функция заработает.</p>
<? } else { ?>
<?php $form = ActiveForm::begin([
    'id' => 'signUpForm',
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

<!--    <label for="userEmailReg">E-mail</label>-->
<?= $form->field($formModel, 'email')->textInput(['autofocus' => false, 'placeholder' => 'E-mail', 'class' => '', 'id' => 'userEmailReg'])->label(false) ?>
<?= \yii\helpers\Html::submitButton('Зарегистрироваться', ['class' => 'btn']); ?>
<!--    <button type="submit" class="btn" id="reg-submit-btn"></button>-->
<?php ActiveForm::end(); ?>
<? } ?>

<style>
    #signUpForm .field-userEmailReg {
        width: 100%;
    }
</style>
<? \yii\widgets\Pjax::end(); ?>
