<?php


$mysql = new mysqli('localhost', 'userbeadmin', 'sap2HyutFV!lUJ)', 'dbbeadmin');
$mysql2 = new mysqli('localhost', 'userbeicon', 'puf{O5!q@1&P_=6', 'dbbeicon');

$res = $mysql->query("SELECT * FROM `_storys` where `razdel` = 'new_year'");

$array = [];

while ($row = $res->fetch_object()){
//    $array[] = $row;
//    echo '<pre>';
//    print_r($row);

    $mysql2->query("UPDATE `articles` SET `section` = '3' WHERE `name` = '$row->name' LIMIT 1");
//    $res2 = $mysql2->query("SELECT * FROM `articles` WHERE `name` = '$row->name'");
//    print_r($res2->fetch_object());

//    echo '</pre>';
//    die();
}



//file_put_contents('tags.json', json_encode($array));