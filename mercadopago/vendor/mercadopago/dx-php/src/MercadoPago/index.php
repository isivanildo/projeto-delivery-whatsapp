<?php
require('../../../../../../_app/Config.inc.php');

$deletbanco->ExeDelete("bairros_delivery", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("cupom_desconto", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("views", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_adicionais_itens", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_cat", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_datas_close", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_empresa", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_formas_pagamento", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_itens", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_opcoes_itens", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_pedidos", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_pedidos_itens", "WHERE USER_ID <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE id_user <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_tipo_produto", "WHERE user_tipo_produto <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_users", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_adicionais_itens_gratis", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_adicionais_itens_gratis", "WHERE user_id <> :userid", "userid=0");

$deletbanco->ExeDelete("ws_admin", "WHERE admin_id <> :userid", "userid=0");


?>