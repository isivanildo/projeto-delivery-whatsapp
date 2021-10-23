<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$site = HOME;

$address = (object)[
	'erro' => '',
	'cep' => '',
	'logradouro' => '',
	'bairro' => '',
	'localidade' => '',
	'uf' => ''
];


if(!empty($_POST['valor_do_cep'])){

	$pesquisa = strip_tags(trim($_POST['valor_do_cep']));
	$pesquisa = preg_replace('/[^0-9]/','',$pesquisa);


	$url = "https://viacep.com.br/ws/{$pesquisa}/json/";

	$address = json_decode(file_get_contents($url));

$erro   = (!empty($address->erro) ? $address->erro : ''); // == 1 quando não encontrar
$cidade = (!empty($address->localidade) ? $address->localidade : '');
$estado = (!empty($address->uf) ? $address->uf : '');

if(!empty($erro) && $erro == 1):
	echo 1;
else:

	$lerbanco->FullRead("select * from ws_empresa WHERE cidade_empresa = :cidade AND end_uf_empresa = :uf", "cidade={$cidade}&uf={$estado}");
	if(!$lerbanco->getResult()):
		echo 2;
	else:	

		?>

		<!-- Content ================================================== -->
		<div class="container margin_60_35">
			<div class="main_title">
				<h2 class="nomargin_top">Restaurantes perto de você:</h2>
				<p>

				</p>
			</div>
			<div class="row">
				<div class="col-md-12">
					

					<?php
					foreach ($lerbanco->getResult() as $i):
						extract($i);
						?>

						<div class="strip_list wow fadeIn" data-wow-delay="0.1s">
							<div class="row">
								<div class="col-md-9 col-sm-9">
									<div class="desc">
										<?php
										if(!empty($img_logo)):
											echo "<div class=\"thumb_strip\"><img width=\"240\" height=\"240\" src=\"{$site}uploads/{$img_logo}\" alt=\"\"></div>";
										else:
											echo "<div class=\"thumb_strip\"><img src=\"{$site}img/thumb_restaurant.jpg\" alt=\"\"></div>";
										endif;
										?>
										

										<h3><?=(!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');?></h3>

										<div class="location">
											Rua <?=$end_rua_n_empresa;?>
											<?=$end_bairro_empresa;?> - <?=$cidade_empresa;?> - <?=$end_uf_empresa;?> <br />

											<?php
            // REQUERIDOS
    // Definir horário de funcionamento diário
    // Deve estar no formato de 24 horas, separado por traço
    // Se fechado para o dia, deixe em branco (por exemplo, domingo) ou não adicione linha
    // Se aberto várias vezes em um dia, insira intervalos de tempo separados por vírgula



											$hours = array();      



         //CONFIGURAÇÃO DE SEGUNDA FEIRA
											if(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "false"):
												$hours['mon'] = array();
										elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "true"):
											$hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate, $segunda_tarde_de.'-'.$segunda_tarde_ate);

									elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "false"):
										$hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate);
								elseif(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "true"):
									$hours['mon'] = array($segunda_tarde_de.'-'.$segunda_tarde_ate);
							endif;
        //CONFIGURAÇÃO DE SEGUNDA FEIRA

        //CONFIGURAÇÃO DE TERÇA FEIRA
							if(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "false"):
								$hours['tue'] = array();
						elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "true"):
							$hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate, $terca_tarde_de.'-'.$terca_tarde_ate);

					elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "false"):
						$hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate);
				elseif(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "true"):
					$hours['tue'] = array($terca_tarde_de.'-'.$terca_tarde_ate);
			endif;
        //CONFIGURAÇÃO DE TERÇA FEIRA

         //CONFIGURAÇÃO DE QUARTA FEIRA
			if(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "false"):
				$hours['wed'] = array();
		elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "true"):
			$hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate, $quarta_tarde_de.'-'.$quarta_tarde_ate);

	elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "false"):
		$hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate);
elseif(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "true"):
	$hours['wed'] = array($quarta_tarde_de.'-'.$quarta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUARTA FEIRA

         //CONFIGURAÇÃO DE QUINTA FEIRA
if(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "false"):
	$hours['thu'] = array();
elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "true"):
	$hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate, $quinta_tarde_de.'-'.$quinta_tarde_ate);

elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "false"):
	$hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate);
elseif(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "true"):
	$hours['thu'] = array($quinta_tarde_de.'-'.$quinta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUINTA FEIRA

        //CONFIGURAÇÃO DE SEXTA FEIRA
if(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "false"):
	$hours['fri'] = array();
elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "true"):
	$hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate, $sexta_tarde_de.'-'.$sexta_tarde_ate);

elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "false"):
	$hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate);
elseif(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "true"):
	$hours['fri'] = array($sexta_tarde_de.'-'.$sexta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SEXTA FEIRA

         //CONFIGURAÇÃO DE SABADO
if(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "false"):
	$hours['sat'] = array();
elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "true"):
	$hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate, $sabado_tarde_de.'-'.$sabado_tarde_ate);

elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "false"):
	$hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate);
elseif(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "true"):
	$hours['sat'] = array($sabado_tarde_de.'-'.$sabado_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SABADO

        //CONFIGURAÇÃO DE DOMINGO
if(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "false"):
	$hours['sun'] = array();
elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "true"):
	$hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate, $domingo_tarde_de.'-'.$domingo_tarde_ate);

elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "false"):
	$hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate);
elseif(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "true"):
	$hours['sun'] = array($domingo_tarde_de.'-'.$domingo_tarde_ate);
endif;
        //CONFIGURAÇÃO DE DOMINGO

$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :delivdata", "delivdata={$user_id}");
$exceptions = array();
if($lerbanco->getResult()):
	foreach($lerbanco->getResult() as $dadosC):
		extract($dadosC);
		$i = explode('/', $data);
		$i = array_reverse($i);
		$i = implode("-", $i);							

		if(isDateExpired($i, 1)):
			$exceptions["{$i}"] = array();							
		endif;
	endforeach;
endif;


					// Iniciando a classe
$store_hours = new StoreHours($hours, $exceptions);


					 // Display open / closed menssagem
if($store_hours->is_open()) {
	echo "<span style='color:#86c953;'>ABERTO AGORA</span>";
} else {
	echo "<span class=\"opening\">FECHADO</span>";
}
?>   


<?=(!empty($minimo_delivery) && $minimo_delivery != '0.00' ? "- Valor mínimo Delivery: R$ ".Check::Real($minimo_delivery) : '');?>
</div>
<ul> 
	<?php if(!empty($confirm_delivery) && $confirm_delivery == "true"): ?>

		<li>Delivery<i class="icon_check_alt2 ok"></i></li>
		<?php else: ?>
			<li>Delivery<i class="icon_check_alt2 no"></i></li>
		<?php endif; ?>



		<?php if(!empty($confirm_balcao) && $confirm_balcao == "true"): ?>
			<li>Retirar no Balcão<i class="icon_check_alt2 ok"></i></li>
			<?php else: ?>
				<li>Retirar no Balcão<i class="icon_check_alt2 no"></i></li>
			<?php endif; ?>

		</ul>
	</div>
</div>
<div class="col-md-3 col-sm-3">
	<div class="go_to">
		<div>
			<a href="<?=$site.$nome_empresa_link?>" class="btn_1">Ver Cardápio</a>
		</div>
	</div>
</div>
</div><!-- End row-->
</div><!-- End strip_list-->
<?php endforeach; ?>

</div><!-- End col-md-12-->
</div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->

<?php

endif;
endif;

}
?>




<?php
ob_end_flush();
?>