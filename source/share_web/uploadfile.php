<?php
/**
 * Created by PhpStorm.
 * User: chunyu
 * Date: 15/11/26
 * Time: 下午3:03
 */
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Content-Type:application/json; charset=UTF-8');
header('Access-Control-Allow-Headers:MDATA-KEY');
$date = date("ymdhis");
//echo($date);
$url = "";
$uptype = explode(".", $_FILES["pic"]["name"]);
$newname = md5($date . $uptype[0]) . "." . $uptype[1];
$_FILES["pic"]["name"] = $newname;
if (file_exists("pics/".date("Y-m-d").'/' . $_FILES["pic"]["name"])) {
    $code = 0;
    $msg = 'error';
} else {
    if(!file_exists("pics/".date("Y-m-d"))){
        mkdir("pics/".date("Y-m-d"),0775);
    }
    $_FILES["pic"]["name"] = move_uploaded_file($_FILES["pic"]["tmp_name"], "pics/".date("Y-m-d").'/' . $_FILES["pic"]["name"]);
    if(!file_exists("pics/".date("Y-m-d").'/'.$_FILES["pic"]["name"])){
        $picUrl = "http://niceshare.goextension.com/pics/".date("Y-m-d").'/' . $newname;
        $code = 1;
        $msg = 'success';
        $data = ["status" => "success", "pic" => $picUrl];

    }else{
        $code = 0;
        $msg = 'error';
        $data = '';
    }
}

$config = array(
    'code' => $code,
    'msg' => $msg,
    'data' => $data
);
echo  json_encode($config);
?>
