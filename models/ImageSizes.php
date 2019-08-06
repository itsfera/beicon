<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use app\models\Image;

class ImageSizes extends ActiveRecord
{
    public static function tableName()
    {
        return 'image_sizes';
    }

    static function ResizeTmp($img, $type, $ifGallery = false, $remake = false)
    {
        $fname = explode('.', $img);
        $image = \Yii::$app->image->load($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . ($type ? '_' . $type : '') . '.' . $fname[1]);
        $name = $fname[0] . ($type ? '_' . $type : '') . '_resized.' . $fname[1];
        $image->save($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $name, $quality = 60);
        return $name;
    }

    static function getResizesName($img, $type, $ifGallery = false, $remake = false)
    {

        $nofile = false;
        $fname = explode('.', $img);
        if (!$img) {
            $fname = ['123123123', 'jpg'];
        }

        $msh = false;
//        if(1 == 1) {
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '_' . $type . '.' . $fname[1]) || strpos($type, 'nocrop')) {

            $sizes = Image::$sizes;
            foreach ($sizes as $size) {
                if ($size["postfix"] == $type && isset($size["origin"]))
                    $msh = $size["origin"];
            }


            if ($msh && file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '_' . $msh . '.' . $fname[1])) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '_' . $msh . '.' . $fname[1]);
            } else if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '.' . $fname[1])) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '.' . $fname[1]);
            } else {
                $nofile = true;
                $file = \Yii::getAlias('@app/web/img/nophoto.jpg');
            }

            if ($ifGallery || strpos($type, 'nocrop')) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '.' . $fname[1]);
            }

//echo $file;
//            return;


            $image = \Yii::$app->image->load($file);


            foreach ($sizes as $size) {
                if ($size["postfix"] == $type && ($size["width"] != $image->width || $size["height"] != $image->height)) {

//                        $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '.' . $fname[1]);
                    $image = \Yii::$app->image->load($file);

                    if (isset($size["exact"]) && $size["exact"] == 'top') {


                        $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                        if ((($image->width - $size['width']) / 2) > 0) {
                            $posX = ($image->width - $size['width']) / 2;
                        } else $posX = 0;
                        $image->crop($size["width"], $size["height"], $posX, 0);

                    } else {
                        if (isset($size["nocrop"])) {
                            $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::ADAPT)->background('#fff');
                        } else {
                            $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);

                            $image->crop($size["width"], $size["height"]);
                        }
                    }


                    if (!$nofile) {
                        $image->save($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '_' . $size["postfix"] . '.' . $fname[1], $quality = 60);

                    } else {
                        $image->save($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . 'nophoto_' . $type . '.jpg', $quality = 60);
//                            return '@app/web/uploads/nophoto_'.$type.'.jpg';
                        return 'nophoto_' . $type . '.jpg';
                    }
                }
            }
            return $fname[0] . '_' . $type . '.' . $fname[1];


        } else return $fname[0] . '_' . $type . '.' . $fname[1];
        /*
        if ($remake == true) {
            if ($msh && file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '_' . $msh . '.' . $fname[1])) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '_' . $msh . '.' . $fname[1]);
            } else if (file_exists($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '.' . $fname[1])) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '.' . $fname[1]);
            } else {
                $nofile = true;
                $file = \Yii::getAlias('@app/web/img/nophoto.jpg');
            }
            if ($ifGallery || strpos($type, 'nocrop')) {
                $file = \Yii::getAlias('@app/web/uploads/' . $fname[0] . '.' . $fname[1]);
            }
            $image = \Yii::$app->image->load($file);
            if (isset($size["nocrop"])) {
                $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::ADAPT)->background('#fff');
            } else {
                $image->resize($size["width"], $size["height"], \yii\image\drivers\Image::PRECISE);
                $image->crop($size["width"], $size["height"]);
            }
            if (!$nofile) {
                $image->save($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . $fname[0] . '_' . $size["postfix"] . '.' . $fname[1], $quality = 60);
            } else {
                $image->save($_SERVER["DOCUMENT_ROOT"] . UPLOAD_DIR . 'nophoto_' . $type . '.jpg', $quality = 60);
                return 'nophoto_' . $type . '.jpg';
            }
        }
        */
    }

    public function rules()
    {
        return [
            ['postfix', 'string'],
            ['width', 'integer'],
            ['height', 'integer'],
        ];
    }


}