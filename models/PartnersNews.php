<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class PartnersNews extends ActiveRecord
{
    public static function tableName()
    {
        return 'partners_news';
    }

    function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'';
        return $protocol.$domainName;
    }


    public  function  fields ()
    {
        $json = parent::fields ();

        $json["preview_img"] = function () {
            if ($this->preview_img)
                return $this->siteURL() . '/uploads/' . $this->preview_img;
        };

        $json["preview_img"] = function (){
            if(!$this->preview_img) return;
            $sizes = ImageSizes::find()->all();
            $array = array();
            $array[] = [
                'image' =>    $this->siteURL() . '/uploads/'.$this->preview_img
            ];
            foreach ($sizes as $size){
                if($size["postfix"] != 'mini' && $size["postfix"] != 'admin') continue;
                $imgName = explode('.', $this->preview_img);
                if(file_exists(dirname(dirname(__FILE__)) . '/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1])) {
                    $array[] = [
                        'image' => $this->siteURL() . '/uploads/' . $imgName[0] . '_' . $size["postfix"] . '.' . $imgName[1],
                        'width' => $size["width"],
                        'height' => $size["height"],
                        'postfix' => $size["postfix"]
                    ];
                }
            }
            return $array;
        };

        return $json ;
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['hidden', 'safe'],
            ['sort', 'safe'],
            ['url', 'string'],
            ['href', 'string'],
            ['preview_ing', 'safe'],
        ];
    }

//    public $searchParams = ['id', 'name', 'url', 'sort', 'hidden'];
    public $searchParams = ['id', 'name', 'url', 'sort', 'hidden', 'href'];
    public function search($query)
    {
        $res = $this->find();
        foreach ($query as $k => $queryItem) {
            if(!in_array($k, $this->searchParams)) continue;
            if($k != 'auth_token' && $k != 'page' && $k != 'sorting' && $k != 'sortingby') {
                if($queryItem[0] == '%'){
                    $res->filterWhere(['like', "$k", substr($queryItem, 1)]);
                } else {
                    $res->where(["$k" => $queryItem]);
                }
            }

        }
        $sort = false;

        if(isset($query['sorting'])) {
            $s = $query["sorting"];
            $sby = SORT_ASC;

            if(isset($query["sortingby"])){
                switch ($query["sortingby"]){
                    case 'asc':
                        $sby = SORT_ASC;
                        break;
                    case 'desc':
                        $sby = SORT_DESC;
                        break;
                }
            }

            $sort = array(
                'defaultOrder' => array("$s" => $sby)
            );
        }
        $ps = 20;
        if(isset($query["psize"])){
            $ps = $query["psize"];
        }
        return new ActiveDataProvider([
            'query' => $res,
            'pagination' => [
                'pageSize' => $ps,
            ],
            'sort' => $sort ? $sort : [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
    }

}