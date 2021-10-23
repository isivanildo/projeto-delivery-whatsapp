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


<?php
$getdel = filter_input(INPUT_GET, 'idexcluir', FILTER_VALIDATE_INT);
if(!empty($getdel)):

	$deletbanco->ExeDelete("ws_opcao_complemento", "WHERE user_id = :userid AND id_opcao_complemento = :idadicional", "userid={$userlogin['user_id']}&idadicional={$getdel}");
	if($deletbanco->getResult()):
		header("Location: {$site}{$Url[0]}/add-complemento-unico");
	else:
		echo "<script>
		x0p('Opss...', 
		'Ocorreu um erro ao cadastrar!',
		'error', false);
		</script>";
	endif;

endif;
?>

<?php
$getpausar = filter_input(INPUT_GET, 'idpausar', FILTER_VALIDATE_INT);
if(!empty($getpausar)):

	$lerbanco->ExeRead("ws_opcao_complemento", "WHERE user_id = :userid AND id_opcao_complemento  = :idadicionalgratis", "userid={$userlogin['user_id']}&idadicionalgratis={$getpausar}");
if(!$lerbanco->getResult()):
	echo "<script>
			x0p('Opss...', 
			'Item não encontrado!',
			'error', false);
			</script>";
else:
	$dadosgetadicional = $lerbanco->getResult();

	$getdadospauseAd['status_opcao_complemento'] = ($dadosgetadicional[0]['status_opcao_complemento'] == 1 ? 0 : 1);

	$updatebanco->ExeUpdate("ws_opcao_complemento", $getdadospauseAd, "WHERE user_id = :userid AND id_opcao_complemento = :idadicional", "userid={$userlogin['user_id']}&idadicional={$getpausar}");

	if($updatebanco->getResult()):                                                
		header("Location: {$site}{$Url[0]}/add-complemento-unico");      
	else:
		echo "<script>
		x0p('Opss...', 
		'Ocorreu um erro ao cadastrar!',
		'error', false);
		</script>";      
	endif;

