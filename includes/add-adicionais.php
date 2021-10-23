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
					<h3><strong>ADIONAIS E COMPLEMENTOS PAGOS</strong></h3>
					<p>
						<b>Adicione adicionais e complementos para os itens.</b>
					</p>					
					<br />
					<form id="formaddadicional" method="post">
						<div class="row">							
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="nome_adicional">Nome</label>
									<input required type="text" name="nome_adicional" id="nome_adicional" class="form-control" placeholder="Exe: adicionais (bacon, ovo, etc)" />
									<small class="form-text text-muted">
										Nome do adicional!
									</small>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="valor_adicional">Valor R$</label>
									<input required
									type="text" 
									name="valor_adicional" 
									id="dinheiro" 
									class="form-control" 
									maxlength="11" 
									onkeypress="return formatar_moeda(this, '.', ',', event);" 
									data-mask="#.##0,00" 
									data-mask-reverse="true" 
									class="form-control" 
									placeholder="+ R$ 0,00" />
									<small id="emailHelp" class="form-text text-muted">
										Valor do adicional!
									</small>
								</div>
							</div>
						</div>	
						
						<!--<div>
							<div>
								<label for="nome_adicional">Categoria</label>
								<div id="myselect">
									<select required class="form-control"  id="multiselect" name="categorias_adicional[]" multiple="multiple">									
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
						</div>-->
						<div>
							<br />
							<div class="form-group">
								<label>Medida</label>
								<br />
								<div class="icheck-material-green icheck-inline">
									<input type="radio" checked id="medidaUN" value="UN" required name="medida_adicional" />
									<label for="medidaUN">UN</label>
								</div>
								<div class="icheck-material-green icheck-inline">
									<input type="radio" id="medidaKG" required value="KG" name="medida_adicional" />
									<label for="medidaKG">KG</label>
								</div>
								<div class="icheck-material-green icheck-inline">
									<input type="radio" id="medidaLT" value="LT" required name="medida_adicional" />
									<label for="medidaLT">LT</label>
								</div>
							</div>

						</div>
						
						<div class="row">
						    <div class="col-md-12 col-sm-12">
						        <button class="btn btn-info" style="width: 100%;" type="button" data-toggle="collapse" data-target="#collapse_IdCat">Selecionar Categoria Vinculante</button>
						    </div>
						</div>
						<div id="collapse_IdCat" class="collapse">
							<label for="categorias_adicional_gratis">Categoria</label>								
							<?php
							$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
							if (!$lerbanco->getResult()):
							    ?>
								<a href="/categoria" class="list-group-item list-group-item-action list-group-item-warning">Cadastre novas catergorias!</a>
								<?php
							else:										
								foreach ($lerbanco->getResult() as $cat):
									extract($cat);
									?>
									<a id="<?=$id;?>" class="list-group-item list-group-item-action" style="cursor: pointer;"><?=$nome_cat;?></a>
								    <?php
								endforeach;
							endif;
							?>
							<input type="hidden" id="categorias_adicional" name="categorias_adicional"/>
							<small class="form-text text-muted">
								Selecione as categorias para vincular.
							</small>
						</div>
						
						</br>
						
						<div class="row">
						    <div class="col-md-12 col-sm-12">
						        <button class="btn btn-info" style="width: 100%;" type="button" onclick="listItens();">Selecionar Categoria do Produto Vinculante</button>
						        <span id="showCollapse_listItens" data-toggle="collapse" data-target="#collapse_listAddtCat"></span>
						    </div>
						</div>
						<div id="collapse_listAddtCat" class="collapse">
    						<div class="list-group" id="listCategorias">
    						    <label for="categorias_adicional_gratis">Categoria do Produto</label>
    						    <div id="content_listItens"></div>
    						    <input id="id_adicionais_cat" name="id_adicionais_cat" type="hidden">
    						    <!--<input id="id_itens" name="id_itens" type="hidden">-->
    							<small class="form-text text-muted">
    								Selecione a categoria para vincular.
    							</small>
                            </div>
                        </div>
                        
                        </br>

						<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
						<input type="hidden" name="status_adicional" value="1">
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

			$getdadosAddadicional['nome_adicional'] = trim($getdadosAddadicional['nome_adicional']);
			$getdadosAddadicional['nome_adicional'] = strip_tags($getdadosAddadicional['nome_adicional']);

			$getdadosAddadicional['valor_adicional'] = trim($getdadosAddadicional['valor_adicional']);
			$getdadosAddadicional['valor_adicional'] = strip_tags($getdadosAddadicional['valor_adicional']);
			$getdadosAddadicional['valor_adicional'] = Check::Valor($getdadosAddadicional['valor_adicional']);

			$getdadosAddadicional['medida_adicional'] = trim($getdadosAddadicional['medida_adicional']);
			$getdadosAddadicional['medida_adicional'] = strip_tags($getdadosAddadicional['medida_adicional']);


			if(empty($getdadosAddadicional['nome_adicional']) || empty($getdadosAddadicional['medida_adicional']) || empty($getdadosAddadicional['categorias_adicional'])):
				echo "<script>
			x0p('Opss...', 
			'Preencha todos os campos!',
			'error', false);
			</script>";
		elseif(empty($getdadosAddadicional['valor_adicional']) || $getdadosAddadicional['valor_adicional'] == "0,00" || $getdadosAddadicional['valor_adicional'] == "0" || $getdadosAddadicional['valor_adicional'] == "00"):
			echo "<script>
			x0p('Opss...', 
			'Insira um valor para o complemento!',
			'error', false);
			</script>";
		else:
		    $list_cats = explode(",", $getdadosAddadicional['categorias_adicional']);
	        $list_cats = array_filter($list_cats);
	        $list_itens = explode(",", $getdadosAddadicional['id_adicionais_cat']);
	        $list_itens = array_filter($list_itens);
	        
	        $list_itens_query = "AND ";
	        for ($i = 0; $i < count($list_itens); $i++) {
	            $list_itens_query .= "id=$list_itens[$i]";
	            if ($i+1 < count($list_itens)) {
	                $list_itens_query .= " OR ";
	            }
	        }
	        
	        $lerbanco->ExeRead('ws_adicionais_cat', "WHERE user_id = :userid $list_itens_query", "userid={$userlogin['user_id']}");
	        $data_itens = $lerbanco->getResult();
	        
	        if ($data_itens) {
	            for ($i = 0; $i < count($list_cats); $i++) {
		            $getdadosAddadicional['categorias_adicional'] = $list_cats[$i];
		            for ($j = 0; $j < count($data_itens); $j++) {
		                if ($data_itens[$j]['id_cat'] == $list_cats[$i]) {
		                    $getdadosAddadicional['id_adicionais_cat'] = $data_itens[$j]['id'];
    		                $addbanco->ExeCreate("ws_adicionais_itens", $getdadosAddadicional);
    		                if($addbanco->getResult()): 
                				header("Location: {$site}{$Url[0]}/add-adicionais");
                			else:
                				echo "<script>
                				x0p('Opss...', 
                				'Ocorreu um erro ao cadastrar!',
                				'error', false);
                				</script>";
                			endif;
		                }
    		        }
		        }
	        }

			/*$getdadosAddadicional['valor_adicional'] = Check::Valor($getdadosAddadicional['valor_adicional']);
			//$getdadosAddadicional['categorias_adicional'] = implode(', ', $getdadosAddadicional['categorias_adicional']);	
			
			$list_itens = explode(",", $getdadosAddadicional['id_adicionais_cat']);
	        for ($i = 0; $i < count($list_itens)-1; $i++) {
	            $getdadosAddadicional['id_adicionais_cat'] = $list_itens[$i];
	            $addbanco->ExeCreate("ws_adicionais_itens", $getdadosAddadicional);
	        }

			//$addbanco->ExeCreate("ws_adicionais_itens", $getdadosAddadicional);
			if($addbanco->getResult()): 
				header("Location: {$site}{$Url[0]}/add-adicionais");
			else:
				echo "<script>
				x0p('Opss...', 
				'Ocorreu um erro ao cadastrar!',
				'error', false);
				</script>";
			endif;*/
		endif;
	endif;
	?>


	<div id="contentoptions" class="form-group">
		<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
		<?php
		$lerbanco->FullRead("SELECT * FROM ws_adicionais_itens WHERE user_id = :userid ORDER BY id_adicionais DESC", "userid={$userlogin['user_id']}");
		if($lerbanco->getResult()):				
			?>		


			<div class="table-responsive">
				<table data-sortable class="table table-hover table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Categorias vinculadas</th>
							<th scope="col">Medida</th>
							<th scope="col">Nome</th>
							<th scope="col">Valor</th>							
							<th scope="col">Editar</th>
							<th scope="col">Excluir</th>
							<th scope="col">Pausar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($lerbanco->getResult() as $extractdadositens):
							extract($extractdadositens);
							?>
							<form method="post" id="formEditaradicional_<?=$id_adicionais;?>">
								<tr>	
									<td>
										<?php
										if(strpos($categorias_adicional, ', ')):											
											$catArray = explode(', ', $categorias_adicional);
											
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
											$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND id =:idcat", "userid={$userlogin['user_id']}&idcat={$categorias_adicional}");
											if($lerbanco->getResult()):
												$dadosnomesgat = $lerbanco->getResult();
												echo $dadosnomesgat[0]['nome_cat'];
											endif;
										endif;
										;
										?>
									</td>
									<td>
										<?=$medida_adicional;?>
									</td>						
									<td>
										<?php
										echo '<input type="text" style="width: 200px"  name="nome_adicional" value="'.$nome_adicional.'" id="nome_adicional_'.$id_adicionais.'" class="form-control" placeholder="Exe: adicionais (bacon, ovo, etc)" />';
										?>
									</td>
									<td>
										<?php
										echo '<input 
										type="text"
										style="width: 100px"
										name="valor_adicional" 
										id="valor_adicional_'.$id_adicionais.'" 
										class="form-control" 
										maxlength="11" 
										onkeypress="return formatar_moeda(this, '.', ',', event);" 
										data-mask="#.##0,00" 
										data-mask-reverse="true" 
										class="form-control" 
										value="'.Check::Real($valor_adicional).'"
										placeholder="+ R$ 0,00" />';

										?>
									</td>

									<input type="hidden" name="id_adicionais" value="<?=$id_adicionais;?>">
									<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
									<td><button data-id_adicional="<?=$id_adicionais;?>" id="btnEditarAdicional_<?=$id_adicionais;?>" type="button" class="btn btn-success editarbtnadicional">Editar</button></td>
								</form>

								<td>
									<button id="btnExcluiradicional_<?=$id_adicionais;?>" data-excluir_adicional="<?=$id_adicionais;?>" type="button" class="btn btn-danger btnexcluiradicional">Excluir</button>
								</td>
								<td>
									<button id="btnPausarAdicional_<?=$id_adicionais;?>" data-pausar_adicional="<?=$id_adicionais;?>" class="btn <?=($status_adicional == 1 ? 'btn-info' : 'btn-warning')?> btnpausaradicional">
										<?=($status_adicional == 1 ? '<i style="font-size: 20px;" class="fa fa-pause" aria-hidden="true"></i>' : '<i style="font-size: 20px;" class="fa fa-play" aria-hidden="true"></i>')?>					
									</button>
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
	/*var select=new MSFmultiSelect(
		document.querySelector('#multiselect'),
		{
			onChange:function(checked,value,instance){
				console.log(checked,value,instance);
			},
			selectAll:true,
			appendTo:'#myselect',
    //readOnly:true
}
);*/
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$(".editarbtnadicional").click(function(){
			var idAdicional = $(this).data('id_adicional');

			$('#btnEditarAdicional_'+idAdicional).html('Aguarde...');
			$('#btnEditarAdicional_'+idAdicional).prop('disabled', true);


			if($("#valor_adicional_"+idAdicional).val() == '' || $("#nome_adicional_"+idAdicional).val() == ''){
				x0p('Opss...', 
					'Preencha os campos!',
					'error', false);
				$('#btnEditarAdicional_'+idAdicional).html('Editar');
				$('#btnEditarAdicional_'+idAdicional).prop('disabled', false);
			}else{

				$.ajax({
					url: '<?=$site;?>includes/processaeditaradicional.php',
					method: 'post',
					data: $('#formEditaradicional_'+idAdicional).serialize(),
					success: function(data){
						$('#btnEditarAdicional_'+idAdicional).html('Editar');
						$('#btnEditarAdicional_'+idAdicional).prop('disabled', false);

						if(data == 'true'){
							x0p('Sucesso!', 
								'O adicional foi atualizado!', 
								'ok', false);
						}else if(data == 'false'){
							x0p('Opss...', 
								'OCORREU UM ERRO!',
								'error', false);
						}

					}
				});

			}			

		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.btnexcluiradicional').click(function(){
			var btnexcluirad = $(this).data('excluir_adicional');

			GrowlNotification.notify({
				title: 'Atenção!',
				description: 'Tem certeza de que deseja deletar esse adicional?',
				type: 'error',
				image: {
					visible: true,
					customImage: '<?=$site;?>img/danger.png'
				},
				position: 'bottom-left',
				showProgress: true,
				showButtons: true,
				buttons: {
					action: {
						text: 'SIM',
						callback: function(){
							$.ajax({
								url: '<?=$site;?>includes/processadeletaadicional.php',
								method: 'post',
								data: {'user_id' : '<?=$userlogin['user_id'];?>', 'id_adicionais' : btnexcluirad},
								success: function(data){
									if(data == 'true'){
										window.location.reload(1);
									}else{
										x0p('Opss...', 
											'OCORREU UM ERRO!',
											'error', false);
									}
								}
							});
						}
					},
					cancel: {
						text: 'NÃO'
					}
				},
				closeTimeout: 0
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.btnpausaradicional').click(function(){
			var idadicionalpausar = $(this).data('pausar_adicional');

			$('#btnPausarAdicional_'+idadicionalpausar).prop('disabled', true);

			$.ajax({
				url: '<?=$site;?>includes/processapausaradicional.php',
				method: 'post',
				data: {'user_id' : '<?=$userlogin['user_id'];?>', 'id_adicionais' : idadicionalpausar},
				success: function(data){
					if(data == 'true'){
						$('#btnPausarAdicional_'+idadicionalpausar).prop('disabled', false);
						window.location.reload(1);
					}else{
						x0p('Opss...', 
							'OCORREU UM ERRO!',
							'error', false);
						$('#btnPausarAdicional_'+idadicionalpausar).prop('disabled', false);
					}
				}
			});

		});
	});
	
	
	
	
	
	
	
	$(document).ready(function(){
		$('#collapse_IdCat a').click(function(){
		    if ($(this).attr("class").indexOf("active") != -1) {
		        $(this).removeClass("active");
		        $("#categorias_adicional").attr("value",$("#categorias_adicional").val().replace($(this).attr("id")+",",""));
		        return;
		    }
		    $(this).addClass("active");
		    $("#categorias_adicional").attr("value",$("#categorias_adicional").val()+$(this).attr("id")+",");
		}); 
	});
	
	var arr_listItens = [];
	function listItens() {
	    var cat = $('#collapse_IdCat');
	    var category = [];
        $(cat).children("a").each(function() {
            var class_a = $(this).attr("class");
            if (class_a.indexOf("active") != -1) {
                category.push($(this).attr("id"));
            }
        });
        
        if (category.length > 0) {
            $.ajax({
                url: '<?= $site; ?>includes/adicionais-categoria-func.php',
    		    method: "post",
    		    type: "post",
    		    dataType: "json",
    		    data: {"action" : "listAdicionaisCatP", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : category},
    		    success: function(response) {
    		        var res = response;
    		        //alert(res.toString());
    		        $("#content_listItens").html("");
    		        arr_listItens = [];
    		        var current_cat = -1;
    		        if (typeof res != "object") {
			            $("#content_listItens").html('<div class="alert alert-warning"><span>Não há categorias de produtos complementares para esta categoria!</span></div>');
				        $("#showCollapse_listItens").click();
			        }
			        else {
				        for (i = 0; i < res['addt_cats'].length; i++) {
				            if (current_cat != res['addt_cats'][i]['id_cat']) {
        		                current_cat = res['addt_cats'][i]['id_cat'];
        		                $("#content_listItens").html($("#content_listItens").html()+"</br>");
        		            }
				            $("#content_listItens").html($("#content_listItens").html()+'<a id="item_'+res['addt_cats'][i]['id']+'" onclick="select_listItens(\''+res['addt_cats'][i]['id']+'\');" class="list-group-item list-group-item-action" style="cursor: pointer;">'+res['addt_cats'][i]['name_adicionais_cat']+'</a>');
				            arr_listItens.push(res['addt_cats'][i]['id']);
				            for (j = 0; j < res['list_itens'].length; j++) {
    				            if (res['list_itens'][j]['id'] == res['addt_cats'][i]['id_itens']) {
    				                $("#item_"+res['addt_cats'][i]['id']).html($("#item_"+res['addt_cats'][i]['id']).html()+' - '+res['list_itens'][j]['nome_item']);
    				            }
				            }
				        }
			            $("#showCollapse_listItens").click();
			        }
			        return true;
    		    },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    alert(xhr.responseText);
                }
            });
        }
	}
	
	
	/*var arr_listItens = [];
	function listItens() {
	    var cat = $('#collapse_IdCat');
        $(cat).children("a").each(function() {
            var class_a = $(this).attr("class");
            if (class_a.indexOf("active") != -1) {
                $.ajax({
                    url: '<?= $site; ?>includes/adicionais-categoria-func.php',
				    method: "post",
				    type: "post",
				    dataType: "json",
				    data: {"action" : "listAdicionaisCatP", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : $(this).attr("id")},
				    success: function(response) {
				        $("#content_listItens").html("");
				        arr_listItens = [];
				        var res = response;
				        if (typeof res != "object") {
				            $("#content_listItens").html('<div class="alert alert-warning"><span>Não há categorias de produtos complementares para esta categoria!</span></div>');
    				        $("#showCollapse_listItens").click();
				        }
				        else {
    				        for (i = 0; i < res['addt_cats'].length; i++) {
    				            $("#content_listItens").html($("#content_listItens").html()+'<a id="item_'+res['addt_cats'][i]['id']+'" onclick="select_listItens(\''+res['addt_cats'][i]['id']+'\');" class="list-group-item list-group-item-action" style="cursor: pointer;">'+res['addt_cats'][i]['name_adicionais_cat']+'</a>');
    				            arr_listItens.push(res['addt_cats'][i]['id']);
    				            //alert(res['list_itens'][1]['nome_item']);
    				            for (j = 0; j < res['list_itens'].length; j++) {
        				            if (res['list_itens'][j]['id'] == res['addt_cats'][i]['id_itens']) {
        				                $("#item_"+res['addt_cats'][i]['id']).html($("#item_"+res['addt_cats'][i]['id']).html()+' - '+res['list_itens'][j]['nome_item']);
        				                //$("#cat_"+res['addt_cats'][i]['id']).attr("onclick","select_listItens('cat_"+res['addt_cats'][i]['id']+"_item_"+res['list_itens'][j]['id']+"')");
        				                //$("#cat_"+res['addt_cats'][i]['id']).attr("id","cat_"+res['addt_cats'][i]['id']+"_item_"+res['list_itens'][j]['id']);
        				                //arr_listItens.push("cat_"+res['addt_cats'][i]['id']+"_item_"+res['list_itens'][j]['id']);
        				            }
    				            }
    				        }
    				        $("#showCollapse_listItens").click();
				        }
				        return true;
				    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                        alert(xhr.responseText);
                    }
                });
            }
        });
        //return alert("Selecione uma categoria primeiro!");
	}*/
	
	function select_listItens(id) {
	    /*for (i = 0; i < arr_listItens.length; i++) {
	        $("#item_"+arr_listItens[i]).removeClass("active");
	    }*/
	    //$("#item_"+id).addClass("active");
	    //$("#id_adicionais_cat").attr("value",id);
	    
	    
	    if ($("#item_"+id).attr("class").indexOf("active") != -1) {
	        $("#item_"+id).removeClass("active");
	        $("#id_adicionais_cat").attr("value",$("#id_adicionais_cat").val().replace(id+",",""));
	    }
	    else {
	        $("#item_"+id).addClass("active");
	        $("#id_adicionais_cat").attr("value",$("#id_adicionais_cat").val()+id+",");
	    }
	}
</script>



