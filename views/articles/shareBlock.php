<?

use yii\helpers\Url;

?>

<?= \ymaker\social\share\widgets\SocialShare::widget([
    'configurator' => 'socialShare',
    'url' => Url::to(['articles/view', 'url' => $article["url"], 'section' => $article->sectionData->url], true),
    'title' => $article['name'],
    'description' => strip_tags($article['preview_content']),
    'imageUrl' => \yii\helpers\Url::to($socialImage, true),
]); ?>