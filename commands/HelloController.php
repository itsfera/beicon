<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Gallery;
use app\models\GalleryItems;
use app\models\Image as customImage;
use app\models\PartnersNews;
use yii\web\UploadedFile;
use app\models\Articles;
use app\models\Image as cutomImage;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionGallery(){

        $galleries = Gallery::find()->with('items')->all();

        foreach ($galleries as $gallery){

            echo $gallery["id"].'<br>';

        }

    }

    public function actionOld(){

        $array = [];
        function listFolderFiles($dir){
            global $array;
            $ffs = scandir($dir);

            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);

            // prevent empty ordered elements
            if (count($ffs) < 1)
                return;

            $return_array = [];
            $n = 0;
//            echo '<ol>';
            foreach($ffs as $ff){
//                echo '<li>'.$ff;



                if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff); else {
                    $has = false;
                    if(file_exists(dirname(dirname(__FILE__)). '/web/uploads/'.$ff)) {

                        echo 'Фото уже найдено '.$ff."\n";
                        continue; };
                    $str = explode('.', $ff);

//                    $article = Articles::find()->where(['like', 'preview_img',  $str[0]])->one();

                    if(count(explode('galleries', $dir)) < 2) {


                        customImage::loadOldImage($dir . '/' . $ff);

                        echo 'Загружена фото '.$dir.'/'.$ff.'<br>';
                        $has = true;
//                        return ExitCode::OK;
                    }
//


                    if(!$has){
//                        echo 'Не найдена фото '.$dir.'/'.$ff.'<br>';

                        $return_array[] = $dir.'/'.$ff;
                    }
                    $n++;
                }
//                echo '</li>';
            }


            $message = "";
            foreach ($return_array as $i){
                $message.= "$i \r\n";
            }

            mail('yura.lyashkov@yandex.by', 'Картинки', $message);
//            echo '</ol>';
        }


        listFolderFiles(dirname(dirname(__FILE__)) .'/../tmp_uploads');
        echo 'OK'."\n";
        return ExitCode::OK;

    }
}
