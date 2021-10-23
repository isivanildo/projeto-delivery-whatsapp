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
	$updateacesso->EUpdaxete("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");

	unset($_SESSION['userlogin']);
	header("Location: {$site}");
endif;
?>


<script type="text/javascript">

</script>
<script src="<?=$site;?>js/MSFmultiSelect.js"></script>

<style type="text/css">
	.msf_multiselect_container .msf_multiselect {
		border: 1px solid #e4e4e4;
		list-style-type:none;
		margin: 0;
		padding: 0;
		position: absolute;
		z-index: 240;
		width: 92%;
	}
	.msf_multiselect li:hover, .sb_multiselect li:active, .sb_multiselect li:focus{
		background-color: #e5e5e5;
	}
	.msf_multiselect li.active{
		background-color: #e5e5e5;

	}
	.msf_multiselect li{
		padding-left: 4px;
		background-color: #ffffff;
		cursor: pointer;
	}
	.msf_multiselect_container textarea{
		resize: none;
		padding-left: 2px;
		padding-top: 2px;
		overflow: auto;
	}
	.msf_multiselect_container .msf_multiselect{
		height: 200px;
		overflow: auto;
		background-color: white;
		display: grid;
		text-align: left;	
	}
	.msf_multiselect label{
		display: block;
		margin-bottom: 1px;
	}

</style>

<div id="contato_do_site">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<div style="background-color:#ffffff;" class="container margin_60">     
		<div class="row"> 
			<div class="col-md-8 col-md-offset-2"> 

				<div id="success"></div>
				<div id="sendnewpass" class="indent_title_in">
					<span class="material-icons" style="color: #68CEF3; font-size: 32px;">sports_motorsports</span>
					<h3><strong>MOTOBOYS</strong></h3>
					<p>
						<b>Neste menu, você tem o controle de todos os motoboys.</b>
					</p>					
					<br />
					<form id="formaddadicional" method="post">
						<div class="row">							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="deliveryman_name">Nome do Entregador</label>
									<input required type="text" name="deliveryman_name" id="deliveryman_name" class="form-control" placeholder="Digite o nome completo do entregador" />
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="deliveryman_phone_number">Número de Telefone (Whatsapp)</label>
									<input required type="text" name="deliveryman_phone_number" id="deliveryman_phone_number" class="form-control" placeholder="(00) 00000-0000" data-mask="(00) 00000-0000" data-mask-selectonfocus="true" />
								</div>
							</div>
						</div>


						<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
						<button class="btn btn-primary">Cadastrar</button>
					</form>
					<br />
					<br />
					<br />
				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->



		<?php
		$getdadosobservacao = filter_input_array(INPUT_POST, FILTER_DEFAULT);

		if(!empty($getdadosobservacao)):	

			$getdadosobservacao = array_map('strip_tags', $getdadosobservacao);
			$getdadosobservacao = array_map('trim', $getdadosobservacao);


			if(in_array('', $getdadosobservacao)):
				echo "<script>
				x0p('Opss...', 
				'Preencha todos os campos!',
				'error', false);
				</script>";
			else:	
			    $lerbanco->FullRead("SELECT * FROM ws_motoboys WHERE user_id = :userid AND deliveryman_phone_number = :phonenumber", "userid={$userlogin['user_id']}&phonenumber={$getdadosobservacao['deliveryman_phone_number']}");
			    if ($lerbanco->getResult()) {
			        echo "<script>
					x0p('Opss...', 
					'O número de telefone já está em uso por algum outro motoboy',
					'error', false);
					</script>";
			    }
			    else {
			        $addbanco->ExeCreate("ws_motoboys", $getdadosobservacao);
    				if($addbanco->getResult()): 
    					header("Location: {$site}{$Url[0]}/add-motoboys");
    				else:
    					echo "<script>
    					x0p('Opss...', 
    					'Ocorreu um erro ao cadastrar!',
    					'error', false);
    					</script>";
    				endif;
			    }
			endif;
		endif;


		$getdelldate = filter_input(INPUT_GET, 'ex', FILTER_VALIDATE_INT);

		if(!empty($getdelldate)):
			$deletbanco->ExeDelete("ws_motoboys", "WHERE user_id = :userid AND id = :id", "userid={$userlogin['user_id']}&id={$getdelldate}");
			if($deletbanco->getResult()):
				header("Location: {$site}{$Url[0]}/add-motoboys");
			else:
				echo "<script>
				x0p('Opss...', 
				'Ocorreu um erro ao excluir o motoboy!',
				'error', false);
				</script>";
			endif;
		endif;
		?>


		<div id="contentoptions" class="form-group">
			<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
			<?php
			$lerbanco->FullRead("SELECT * FROM ws_motoboys WHERE user_id = :userid ORDER BY id DESC", "userid={$userlogin['user_id']}");
			if($lerbanco->getResult()):				
				?>		


				<div class="table-responsive">
					<table data-sortable class="table table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nome do Entregador</th>
								<th scope="col">Número de Telefone</th>
								<th scope="col">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($lerbanco->getResult() as $extractdadositens):
								extract($extractdadositens);
								?>

								<tr>	
									<td><?=$i;?></td>
									<td><?=$extractdadositens['deliveryman_name'];?></td>
									<td><?=$extractdadositens['deliveryman_phone_number'];?></td>						
                                    <td>
										<a href="<?=$site.$Url[0]."/add-motoboys&ex={$extractdadositens['id']}";?>">
											<button type="button" class="btn btn-danger btnexcluiradicional">Excluir</button>
										</a>
									</td>
									
								</tr>
								<?php
								$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
				<?php

			else:
			endif;
			?>


			<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
		</div><!-- End form-group -->
	</div>
</div><!-- End container  -->