endif;

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
	<div style="background-color:#ffffff;" class="container margin_60">     
		<div class="row"> 
			<div class="col-md-8 col-md-offset-2"> 

				<div id="success"></div>
				<div id="sendnewpass" class="indent_title_in">
					<i class="icon-plus-squared"></i>
					<h3><strong>Complemento ou condição única</strong></h3>
					<p>
						<b>Adicione complementos ou condições onde o cliente escolhe uma opção.</b>
					</p>					
					<br />
					<form id="formaddadicional" method="post">
						<div class="row">							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="nome_opcao_complemento">Nome</label>
									<input required type="text" name="nome_opcao_complemento" id="nome_opcao_complemento" class="form-control" placeholder="Exe: Boi bem passado, Carne de frango, etc" />
									<small class="form-text text-muted">
										
									</small>
								</div>
							</div>

						</div>	
						
						<div>
							<div>
								<label for="categorias_adicional_opcao_complemento">Categoria</label>
								<div id="myselect">
									<select required class="form-control"  id="multiselect" name="categorias_adicional_opcao_complemento[]" multiple="multiple"">									
										<?php
										$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
										if (!$lerbanco->getResult()):
											echo "<option value=\"\">Cadastre categorias</option>";
										else:										
											foreach ($lerbanco->getResult() as $cat):
												extract($cat);
												echo "<option value=\"{$id}\"> {$nome_cat}</option>";
											endforeach;
										endif;
										?>
									</select>
								</div>
								<small class="form-text text-muted">
									Selecione as categorias para vincular.
								</small>
								
							</div>
						</div>
						<div>					

						</div>

						<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
						<input type="hidden" name="status_opcao_complemento" value="1">
						<button class="btn btn-primary">Cadastrar</button>
					</form>
					<br />
					<br />
					<br />
				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->



		<?php
		$getdadosAddadicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);

		if(!empty($getdadosAddadicional)):	

			$getdadosAddadicional['nome_opcao_complemento'] = trim($getdadosAddadicional['nome_opcao_complemento']);
			$getdadosAddadicional['nome_opcao_complemento'] = strip_tags($getdadosAddadicional['nome_opcao_complemento']);


			if(empty($getdadosAddadicional['nome_opcao_complemento']) || empty($getdadosAddadicional['categorias_adicional_opcao_complemento'])):
				echo "<script>
			x0p('Opss...', 
			'Preencha todos os campos!',
			'error', false);
			</script>";
		else:
			$getdadosAddadicional['categorias_adicional_opcao_complemento'] = implode(', ', $getdadosAddadicional['categorias_adicional_opcao_complemento']);		

			$addbanco->ExeCreate("ws_opcao_complemento", $getdadosAddadicional);
			if($addbanco->getResult()): 
				header("Location: {$site}{$Url[0]}/add-complemento-unico");
			else:
				echo "<script>
				x0p('Opss...', 
				'Ocorreu um erro ao cadastrar!',
				'error', false);
				</script>";
			endif;
		endif;
	endif;
	?>


	<div id="contentoptions" class="form-group">
		<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
		<?php
		$lerbanco->FullRead("SELECT * FROM ws_opcao_complemento WHERE user_id = :userid ORDER BY id_opcao_complemento   DESC", "userid={$userlogin['user_id']}");
		if($lerbanco->getResult()):				
			?>		


			<div class="table-responsive">
				<table data-sortable class="table table-hover table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Categorias vinculadas</th>

							<th scope="col">Nome</th>


							<th scope="col">Excluir</th>
							<th scope="col">Pausar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($lerbanco->getResult() as $extractdadositens):
							extract($extractdadositens);
							?>
							<form method="post" id="formEditaradicional_<?=$id_opcao_complemento;?>">
								<tr>	
									<td>
										<?php
										if(strpos($categorias_adicional_opcao_complemento, ', ')):											
											$catArray = explode(', ', $categorias_adicional_opcao_complemento);
											
											$toralCat = count($catArray);

											for ($i=0; $i < $toralCat; $i++) {									

												$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND id =:idcat", "userid={$userlogin['user_id']}&idcat={$catArray[$i]}");
												if($lerbanco->getResult()):
													$dadosnomesgat = $lerbanco->getResult();

													if(($i + 1) < $toralCat):
														echo $dadosnomesgat[0]['nome_cat'].', ';
													else:
														echo $dadosnomesgat[0]['nome_cat'];
													endif;
													
												endif;
											}

										else:
											$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND id =:idcat", "userid={$userlogin['user_id']}&idcat={$categorias_adicional_opcao_complemento}");
											if($lerbanco->getResult()):
												$dadosnomesgat = $lerbanco->getResult();
												echo $dadosnomesgat[0]['nome_cat'];
											endif;
										endif;
										;
										?>
									</td>

									<td>
										<?php
										echo $nome_opcao_complemento;
										?>
									</td>


								</form>

								<td>
									<a href="<?=$site.$Url[0];?>/add-complemento-unico&idexcluir=<?=$id_opcao_complemento;?>"> 
										<button id="btnExcluiradicional_<?=$id_opcao_complemento;?>" data-excluir_adicional="<?=$id_opcao_complemento;?>" type="button" class="btn btn-danger btnexcluiradicional">Excluir</button>
									</a>
								</td>
								<td>
									<a href="<?=$site.$Url[0];?>/add-complemento-unico&idpausar=<?=$id_opcao_complemento;?>"> 
										<button class="btn <?=($status_opcao_complemento == 1 ? 'btn-info' : 'btn-warning')?> btnpausaradicional">
											<?=($status_opcao_complemento == 1 ? '<i style="font-size: 20px;" class="fa fa-pause" aria-hidden="true"></i>' : '<i style="font-size: 20px;" class="fa fa-play" aria-hidden="true"></i>')?>					
										</button>
									</a>
								</td>
							</tr>
							<?php
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



<script>
	var select=new MSFmultiSelect(
		document.querySelector('#multiselect'),
		{
			onChange:function(checked,value,instance){
				console.log(checked,value,instance);
			},
			selectAll:true,
			appendTo:'#myselect',
    //readOnly:true
}
);
</script>




