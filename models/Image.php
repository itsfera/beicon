<?php
namespace app\models;

use yii\base\Model;
use app\models\ImageSizes;
use yii\web\UploadedFile;
use Yii;

class Image extends Model
{
    /**
     * @var UploadedFile
     */
    public $location;
    public $sname;

    public function rules()
    {
        return [
            [['location'], 'file'],
        ];
    }

    static $propSizes = [
        '16x9' => [
          ['width' => 830, 'height' => 467, 'postfix' => '16_9_830'],
          ['width' => 1040, 'height' => 587, 'postfix' => '16_9_1040'],
          ['width' => 587, 'height' => 1040, 'postfix' => '16_9_587'],

            ['width' => 352, 'height' => 198, 'postfix' => '9_16_352_2'],
            ['width' => 352, 'height' => 198, 'postfix' => '9_16_352_2_exact', 'exact' => 'top'],
        ],
        '9x16' => [
            ['width' => 352, 'height' => 627, 'postfix' => '9_16_352'],
            ['width' => 352, 'height' => 627, 'postfix' => '9_16_352_exact', 'exact' => 'top'],
        ],
        '1x1' => [
            ['width' => 516, 'height' => 516, 'postfix' => '1_1_516'],
            ['width' => 352, 'height' => 352, 'postfix' => '1_1_352'],
            ['width' => 352, 'height' => 352, 'postfix' => '1_1_352_exact', 'exact' => 'top'],
            ['width' => 690, 'height' => 800, 'postfix' => '1_1_690'],
            ['width' => 560, 'height' => 560, 'postfix' => '1_1_560'],
            ['width' => 80, 'height' => 80, 'postfix' => 'mini'],
        ]
    ];

    static $sizes = [
//        ['width' => 950, 'height' => 400, 'postfix' => 'gallery_only_main'],
//        ['width' => 412, 'height' => 200, 'postfix' => 'gallery_only_other'],
//        ['width' => 1604, 'height' => 878, 'postfix' => 'gallery_only_big'],
//        ['width' => 1136, 'height' => 556, 'postfix' => 'gallery_one_main'],
//        ['width' => 564, 'height' => 320, 'postfix' => 'gallery_one_other'],
//        ['width' => 564, 'height' => 400, 'postfix' => 'gallery_one_second_main'],
//        ['width' => 373, 'height' => 200, 'postfix' => 'gallery_one_second_other'],
//        ['width' => 352, 'height' => 536, 'postfix' => 'gallery_one_third_v'],
//        ['width' => 352, 'height' => 256, 'postfix' => 'gallery_one_third_h'],
//        ['width' => 352, 'height' => 550, 'postfix' => 'gallery_one_third_v2'],
//        ['width' => 1860, 'height' => 878, 'postfix' => 'gallery_one_third_full'],
//
//
//        ['width' => 1040, 'height' => 400, 'postfix' => 'gallery_only_one_main'],
//        ['width' => 516, 'height' => 200, 'postfix' => 'gallery_only_one_other'],


        ['width' => 352, 'height' => 627, 'postfix' => '9_16_352_exact', 'exact' => 'top', 'origin' => '9x16'],
        ['width' => 352, 'height' => 198, 'postfix' => '9_16_352_2_exact', 'exact' => 'top', 'origin' => '16x9'],

        ['width' => 352, 'height' => 352, 'postfix' => '1_1_352_exact', 'exact' => 'top', 'origin' => '1x1'],

        ['width' => 830, 'height' => 467, 'postfix' => '16_9_830', 'origin' => '16x9'],
        ['width' => 516, 'height' => 516, 'postfix' => '1_1_516', 'origin' => '1x1'],
        ['width' => 1040, 'height' => 587, 'postfix' => '16_9_1040', 'origin' => '16x9'],
        ['width' => 1040, 'height' => 587, 'postfix' => '16_9_734_nocrop', 'nocrop' => true, 'origin' => '16x9'],
        ['width' => 587, 'height' => 1040, 'postfix' => '16_9_587', 'origin' => '16x9'],
        ['width' => 352, 'height' => 352, 'postfix' => '1_1_352', 'origin' => '1x1'],
        ['width' => 352, 'height' => 627, 'postfix' => '9_16_352', 'origin' => '9x16'],
        ['width' => 352, 'height' => 198, 'postfix' => '9_16_352_2', 'origin' => '9x16'],



        ['width' => 690, 'height' => 800, 'postfix' => '1_1_690', 'origin' => '1x1'],
        ['width' => 560, 'height' => 560, 'postfix' => '1_1_560', 'origin' => '1x1'],
        ['width' => 80, 'height' => 80, 'postfix' => 'mini'],




    ];

