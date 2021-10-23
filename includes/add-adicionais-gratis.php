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


<?php
$getdel = filter_input(INPUT_GET, 'idexcluir', FILTER_VALIDATE_INT);
if(!empty($getdel)):

	$deletbanco->ExeDelete("ws_adicionais_itens_gratis", "WHERE user_id = :userid AND id_adicional_gratis  = :idadicional", "userid={$userlogin['user_id']}&idadicional={$getdel}");
	if($deletbanco->getResult()):
		header("Location: {$site}{$Url[0]}/add-adicionais-gratis");
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

	$lerbanco->ExeRead("ws_adicionais_itens_gratis", "WHERE user_id = :userid AND id_adicional_gratis = :idadicionalgratis", "userid={$userlogin['user_id']}&idadicionalgratis={$getpausar}");
if(!$lerbanco->getResult()):
	echo "<script>
			x0p('Opss...', 
			'Item não encontrado!',
			'error', false);
			</script>";
else:
	$dadosgetadicional = $lerbanco->getResult();

	$getdadospauseAd['status_adicional_gratis'] = ($dadosgetadicional[0]['status_adicional_gratis'] == 1 ? 0 : 1);

	$updatebanco->ExeUpdate("ws_adicionais_itens_gratis", $getdadospauseAd, "WHERE user_id = :userid AND id_adicional_gratis = :idadicional", "userid={$userlogin['user_id']}&idadicional={$getpausar}");

	if($updatebanco->getResult()):                                                
		header("Location: {$site}{$Url[0]}/add-adicionais-gratis");      
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
					<h3><strong>ADICIONAIS E COMPLEMENTOS GRÁTIS</strong></h3>
					<p>
						<b>Adicione adicionais e complementos para os itens.</b>
					</p>					
					<br />
					<form id="formaddadicional" method="post">
						<div class="row">							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="nome_adicional_gratis">Nome</label>
									<input required type="text" name="nome_adicional_gratis" id="nome_adicional_gratis" class="form-control" placeholder="Exe: adicionais (bacon, ovo, etc)" />
									<small class="form-text text-muted">
										Nome do adicional!
									</small>
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
							<input type="hidden" id="categorias_adicional_gratis" name="categorias_adicional_gratis"/>
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
						<input type="hidden" name="status_adicional_gratis" value="1">
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

			$getdadosAddadicional['nome_adicional_gratis'] = trim($getdadosAddadicional['nome_adicional_gratis']);
			$getdadosAddadicional['nome_adicional_gratis'] = strip_tags($getdadosAddadicional['nome_adicional_gratis']);


			if(empty($getdadosAddadicional['nome_adicional_gratis']) || empty($getdadosAddadicional['categorias_adicional_gratis'])):
				echo "<script>
			x0p('Opss...', 
			'Preencha todos os campos!',
			'error', false);
			</script>";
		else:
		    $list_cats = explode(",", $getdadosAddadicional['categorias_adicional_gratis']);
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
		            $getdadosAddadicional['categorias_adicional_gratis'] = $list_cats[$i];
		            for ($j = 0; $j < count($data_itens); $j++) {
		                if ($data_itens[$j]['id_cat'] == $list_cats[$i]) {
		                    $getdadosAddadicional['id_adicionais_cat'] = $data_itens[$j]['id'];
    		                $addbanco->ExeCreate("ws_adicionais_itens_gratis", $getdadosAddadicional);
    		                if($addbanco->getResult()): 
                				header("Location: {$site}{$Url[0]}/add-adicionais-gratis");
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
	        
			/*$list_itens = explode(",", $getdadosAddadicional['id_adicionais_cat']);
	        for ($i = 0; $i < count($list_itens)-1; $i++) {
	            $getdadosAddadicional['id_adicionais_cat'] = $list_itens[$i];
	            $addbanco->ExeCreate("ws_adicionais_itens_gratis", $getdadosAddadicional);
	        }		

			//$addbanco->ExeCreate("ws_adicionais_itens_gratis", $getdadosAddadicional);
			if($addbanco->getResult()): 
				header("Location: {$site}{$Url[0]}/add-adicionais-gratis");
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
		$lerbanco->FullRead("SELECT * FROM ws_adicionais_itens_gratis WHERE user_id = :userid ORDER BY id_adicional_gratis  DESC", "userid={$userlogin['user_id']}");
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
							<form method="post" id="formEditaradicional_<?=$id_adicional_gratis;?>">
								<tr>	
									<td>
										<?php
										if(strpos($categorias_adicional_gratis, ', ')):											
											$catArray = explode(', ', $categorias_adicional_gratis);
											
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
											$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND id =:idcat", "userid={$userlogin['user_id']}&idcat={$categorias_adicional_gratis}");
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
										echo $nome_adicional_gratis;
										?>
									</td>


								</form>

								<td>
									<a href="<?=$site.$Url[0];?>/add-adicionais-gratis&idexcluir=<?=$id_adicional_gratis;?>"> 
										<button id="btnExcluiradicional_<?=$id_adicional_gratis;?>" data-excluir_adicional="<?=$id_adicional_gratis;?>" type="button" class="btn btn-danger btnexcluiradicional">Excluir</button>
									</a>
								</td>
								<td>
									<a href="<?=$site.$Url[0];?>/add-adicionais-gratis&idpausar=<?=$id_adicional_gratis;?>"> 
										<button class="btn <?=($status_adicional_gratis == 1 ? 'btn-info' : 'btn-warning')?> btnpausaradicional">
											<?=($status_adicional_gratis == 1 ? '<i style="font-size: 20px;" class="fa fa-pause" aria-hidden="true"></i>' : '<i style="font-size: 20px;" class="fa fa-play" aria-hidden="true"></i>')?>					
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

    $(document).ready(function(){
		$('#collapse_IdCat a').click(function(){
		    if ($(this).attr("class").indexOf("active") != -1) {
		        $(this).removeClass("active");
		        $("#categorias_adicional_gratis").attr("value",$("#categorias_adicional_gratis").val().replace($(this).attr("id")+",",""));
		        return;
		    }
		    $(this).addClass("active");
		    $("#categorias_adicional_gratis").attr("value",$("#categorias_adicional_gratis").val()+$(this).attr("id")+",");
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
    		    data: {"action" : "listAdicionaisCat", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : category},
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
				    data: {"action" : "listAdicionaisCat", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : $(this).attr("id")},
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




