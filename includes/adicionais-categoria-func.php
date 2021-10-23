<?php

//header('Content-type: application/json');
require "../_app/Config.inc.php";

function listItens($user,$cat_id,$type) {
    $con = mysqli_connect(HOST,USER,PASS,DBSA);
    mysqli_set_charset($con,"utf8");
    if ($con) {
        $category = "AND ";
        for ($i = 0; $i < count($cat_id); $i++) {
            $category .= "id_cat=$cat_id[$i]";
            if ($i+1 < count($cat_id)) {
                $category .= " OR ";
            }
        }
        
        $query = mysqli_query($con,"SELECT * FROM ws_itens WHERE user_id=$user $category ORDER BY id_cat ASC");
        if ($query and mysqli_num_rows($query) > 0) {
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                array_push($arr,$row);
            }
            
            if (isset($type) and $type == 1) {
                return $arr;
            }
            
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }
        
        /*$query = mysqli_query($con,"SELECT * FROM ws_itens WHERE user_id='$user' AND id_cat=$cat_id");
        if ($query and mysqli_num_rows($query) > 0) {
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                array_push($arr,$row);
            }
            
            if (isset($type) and $type == 1) {
                return $arr;
            }
            
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }*/
    }
}

function listAdicionaisCat($user,$cat_id) {
    $con = mysqli_connect(HOST,USER,PASS,DBSA);
    mysqli_set_charset($con,"utf8");
    if ($con) {
        $category = "";
        for ($i = 0; $i < count($cat_id); $i++) {
            $category .= "id_cat=$cat_id[$i]";
            if ($i+1 < count($cat_id)) {
                $category .= " OR ";
            }
        }
        
        $query = mysqli_query($con,"SELECT * FROM ws_adicionais_cat WHERE (user_id=$user AND pay=0) AND ($category) ORDER BY name_adicionais_cat ASC");
        if ($query and mysqli_num_rows($query) > 0) {
            /*$arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                array_push($arr,$row);
            }
            
            if (isset($type) and $type == 1) {
                return $arr;
            }
            
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));*/
            
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                isset($arr['addt_cats']) ? array_push($arr['addt_cats'],$row) : $arr['addt_cats'][0] = $row;
            }
            
            $arr_itens = listItens($user,$cat_id,1);
            for ($i = 0; $i < count($arr_itens); $i++) {
                isset($arr['list_itens']) ? array_push($arr['list_itens'],$arr_itens[$i]) : $arr['list_itens'][0] = $arr_itens[$i];
            }
            
            header('Content-type: application/json');
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }
        else {
            return print_r(json_encode($category));
        }
        
        /*$query = mysqli_query($con,"SELECT * FROM ws_adicionais_cat WHERE user_id='$user' AND id_cat=$cat_id AND pay=0");
        if ($query and mysqli_num_rows($query) > 0) {
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                //array_push($arr,$row);
                //$arr['addt_cats'][count($arr)] = $row;
                isset($arr['addt_cats']) ? array_push($arr['addt_cats'],$row) : $arr['addt_cats'][0] = $row;
            }
            
            $arr_itens = listItens($user,$cat_id,1);
            for ($i = 0; $i < count($arr_itens); $i++) {
                //$arr['list_itens'][(isset($arr['list_itens']) ? count($arr['list_itens']) : 0)] = $arr_itens[$i];
                isset($arr['list_itens']) ? array_push($arr['list_itens'],$arr_itens[$i]) : $arr['list_itens'][0] = $arr_itens[$i];
            }
            
            header('Content-type: application/json');
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }
        else {
            return print_r(json_encode(0));
        }*/
    }
}

function listAdicionaisCatP($user,$cat_id) {
    $con = mysqli_connect(HOST,USER,PASS,DBSA);
    mysqli_set_charset($con,"utf8");
    if ($con) {
        $category = "";
        for ($i = 0; $i < count($cat_id); $i++) {
            $category .= "id_cat=$cat_id[$i]";
            if ($i+1 < count($cat_id)) {
                $category .= " OR ";
            }
        }
        
        $query = mysqli_query($con,"SELECT * FROM ws_adicionais_cat WHERE (user_id=$user AND pay=1) AND ($category) ORDER BY name_adicionais_cat ASC");
        if ($query and mysqli_num_rows($query) > 0) {
            /*$arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                array_push($arr,$row);
            }
            
            if (isset($type) and $type == 1) {
                return $arr;
            }
            
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));*/
            
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                isset($arr['addt_cats']) ? array_push($arr['addt_cats'],$row) : $arr['addt_cats'][0] = $row;
            }
            
            $arr_itens = listItens($user,$cat_id,1);
            for ($i = 0; $i < count($arr_itens); $i++) {
                isset($arr['list_itens']) ? array_push($arr['list_itens'],$arr_itens[$i]) : $arr['list_itens'][0] = $arr_itens[$i];
            }
            
            header('Content-type: application/json');
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }
        else {
            return print_r(json_encode($category));
        }
        
        /*$query = mysqli_query($con,"SELECT * FROM ws_adicionais_cat WHERE user_id='$user' AND id_cat=$cat_id AND pay=1");
        if ($query and mysqli_num_rows($query) > 0) {
            $arr = array();
            while ($row = mysqli_fetch_assoc($query)) {
                //array_push($arr,$row);
                //$arr['addt_cats'][count($arr)] = $row;
                isset($arr['addt_cats']) ? array_push($arr['addt_cats'],$row) : $arr['addt_cats'][0] = $row;
            }
            
            $arr_itens = listItens($user,$cat_id,1);
            for ($i = 0; $i < count($arr_itens); $i++) {
                //$arr['list_itens'][(isset($arr['list_itens']) ? count($arr['list_itens']) : 0)] = $arr_itens[$i];
                isset($arr['list_itens']) ? array_push($arr['list_itens'],$arr_itens[$i]) : $arr['list_itens'][0] = $arr_itens[$i];
            }
            
            header('Content-type: application/json');
            return print_r(json_encode($arr,JSON_PRETTY_PRINT));
        }
        else {
            return print_r(json_encode(0));
        }*/
    }
}

if (isset($_POST)) {
    if (isset($_POST['action']) and $_POST['action'] == "list") {
        if (empty($_POST['user_id']) or empty($_POST['cat_id'])) {
            return false;
        }
        listItens($_POST['user_id'],$_POST['cat_id'],null);
    }
    else if (isset($_POST['action']) and $_POST['action'] == "listAdicionaisCat") {
        if (empty($_POST['user_id']) or empty($_POST['cat_id'])) {
            return false;
        }
        listAdicionaisCat($_POST['user_id'],$_POST['cat_id']);
    }
    else if (isset($_POST['action']) and $_POST['action'] == "listAdicionaisCatP") {
        if (empty($_POST['user_id']) or empty($_POST['cat_id'])) {
            return false;
        }
        listAdicionaisCatP($_POST['user_id'],$_POST['cat_id']);
    }
}

?>