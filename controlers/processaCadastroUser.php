<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$site = HOME;


$inputDadosCadastro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$linkuser = strip_tags(trim($inputDadosCadastro['nome_empresa_link']));
$linkuser = remove_especial_char(remove_accents($linkuser));
$linkuser = str_replace(' ', '', $linkuser);

$inputDadosCadastro['nome_empresa_link'] = $linkuser;

if(!empty($inputDadosCadastro)): //PRIMEIRO IF INICIO
	$inputDadosCadastro = array_map('strip_tags', $inputDadosCadastro);
	$inputDadosCadastro = array_map('trim', $inputDadosCadastro);	

	if (in_array('', $inputDadosCadastro) || in_array('null', $inputDadosCadastro)): //SEGUNDO IF INICIO
		echo "erro1";
	elseif(!Check::Email($inputDadosCadastro['user_email']))://SEGUNDO IF 
		echo "erro2";
	elseif(strlen($inputDadosCadastro['user_password']) <= 7)://SEGUNDO IF 
		echo "erro3";
	elseif($inputDadosCadastro['user_password'] != $inputDadosCadastro['user_password2'])://SEGUNDO IF 
		echo "erro4";
	elseif(!ValidaDados::valida($inputDadosCadastro['user_cpf'])):
		echo "erro66";
	else://SEGUNDO IF 

		$lerbanco->ExeRead('ws_empresa', "WHERE binary nome_empresa_link = :linkuser", "linkuser={$linkuser}");//TERCEIRO IF INICIO
		if($lerbanco->getResult()):
			echo "erro5";
		else://TERCEIRO IF


			$lerbanco->ExeRead('ws_users', "WHERE user_email = :useremail", "useremail={$inputDadosCadastro['user_email']}");
			if($lerbanco->getResult()):// QUARTO IF INICIO
				echo "erro6";
		    else: // QUARTO IF

		    	//AQUI COMEÇO A FAZER DE FATO O CADASTRO DO NOVO USUÁRIO -----------------------

		       // INICIO ARRAY DO USUARIO.
		    	$cadatroUsuario = array();
		    	$cadatroUsuario['user_name'] = $inputDadosCadastro['user_name'];
		    	$cadatroUsuario['user_lastname'] = $inputDadosCadastro['user_lastname'];
				$cadatroUsuario['user_cpf'] = $inputDadosCadastro['user_cpf'];
		    	$cadatroUsuario['user_email'] = $inputDadosCadastro['user_email'];
		    	$cadatroUsuario['user_telefone'] = $inputDadosCadastro['user_telefone'];
		    	$cadatroUsuario['user_password'] = md5($inputDadosCadastro['user_password']);
		    	$cadatroUsuario['user_plano'] = $inputDadosCadastro['user_plano'];
		    	$cadatroUsuario['user_level'] = 3;
		    	$cadatroUsuario['user_registration'] = date('Y-m-d H:i:s');
		    	// FIM ARRAY DO USUARIO.

		    	//INICIO ARRAY DA EMPRESA
		    	$cadatroUsuarioEmpresa = array();
		    	$cadatroUsuarioEmpresa['nome_empresa'] = $inputDadosCadastro['nome_empresa'];
		    	$cadatroUsuarioEmpresa['nome_empresa_link'] = $inputDadosCadastro['nome_empresa_link'];
				$cadatroUsuarioEmpresa['end_rua_n_empresa'] = $inputDadosCadastro['end_rua_n_empresa'];
				$cadatroUsuarioEmpresa['cidade_empresa'] = $inputDadosCadastro['cidade_empresa'];
				$cadatroUsuarioEmpresa['end_uf_empresa'] = $inputDadosCadastro['end_uf_empresa'];
		    	$cadatroUsuarioEmpresa['end_bairro_empresa'] = $inputDadosCadastro['end_bairro_empresa'];
				$cadatroUsuarioEmpresa['cep_empresa'] = $inputDadosCadastro['cep'];
		    	$cadatroUsuarioEmpresa['email_empresa'] = $inputDadosCadastro['user_email'];
		    	$cadatroUsuarioEmpresa['telefone_empresa'] = preg_replace("/[^0-9]/", "", $inputDadosCadastro['user_telefone']);
		    	$cadatroUsuarioEmpresa['empresa_data_renovacao'] = date("Y-m-d", strtotime("+{$texto['DiasDeTeste']} days"));


		    	//FIM ARRAY DA EMPRESA falta >   

		    	 $addbanco->ExeCreate("ws_users", $cadatroUsuario);

		    	 if(!$addbanco->getResult()):
		    	 	echo "erro0";
		    	 else:

		    	 	$cadatroUsuarioEmpresa['user_id'] = $addbanco->getResult();
		    	 	$addbanco->ExeCreate("ws_empresa", $cadatroUsuarioEmpresa);
		    	 	if(!$addbanco->getResult()):
		    	 		echo "erro0";
		    	 	else:
		    	 		
		    	 		echo "sucesso";
		    	 	endif;

		    	 endif;     


		    	//AQUI TERMINO A FAZER DE FATO O CADASTRO DO NOVO USUÁRIO ----------------------


		    	print_r($inputDadosCadastro);
		    endif;// QUARTO IF FIM

			
		endif;//TERCEIRO IF FIM

		
	endif;//SEGUNDO IF FIM


endif;//PRIMEIRO IF FIM

ob_end_flush();
?>