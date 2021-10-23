<?php

function findCep($cep) {
    $cep = str_replace(".","",$cep);
    $cep = str_replace("-","",$cep);
    $url = "https://viacep.com.br/ws/$cep/json/";
    
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url);
    // define que o conteúdo obtido deve ser retornado em vez de exibido
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    $order = curl_exec($ch); //Pega a string JSON obtida.
    curl_close($ch);
    $arr = json_decode($order, true); //transforma a string em um array associativo.
    
    return print_r(json_encode($arr));
}

if (isset($_POST) and isset($_POST['cep']) and $_POST['cep'] != "") {
    findCep($_POST['cep']);
}

?>