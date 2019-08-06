<?php

namespace app\models;

use app\models\Articles;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use app\models\Tags;

class News extends Model
{
    public function getUrl()
    {
        $urls = array();

        $sectionsSeoValues = Seo::find()
            ->where(['tbl' => Sections::tableName()])
            ->select(['changegreq', 'priority', 'id_record'])
            ->indexBy('id_record')
            ->all();
        $articlesSeoValues = Seo::find()
            ->where(['tbl' => Articles::tableName()])
            ->select(['changegreq', 'priority', 'id_record'])
            ->indexBy('id_record')
            ->all();

        $sections = Sections::find()
            ->select(['id', 'url'])
            ->where(['id' => '4'])
            ->all();
        //Формируем двумерный массив. createUrl преобразует ссылки в правильный вид.
        //Добавляем элемент массива 'daily' для указания периода обновления контента

        foreach ($sections as $section) {
            $articles = Articles::find()
                ->where(['section' => $section->id, 'status' => 'publish'])
                ->andWhere(['<=', 'date_publish', date('Y-m-d H:i:s')])
                ->select(['id', 'url', 'name', 'date_publish'])
                ->all();
            /*if (count($articles) > 0)
                $urls[] = array(Url::to(['sections/view', 'url' => $section->url]), $sectionsSeoValues[$section->id]->changegreq, $sectionsSeoValues[$section->id]->priority);*/
            foreach ($articles as $article) {

                $urls[] = array(
                    'link' => Url::to(['articles/view', 'url' => strtolower($article->url), 'section' => $section->url]),
                    $articlesSeoValues[$article->id]->changegreq,
                    $articlesSeoValues[$article->id]->priority,
                    'pubDate' => str_replace(" ", "T", $article->date_publish) . '+03:00',
                    'title' => $article->name,
                );
            }
        }
        unset($sectionsSeoValues);
        unset($articlesSeoValues);
        unset($sections);
        unset($articles);
        //$urls[] = array(Url::to(['/site/news']), 'always', '0.9');
        return $urls;
    }

    public function getUrlName()
    {
        $urls = array(['/', 'Главная']);
        $section_urls = array();
        $article_urls = array();

        //Получаем массив URL из таблицы Sef
        $sections = Sections::find()->orderBy(['hidden' => SORT_ASC, 'sort' => SORT_ASC])->select(['id', 'url', 'name'])
            ->all();
        //Формируем двумерный массив. createUrl преобразует ссылки в правильный вид.
        foreach ($sections as $section) {
            $articles = Articles::find()->where(['section' => $section->id, 'status' => 'publish'])->andWhere(['<=', 'date_publish', date('Y-m-d H:i:s')])->orderBy(['date_publish' => SORT_ASC])->select(['url', 'name'])
                ->all();
            foreach ($articles as $article) {
                $article_urls[] = array(Url::to(['articles/view', 'url' => strtolower($article->url), 'section' => $section->url]), $article->name);
            }
            if (count($articles) > 0)
                $section_urls[] = array(Url::to(['sections/view', 'url' => $section->url]), $section->name);
        }
        $urls = array_merge($urls, $section_urls, $article_urls);
        return $urls;
    }

    public function getRss($urls, $rssName, $customNames = [])
    {
        $host = 'https://www.beicon.ru'; // домен сайта
        $content = isset($customNames[$rssName]['content']) ? $customNames[$rssName]['content'] : 'content';
//        $host = Yii::$app->request->hostInfo;
        ob_start();


        echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
        <?
        foreach ($urls as $url) { ?>
            <url>
                <loc><?= $host . $url["link"] ?></loc>
                <news:news>
                    <news:publication>
                        <news:name>BeIcon</news:name>
                        <news:language>ru</news:language>
                    </news:publication>
                    <news:publication_date><?= $url["pubDate"] ?></news:publication_date>
                    <news:title><?= str_replace('&', '&amp;', $url["title"]) ?></news:title>
                </news:news>
            </url>
            <?
        } ?>
        </urlset><?php


        return ob_get_clean();
    }

    public function getXml($urls, $sitemap = true)
    {
        $host = 'https://www.beicon.ru'; // домен сайта
//        $host = Yii::$app->request->hostInfo; // домен сайта
        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <? if ($sitemap) { ?>
                <url>
                    <loc><?= $host ?></loc>
                    <changefreq>daily</changefreq>
                    <priority>1</priority>
                </url>
            <? } ?>
            <?php foreach ($urls as $url): ?>
                <url>
                    <loc><?= $host . $url[0] ?></loc>
                    <changefreq><?= $url[1] ?></changefreq>
                    <priority><?= $url[2] ?></priority>
                </url>
            <?php endforeach; ?>
        </urlset>
        <?php return ob_get_clean();
    }

    public function showXml($xml_sitemap)
    {
        // устанавливаем формат отдачи контента
//        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //повторно т.к. может не сработать
//        header("Content-type: text/xml");
        return $xml_sitemap;
//        Yii::$app->end();
    }
}
