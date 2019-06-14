<?php
$this->title = 'Карта Сайта';

use yii\helpers\Html;
?>

<main class="main-content page-wrapper ">
    <div class="bl-wrapper">
        <h1><?= Html::encode($this->title) ?></h1>
        <ul style="list-style-type: none;padding-left: 0;">
        <? foreach($urls as $url): ?>
        <li style="margin-left: 10px;">
            <a href="<?=$url[0]?>"><?=$url[1]?></a>
        </li>
        <? endforeach; ?>
        </ul>
    </div>
</main>