    static function loadOldImage($pathImg)
    {
        $path = dirname(dirname(__FILE__)) . '/web/uploads/';
//        die();
        $rand = rand(00000, 99999);
//$file_name = md5(strtotime(date('Y-m-d H:i:s'))+$rand);

        $file=Yii::getAlias($pathImg);

//        $file=Yii::getAlias('@app/'.$pathImg);
        $image=\Yii::$app->image->load($file);
        $imgName = explode('/', $pathImg);
        $imgName = $imgName[count($imgName)-1];
        $imgName = explode('#', $imgName);
        $imgName = $imgName[0];
        $imgFormat = explode('.', $imgName);
        $imgFormat = $imgFormat[1];

        if(file_exists(dirname(dirname(__FILE__)). '/web/uploads/'.$imgName)) return;

        $newPath = $imgName;
        $image->save($path.$newPath);

//        $article = Articles::findOne($articleId);
//        if($type == 'preview')
//        $article->preview_img = $newPath;
//        else $article->header_img = $newPath;
//        $article->save();

        $sizes = ImageSizes::find()->all();

        foreach ($sizes as $size){

            $fileName = explode('.', $imgName);
            $fileName = $fileName[0];
            $file=Yii::getAlias('@app/web/uploads/'.$newPath);
            $image=Yii::$app->image->load($file);
            $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);
            $image->save(dirname(dirname(__FILE__)) . '/web/uploads/'.$fileName.'_'.$size["postfix"].'.'.$imgFormat, $quality = 100);


        }
    }

    public function upload()
    {
        $path = dirname(dirname(__FILE__)) . '/web/uploads/';

        if ($this->validate()) {
            $file_name = strtotime(date('Y-m-d H:i:s'));


            $this->sname =  $file_name.'.' . $this->location->extension;
            $this->location->saveAs($path . $this->sname);

            $sizes = ImageSizes::find()->all();

            foreach ($sizes as $size){


                $file=Yii::getAlias('@app/web/uploads/'.$this->sname);
                $image=Yii::$app->image->load($file);
//                $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);



                if(isset($size["exact"]) && $size["exact"] == 'top'){


                    $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                    if((($image->width - $size['width']) / 2) > 0) {
                        $posX = ($image->width - $size['width']) / 2;
                    } else $posX = 0;
                    $image->crop($size["width"], $size["height"],$posX, 0);

                } else {
                    if(isset($size["nocrop"])){
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::ADAPT)->background('#fff');
                    } else {
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                        $image->crop($size["width"], $size["height"]);
                    }
                }
                $image->save(dirname(dirname(__FILE__)) . '/web/uploads/'.$file_name.'_'.$size["postfix"].'.'.$this->location->extension, $quality = 100);


            }


            return true;
        } else {
            die(var_dump($this->errors));
            return false;
        }
    }

    public function moveGalleryItem($gallery_id, $fileName){
        $path = dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id.'/';
        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries')) {
            mkdir(dirname(dirname(__FILE__)) . '/web/uploads/galleries', 0775);
        }
        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id)) {
           $R = mkdir(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id, 0775);
//           var_dump($R);
        }
