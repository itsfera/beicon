<?php

namespace app\controllers;

use app\models\Rss;
use Yii;
use yii\helpers\Url;
use yii\web\Response;
use app\components\XmlResponseFormatter;


class RssController extends \yii\web\Controller
{

    public function actionIndex($url)
    {

        $query = Rss::find()->where(['rss.url' => $url])->joinWith([
            'articles' => function ($query) {
                $query->andWhere(['status' => 'publish'])->joinWith('sectionData');
            },
        ]);

        if ($query->count() == 0) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }


        Yii::$app->response->format = 'xml';
        Yii::$app->response->formatters = ['xml' => ['class' => 'app\components\XmlResponseFormatter', 'rootTag' => 'rss', 'itemTag' => 'object', 'parameters' => ['xmlns:yandex' => 'http://news.yandex.ru', 'xmlns:rambler' => 'http://news.rambler.ru', 'version' => '2.0', 'encoding' => 'utf-8']]];

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();


        $result = [
            'title' => 'Beicon',
            'link' => 'https://www.beicon.ru',
            'description' => 'Описание канала',
            'language' => 'ru',

        ];


        $rss = $query->groupBy('articles.id')->asArray()->all();


        foreach ($rss[0]['articles'] as $value) {


            if ($value['status'] != 'publish') next;

            $result[]['item'] = [
                'title' => $value['name'],
                'link' => 'https://beicon.ru' . Url::to(['articles/view', 'url' => $value['url'], 'section' => $value['sectionData']['url']]),
                'pubDate' => date(DATE_RFC822, strtotime($value['date_publish'])),
                'author' => 'Beicon',
                'description' => ['cdata' => html_entity_decode(strip_tags($value['preview_content']), ENT_NOQUOTES)],
                'yandex:full-text' => ['cdata' => html_entity_decode(preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", preg_replace('/<iframe.*?\/iframe>/i', '', $value['content']))), 'namespace' => 'yandex', 'url' => 'http://news.rambler.ru'],
                'rambler:fulltext' => ['cdata' => html_entity_decode(preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", preg_replace('/<iframe.*?\/iframe>/i', '', $value['content']))), 'namespace' => 'rambler', 'url' => 'http://news.yandex.ru'],
                'yandex:genre' => ['data' => 'article', 'namespace' => 'yandex'],
                'enclosure' => ['setAttributes' => ['url' => 'https://beicon.ru' . UPLOAD_DIR . $value['id'] . '-' . $value['preview_img'], 'type' => "image/jpeg"]],
            ];
        }

//        echo '<pre>';
//        print_r($result);
//        die;
        return $result;
    }

}
