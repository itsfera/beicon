<?php
namespace app\controllers;

use app\models\Gallery;
use app\models\GalleryItems;
use app\models\Image as customImage;
use app\models\PartnersNews;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;
use app\models\Articles;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

use yii\filters\auth\QueryParamAuth;
class ImageController extends Controller
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Image';
    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new customImage();


        if (Yii::$app->request->isPost) {


                $fr = UploadedFile::getInstanceByName('upload');
            $fr2 = UploadedFile::getInstanceByName('location');
            if($fr){
                $model->location = $fr;
            }
            if($fr2){
                $model->location = $fr2;
            }


             if(!$model->location) return ['status' => 'error', 'message' => 'Нет файла'];

            $f = Yii::$app->request->post();


                if(isset($f["gallery_id"])){

                    $gallery = new GalleryItems;



                    if($model->uploadGalleryItem($f["gallery_id"])) {

                        $otherGalleryItems = GalleryItems::find()->where(['gallery_id' => $f["gallery_id"]])->orderBy(['sort' => SORT_DESC]);
                        $other = $otherGalleryItems->one();


                        if(!$f['sort'] && $other){
                            $f["sort"] = $other['sort']+10;
                        }

                        $gallery->sort = isset($f["sort"]) ? $f["sort"] : 10;
                        $gallery->gallery_id = $f["gallery_id"];


                        $gallery->url = '/galleries/' . $f["gallery_id"] . '/' . $model->sname;
                        $gallery->save();
                        return ['success' => true, 'message' => 'Gallery Item Saved', 'location' => 'http://beicon.ru/uploads/galleries/' . $f["gallery_id"] . '/' . $model->sname, 'gallery_id' => $f["gallery_id"]];

                    }
                }

                if(isset($f["filename"])){
                    $filename = explode('/', $f["filename"]);
                    $path = '';
                    foreach ($filename as $k => $cpath){
                        if($k == count($filename)-1) continue;
                        if($cpath == 'beicon.ru') continue;
                        if($cpath == 'www.beicon.ru') continue;
                        if($cpath == 'beicon.ru:80') continue;
                        if($cpath == 'www.beicon.ru:80') continue;
                        if($cpath == 'beicon.ru:443') continue;
                        if($cpath == 'www.beicon.ru:443') continue;
                        if($cpath == 'http:') continue;
                        if($cpath == 'https:') continue;
                        if($cpath == 'http:/') continue;
                        if($cpath == 'https:/') continue;
                        if($cpath == 'http://') continue;
                        if($cpath == 'https://') continue;

                        $path.=$cpath.'/';
                    }
                    $model->uploadResize($filename[count($filename)-1], $f["postfix"], $path);
                    return ['success' => true, 'message' => 'File saved.', 'location' => 'http://beicon.ru/uploads/' . $model->sname];
                } elseif ($model->upload()) {
                    // file is uploaded successfully


//                    Если загрузка к статье
                    if(isset($f["article_id"])){
                       $article = new Articles();
                       $res = $article->findOne($f["article_id"]);

                       if($f["img_type"] == 'header_img')
                           $res->header_img = $model->sname;
                       elseif($f["img_type"] == 'preview_img')
                           $res->preview_img = $model->sname;

//                        $imagine = Image::getImagine()
//                            ->open($_SERVER["DOCUMENT_ROOT"].'/uploads/' . $model->sname)
//                            ->thumbnail(new Box(733, 400))
//                            ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/header_img/' . $model->sname, ['quality' => 90]);
//
//                        $imagine = Image::getImagine()
//                            ->open($_SERVER["DOCUMENT_ROOT"].'/uploads/' . $model->sname)
//                            ->thumbnail(new Box(80, 80))
//                            ->save($_SERVER["DOCUMENT_ROOT"].'/uploads/mini/' . $model->sname, ['quality' => 90]);

                        if($res->save()) {


                           return ['success' => true, 'message' => 'File saved.', 'article_id' => $f["article_id"], 'img_type' => $f["img_type"], 'location' => 'http://beicon.ru/uploads/' . $model->sname];

                       } else {
                           return ['success' => false, 'message' => $res->getErrors()];
                       }
                    } elseif(isset($f["pnews_id"])) {

                        $article = new PartnersNews();
                        $res = $article->findOne($f["pnews_id"]);


                        $res->preview_img = $model->sname;
                        if($res->save()) {


                            return ['success' => true, 'message' => 'File saved.', 'pnews_id' => $f["pnews_id"], 'location' => 'http://beicon.ru/uploads/' . $model->sname];
                        }

                    } elseif(isset($f["path"])) {

                    } else {
                        return ['success' => true, 'message' => 'File saved.', 'id_field' => $f["id_field"], 'location' => 'http://beicon.ru/uploads/'.$model->sname];
                    }
                }
                else return ['success' => false, 'message' => 'Could not save file.'];

        }
        else return ['success' => false, 'message' => 'Not a POST request.'];
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
                    if(file_exists(dirname(dirname(__FILE__)). '/web/uploads/'.$ff)) continue;
                    $str = explode('.', $ff);

                    $article = Articles::find()->where(['like', 'preview_img',  $str[0]])->one();
                    if($article){






                        customImage::loadOldImage($dir.'/'.$ff, $article->id, 'preview');

                        $has = true;
                    }
//
                    $article = Articles::find()->where(['like', 'header_img',  $str[0]])->one();
                    if($article){



                        customImage::loadOldImage($dir.'/'.$ff, $article->id, 'header');

                        $has = true;
                    }

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


    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [


                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors'  => [
                        'Origin'                           => ['*'],
                        'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                        'Access-Control-Allow-Credentials' => true,
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                        'Access-Control-Expose-Headers' => ['*'],
                    //    'Access-Control-Allow-Origin' => ['*'],

                    ]
                ]
            ]
        );
    }
}