//        die();

        if($this->validate())
        {
            $file_name = $fileName;
            $fileEx = explode('.', $file_name);
            $file_name = $fileEx[0];
            $fileEx = $fileEx[1];

            $this->sname =  $file_name. '.' . $fileEx;



            $file=Yii::getAlias(dirname(dirname(__FILE__)) .'/../tmp_uploads/galleries/'.$gallery_id.'/'.$this->sname);
            $image=Yii::$app->image->load($file);


            $image->save(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id.'/'.$file_name.'.'.$fileEx, $quality = 70);

//            $this->location->saveAs($path . $this->sname. '.'.$fileEx);

            $sizes = Image::$sizes;

            foreach ($sizes as $size){
                $file=Yii::getAlias('@app/web/uploads/galleries/'.$gallery_id.'/'.$this->sname);
                $image=Yii::$app->image->load($file);
                $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);
                $image->save(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id.'/'.$file_name.'_'.$size["postfix"].'.'.$fileEx, $quality = 70);
            }

            return true;
        } else {
            die(var_dump($this->errors));
        }
    }

    public function uploadGalleryItem($gallery_id){
        $path = dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id.'/';
        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries')) {
            mkdir(dirname(dirname(__FILE__)) . '/web/uploads/galleries', 0775);
        }
        if (!file_exists(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id)) {
            mkdir(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id, 0775);
            chmod(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id, 0777);
        }

        if($this->validate())
        {
            $file_name = strtotime(date('Y-m-d H:i:s'));
            $rand = rand(11111, 99999);
            $file_name = md5(strtotime(date('Y-m-d H:i:s'))+$rand);
            $this->sname =  $file_name.'.' . $this->location->extension;
            try {
                $r = $this->location->saveAs($path . $this->sname);
            } catch (\Exception $e){

                die();
            }
            $sizes = Image::$sizes;


            foreach ($sizes as $size){
                $file=Yii::getAlias('@app/web/uploads/galleries/'.$gallery_id.'/'.$this->sname);
                $image=Yii::$app->image->load($file);
//                $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);


                if(isset($size["exact"]) && $size["exact"] == 'top'){


                    $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                    if((($image->width - $size['width']) / 2) > 0) {
                        $posX = ($image->width - $size['width']) / 2;
                    } else $posX = 0;
                    $image->crop($size["width"], $size["height"],$posX, 0);

                } else {





                    if(isset($size["nocrop"])){
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::ADAPT)->background('#fff');
                    } else {
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                        $image->crop($size["width"], $size["height"]);
                    }
                }

                $image->save(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$gallery_id.'/'.$file_name.'_'.$size["postfix"].'.'.$this->location->extension, $quality = 70);
            }

            return true;
        } else {
            die(var_dump($this->errors));
        }

    }


    public function uploadResize($filename, $postfix, $path = false)
    {
        if(!$path)
            $path = dirname(dirname(__FILE__)) . '/web/uploads/';
        else $path = dirname(dirname(__FILE__)) .'/web/'. $path;
        $filename = explode('.', $filename);

        if ($this->validate()) {



            $this->sname =  $filename[0].'_'.$postfix.'.' . $filename[1];
//            echo $path.$this->sname;
//            die();
            $this->location->saveAs($path . $this->sname);
            $tmp = explode('galleries', $path);

            if(count($tmp) > 1) {
                chmod(dirname(dirname(__FILE__)) . '/web/uploads/galleries/'.$tmp[1], 0777);
                $this->sname = 'galleries/'.$tmp[1].'/'.$this->sname;

            }

            $sizes = Image::$propSizes;

            $tmp = explode('galleries', $path);

            if(count($tmp) > 1) {
                $filename[0] = '/galleries'.$tmp[1].'/'.$filename[0];

            }

            foreach ($sizes as $k => $sizeArray){



                if($k == $postfix){



                    foreach ($sizeArray as $size) {




                        $file = Yii::getAlias('@app/web/uploads/' . $this->sname);
                        $image = Yii::$app->image->load($file);
                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE)->crop($size["width"], $size["height"]);
//echo dirname(dirname(__FILE__)) . '/web/uploads/' . $filename[0] . '_' . $size["postfix"] . '.' . $filename[1];
//                        echo $path;
//                        print_r($filename);
//echo '<br>';
                        $r = $image->save(dirname(dirname(__FILE__)) . '/web/uploads/' . $filename[0] . '_' . $size["postfix"] . '.' . $filename[1], $quality = 100);

                    }
                }

            }


            return true;
        } else {
            die(var_dump($this->errors));
            return false;
        }
    }
}