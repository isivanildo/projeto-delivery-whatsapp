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


$lerbanco->ExeRead('ws_fuso_horario', "WHERE user_id = :useridd", "useridd={$userlogin['user_id']}");
if(!$lerbanco->getResult()):
else:
	foreach ($lerbanco->getResult() as $dadosC):
		extract($dadosC);
	endforeach;
endif;
?>


<div id="contato_do_site">
	<div style="background-color:#ffffff;" class="container margin_60">   		 
		<div class="row"> 
			<div class="col-md-8 col-md-offset-2">  				
				<div id="sendnewpass" class="indent_title_in">

					<h3><strong>Fuso horário</strong> </h3>
					<p>
						<b>Altere o fuso horário para o da sua região.</b> 
					</p>
					<h3><strong>Hora atual: </strong> <b style="color: green;"><?=date("H:i:s");?></b> </h3>
					<br />
					<?php
					$getfuso = filter_input_array(INPUT_POST, FILTER_DEFAULT);

					if(!empty($getfuso)):
						$getfuso = array_map('strip_tags', $getfuso);
						$getfuso = array_map('trim', $getfuso);

						if(in_array('', $getfuso)):
							echo "<script>
							x0p('Opss...', 
							'Preencha o campo abaixo!',
							'error', false);
							</script>";
						else:
							$getfuso['user_id'] = $userlogin['user_id'];

							$lerbanco->ExeRead('ws_fuso_horario', "WHERE user_id = :useridd", "useridd={$userlogin['user_id']}");
							if(!$lerbanco->getResult()):
								$addbanco->ExeCreate("ws_fuso_horario", $getfuso);
								header("Location: {$site}{$Url[0]}/fuso-horario"); 
							else:
								$updatebanco->ExeUpdate("ws_fuso_horario", $getfuso, "WHERE user_id = :uuserid", "uuserid={$userlogin['user_id']}");
								header("Location: {$site}{$Url[0]}/fuso-horario"); 
							endif;						

						endif;
					endif;
					?>
					<form method="post">
						<div class="form-group">
							<label>Fuso Horário</label>
							<div class="styled-select">
								<select class="form-control" name="fuso_horario" required>	
									<option></option>

									<?php
									$timezones = array(
										'AC' => 'America/Rio_branco',   'AL' => 'America/Maceio',
										'AP' => 'America/Belem',        'AM' => 'America/Manaus',
										'BA' => 'America/Bahia',        'CE' => 'America/Fortaleza',
										'DF' => 'America/Sao_Paulo',    'ES' => 'America/Sao_Paulo',
										'GO' => 'America/Sao_Paulo',    'MA' => 'America/Fortaleza',
										'MT' => 'America/Cuiaba',       'MS' => 'America/Campo_Grande',
										'MG' => 'America/Sao_Paulo',    'PR' => 'America/Sao_Paulo',
										'PB' => 'America/Fortaleza',    'PA' => 'America/Belem',
										'PE' => 'America/Recife',       'PI' => 'America/Fortaleza',
										'RJ' => 'America/Sao_Paulo',    'RN' => 'America/Fortaleza',
										'RS' => 'America/Sao_Paulo',    'RO' => 'America/Porto_Velho',
										'RR' => 'America/Boa_Vista',    'SC' => 'America/Sao_Paulo',
										'SE' => 'America/Maceio',       'SP' => 'America/Sao_Paulo',
										'TO' => 'America/Araguaia',    
									);

									foreach ($timezones as $key => $value):
										echo "<option value=\"{$value}\">{$key}</option>";
									endforeach;
									?>
								</select>
							</div>
						</div>				
						<div class="form-group">							
							<button type="submit" class="btn btn-success">Atualizar</button>
							<br />
							<br />
							<p>Atualize e Confirme se o horário esta correto</p>
						</div>
					</form>
					<br />				
					<br />

					<br />

				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->
	</div>

</div><!-- End container  -->