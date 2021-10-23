<?php
$login = new Login(3);

if(!$login->CheckLogin()):
	unset($_SESSION['userlogin']);
	header("Location: {$site}");
else:
	$userlogin = $_SESSION['userlogin'];
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);

if(!empty($logoff) && $logoff == true):
	$updateacesso = new Update;
	$dataEhora    = date('d/m/Y H:i');
	$ip           = get_client_ip();
	$string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
	$updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");

	unset($_SESSION['userlogin']);
	header("Location: {$site}");
endif;
?>

<div id="contato_do_site">
	<div style="background-color:#ffffff;" class="container margin_60">   		 
		<div class="row"> 
			<div class="col-md-8 col-md-offset-2">  				
				<div id="sendnewpass" class="indent_title_in">

					<h3><strong>Alterar plano</strong> </h3>
					<p>
						<b>Altere seu plano abaixo</b> 
					</p>
					<br />
					<?php
					$getformapagamento = filter_input_array(INPUT_POST, FILTER_DEFAULT);

					if(!empty($getformapagamento)):
						$getformapagamento = array_map('strip_tags', $getformapagamento);
						$getformapagamento = array_map('trim', $getformapagamento);

						if(in_array('', $getformapagamento)):
							echo "<script>
							x0p('Opss...', 
							'Preencha o campo abaixo!',
							'error', false);
							</script>";
						else:

							$updatebanco->ExeUpdate("ws_users", $getformapagamento, "WHERE user_id = :up", "up={$userlogin['user_id']}");
							if ($updatebanco->getResult()):
								echo "<script>x0p('Sucesso!', 
								'O seu plano foi atualizado. saindo...', 
								'ok', false);</script>";
								header("Refresh: 5; url={$site}{$Url[0]}/admin-loja&logoff=true");
							else:
								echo "<script>
								x0p('Opss...', 
								'Ocorreu um Erro!',
								'error', false);
								</script>";
								header("Refresh: 5; url={$site}{$Url[0]}/alterar-plano");
							endif;

							

						endif;

					endif;
					?>
					<form method="post">
						<div class="form-group">
							<label for="nome_empresa">MEU PLANO</label>
							<select name="user_plano" class="form-control" >
								<option <?=(!empty($userlogin['user_plano']) && $userlogin['user_plano'] == 1 ? "selected" : "");?> value="1"><?=$texto['nomePlanoUm']." = R$ ".$texto['valorPlanoUm'].",00";?></option>
								<option <?=(!empty($userlogin['user_plano']) && $userlogin['user_plano'] == 2 ? "selected" : "");?> value="2"><?=$texto['nomePlanoDois']." = R$ ".$texto['valorPlanoDois'].",00";?></option>
								<option <?=(!empty($userlogin['user_plano']) && $userlogin['user_plano'] == 3 ? "selected" : "");?> value="3"><?=$texto['nomePlanoTres']." = R$ ".$texto['valorPlanoTres'].",00";?></option>
							</select>
						</div>	
						<?php
						$nplano = "";
						if($userlogin['user_plano'] == 1):
							$nplano = $texto['nomePlanoUm'];
						elseif($userlogin['user_plano'] == 2):
							$nplano =	$texto['nomePlanoDois'];
						else:
							$nplano =	$texto['nomePlanoTres'];
						endif;
						?>				
						<div class="form-group">							
							<button type="submit" class="btn btn-danger">Alterar Meu Plano</button>
							<a class="btn btn-success" style="color:#ffffff;" target="_blank" href="https://api.whatsapp.com/send?phone=<?=$texto['telefoneAdministracaoVendas'];?>&text=Solicito%20o%20boleto%20banc%C3%A1rio%20para%20pagamento.%0A%0A*Loja:*%20<?=(!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');?>%0A*Plano:*%20<?=$nplano;?>">
								Solicitar Boleto Bancário
							</a>
						</div>
					</form>
					<img src="<?=$site?>img/bandeiras-mercado-pago.png" style="max-width: 400px;height: auto;" />
					<br />				
					<br />
					<p style="color: red;">** O prazo para confirmação de pagamento via boleto pode levar até 05 dias úteis. Evite suspensão de seu plano.<br />
					** Pagamentos com o cartão de crédito, será exibido um botão do checkout 3 dias antes do seu vencimento e ativação é imediata.</p>
					<br />

				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->
	</div>

</div><!-- End container  -->