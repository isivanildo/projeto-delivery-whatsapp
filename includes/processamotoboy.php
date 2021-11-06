<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$detect = new Mobile_Detect;
$site = HOME;

$login = new Login(3);

//Verifica se o usuário está logado ou não
if($login->CheckLogin()):
    $userlogin = $_SESSION['userlogin']['user_id'];
    $lerbanco->ExeRead('ws_empresa', "WHERE user_id = :idcliente", "idcliente={$userlogin}");
    if (!$lerbanco->getResult()):       
    else:
      foreach ($lerbanco->getResult() as $i):
        extract($i);
      endforeach;
    endif;
  else:
  endif;


$idUser = $userlogin;
$idMotoboy = !empty($_POST['idMotoboy']) ? $_POST['idMotoboy'] : "";

$nameMotoboy = !empty($_POST['nameMotoboy']) ? $_POST['nameMotoboy'] : "";
$phoneMotoboy = !empty($_POST['phoneMotoboy']) ? $_POST['phoneMotoboy'] : "";

$registro = !empty($_POST['idRegistro']) ? $_POST['idRegistro'] : "";

$getDadosMotoboy = array();
$getDadosMotoboy["user_id"] = $idUser;
$getDadosMotoboy["motoboy_name"] = $nameMotoboy;
$getDadosMotoboy["motoboy_phone_number"] = $phoneMotoboy;

//Instruções executadas caso seja um novo registro, atualização pu exclusão

if ($registro == "novo") {
    if (!in_array('', $getDadosMotoboy)):
        $addbanco->ExeCreate('ws_motoboys', $getDadosMotoboy);
        if ($addbanco->getResult()):
            $getDadosMotoboy["mensagem"] = "ok1";
            $getDadosMotoboy["urlCliente"] = "{$site}{$nome_empresa_link}";          
        else:
            $getDadosMotoboy["mensagem"] = "erro1";
        endif;
        echo (json_encode($getDadosMotoboy));
    endif;
}elseif ($registro == "update") {
    if (!in_array('', $getDadosMotoboy)):
        $updatebanco->ExeUpdate("ws_motoboys", $getDadosMotoboy, "WHERE user_id = :userid AND id = :id", "userid={$idUser}&id={$idMotoboy}");
        if ($updatebanco->getResult()):
            $getDadosMotoboy["mensagem"] = "ok2";
            $getDadosMotoboy["urlCliente"] = "{$site}{$nome_empresa_link}";
        else:
            $getDadosMotoboy["mensagem"] = "erro2";
        endif;
        echo (json_encode($getDadosMotoboy));
    endif;
}elseif ($registro == "delete") {
    $deletbanco->ExeDelete("ws_motoboys", "WHERE user_id = :userid AND id = :id", "userid={$idUser}&id={$idMotoboy}");
    if ($deletbanco->getResult()) {
        $getDadosMotoboy["mensagem"] = "true";
        $getDadosMotoboy["urlCliente"] = "{$site}{$nome_empresa_link}";
    }else {
        $getDadosMotoboy["mensagem"] = "false";
        $getDadosMotoboy["urlCliente"] = "{$site}{$nome_empresa_link}";
    }
    echo (json_encode($getDadosMotoboy));
}


//Instrução exwcutada caso seja modo de edição]/*

if ($registro == "editar") {
    $getDadosMotoboy = [];
    $lerbanco->ExeRead("ws_motoboys", "WHERE user_id = :userid and id = :id", "userid={$idUser}&id={$idMotoboy}");

    if (!$lerbanco->getResult()):
	echo '<script type="text/javascript">alert("Ocorreu um erro ao localizar endereço!")</script>';
    echo $userlogin;
    else:
	foreach($lerbanco->getResult() as $i):
		extract($i);
	endforeach;

    $LocalEmArray = array();
    $LocalEmArray['id'] = $id;
    $LocalEmArray['userId'] = $user_id;
    $LocalEmArray['nomeMotoboy'] = $motoboy_name;
    $LocalEmArray['telefone'] = $motoboy_phone_number;
    $LocalEmArray["urlCliente"] =  "{$site}{$nome_empresa_link}";

    echo json_encode($LocalEmArray);

endif;
}

ob_end_flush();