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

	$deletbanco->ExeDelete("ws_adicionais_cat", "WHERE user_id = :userid AND id  = :idadicionalcat", "userid={$userlogin['user_id']}&idadicionalcat={$getdel}");
	if($deletbanco->getResult()):
		header("Location: {$site}{$Url[0]}/add-adicionais-categoria");
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
					<h3><strong>CATEGORIAS DE COMPLEMENTOS</strong></h3>
					<p>
						<b>Adicione as categorias dos complementos grátis e pagos.</b>
					</p>					
					<br />
					<form method="post" action="">
						<div class="row">							
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="nome_adicional_gratis">Nome</label>
									<input required type="text" name="name_adicionais_cat" id="name_adicionais_cat" class="form-control" placeholder="Ex: Frutas, Carnes, Coberturas..." />
									<small class="form-text text-muted">
										Nome da categoria de complementos!
									</small>
								</div>
							</div>
                            <div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="nome_adicional_gratis">Quantidade</label>
									<input required type="number" name="amount" id="amount" class="form-control" placeholder="Utilize -1 para sem restrições" min="-1" />
									<small class="form-text text-muted">
										Quantidade de complementos!
									</small>
								</div>
							</div>
						</div>	
						
						<div class="row">							
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="nome_adicional_gratis">Tipo do Complemento</label>
									<select class="form-control" name="pay" id="pay">
									    <option value="0">Grátis</option>
									    <option value="1">Pago</option>
									</select>
									<small class="form-text text-muted">
										Tipo de custo do complemento!
									</small>
								</div>
							</div>
                            <div class="col-md-6 col-sm-6">
								<div class="form-group">
									<label for="nome_adicional_gratis">Nome da Imagem</label>
									<!--<input type="text" name="img_cat" id="img_cat" class="form-control" placeholder="Ex: frutas.png, fastfood.png..." />-->
									<button type="button" class="btn btn-warning" style="width: 100%;" data-toggle="modal" data-target="#modalListImageCat">Selecionar Imagem da Categoria</button>
									<input type="hidden" name="img_cat" id="img_cat" class="form-control" placeholder="Ex: frutas.png, fastfood.png..." />
									<small class="form-text text-muted">
										Nome das imagens dentro da pasta "img"
									</small>
								</div>
							</div>
						</div>	
						
						
						<div class="row">
						    <div class="col-md-12 col-sm-12">
						        <button class="btn btn-info" style="width: 100%;" type="button" data-toggle="collapse" data-target="#collapse_listCategorias">Selecionar Categoria Vinculante</button>
						    </div>
						</div>
						<div id="collapse_listCategorias" class="collapse">
    						<div class="list-group" id="listCategorias">
    						    <label for="categorias_adicional_gratis">Categoria</label>
    						    <?php
    							$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
    							if (!$lerbanco->getResult()):
    								?>
    								<a class="list-group-item list-group-item-action list-group-item-warning">Cadastre novas catergorias!</a>
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
    							<input id="id_cat" name="id_cat" type="hidden" value="">
    							<small class="form-text text-muted">
    								Selecione a categoria para vincular.
    							</small>
                            </div>
                        </div>
                        </br>
                        <div class="row">
						    <div class="col-md-12 col-sm-12">
						        <button class="btn btn-info" style="width: 100%;" type="button" onclick="listItens();">Selecionar Item Vinculante</button><span id="showCollapse_listItens" data-toggle="collapse" data-target="#collapse_listItens"></span>
						    </div>
						</div>
						<div id="collapse_listItens" class="collapse">
    						<div class="list-group" id="listItens">
    						    <label for="categorias_adicional_gratis">Itens</label>
    						    <div id="content_listItens"></div>
    						    <input id="id_itens" name="id_itens" type="hidden" value="">
    							<small class="form-text text-muted">
    								Selecione o item para vincular.
    							</small>
                            </div>
                        </div>
                        
                        
                        </br>

						<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
						<button class="btn btn-primary" type="submit">Cadastrar</button>
					</form>
					
					<br />
					<br />
					<br />
				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->



		<?php
		$getdadosCategorias = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		
		if(!empty($getdadosCategorias)):

			$getdadosCategorias['name_adicionais_cat'] = trim($getdadosCategorias['name_adicionais_cat']);
			$getdadosCategorias['name_adicionais_cat'] = strip_tags($getdadosCategorias['name_adicionais_cat']);

           
			if(empty($getdadosCategorias['name_adicionais_cat']) || empty($getdadosCategorias['amount']) || empty($getdadosCategorias['id_cat']) || empty($getdadosCategorias['id_itens'])):
				echo "<script>
    			x0p('Opss...', 
    			'Preencha todos os campos!',
    			'error', false);
    			</script>";
		    else:
		        $list_cats = explode(",", $getdadosCategorias['id_cat']);
		        $list_cats = array_filter($list_cats);
		        $list_itens = explode(",", $getdadosCategorias['id_itens']);
		        $list_itens = array_filter($list_itens);
		        
		        $list_itens_query = "AND ";
		        for ($i = 0; $i < count($list_itens); $i++) {
		            $list_itens_query .= "id=$list_itens[$i]";
		            if ($i+1 < count($list_itens)) {
		                $list_itens_query .= " OR ";
		            }
		        }
		        $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid $list_itens_query", "userid={$userlogin['user_id']}");
		        $data_itens = $lerbanco->getResult();
		        
		        if ($data_itens) {
		            for ($i = 0; $i < count($list_cats); $i++) {
    		            $getdadosCategorias['id_cat'] = $list_cats[$i];
    		            for ($j = 0; $j < count($data_itens); $j++) {
    		                if ($data_itens[$j]['id_cat'] == $list_cats[$i]) {
    		                    $getdadosCategorias['id_itens'] = $data_itens[$j]['id'];
        		                $addbanco->ExeCreate("ws_adicionais_cat", $getdadosCategorias);
        		                if($addbanco->getResult()): 
                    				header("Location: {$site}{$Url[0]}/add-adicionais-categoria");
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
		    endif;
	    endif;
	?>


	<div id="contentoptions" class="form-group">
		<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
		<?php
		$lerbanco->FullRead("SELECT * FROM ws_adicionais_cat WHERE user_id = :userid ORDER BY id  DESC", "userid={$userlogin['user_id']}");
		if($lerbanco->getResult()):				
			?>		


			<div class="table-responsive">
				<table data-sortable class="table table-hover table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Categoria Vinculante</th>
							
							<th scope="col">Item Vinculante</th>
                            
							<th scope="col">Nome</th>
                            
							<th scope="col">Excluir</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($lerbanco->getResult() as $extractdadositens):
							extract($extractdadositens);
							?>
							<form method="post" id="formEditaradicional_<?=$id;?>">
								<tr>	
									<td>
										<?php
										$lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND id =:idcat", "userid={$userlogin['user_id']}&idcat={$id_cat}");
										if($lerbanco->getResult()):
											$dadosnomesgat = $lerbanco->getResult();
											echo $dadosnomesgat[0]['nome_cat']." ({$dadosnomesgat[0]['id']})";
										endif;
										?>
									</td>
									
									<td>
										<?php
										$lerbanco->ExeRead("ws_itens", "WHERE user_id = :userid AND id =:iditens", "userid={$userlogin['user_id']}&iditens={$id_itens}");
										if($lerbanco->getResult()):
											$dadosnomesitem = $lerbanco->getResult();
											echo $dadosnomesitem[0]['nome_item']." ({$dadosnomesitem[0]['id']})";
										endif;
										?>
									</td>

									<td>
										<?php
										echo $name_adicionais_cat;
										?>
									</td>


								</form>

								<td>
									<a href="<?=$site.$Url[0];?>/add-adicionais-categoria&idexcluir=<?=$id;?>"> 
										<button id="btnExcluiraddtCat_<?=$id;?>" data-excluir_adicional="<?=$id;?>" type="button" class="btn btn-danger btnexcluiradicional">Excluir</button>
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

<!-- The Modal -->
  <div class="modal" id="modalListImageCat">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Lista de Imagens</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <?php
            $path = "img/";
            $diretorio = dir($path);
            
            $listImg = array();
            while($file = $diretorio -> read()){
                //echo "<a href='".$path.$file."'>".$file."</a><br />";
                if (strpos($file,".png") !== false or strpos($file,".jpg") !== false or strpos($file,".jpeg") !== false) {
                    array_push($listImg,$file);
                }
            }
            $diretorio -> close();
            
            $pos = 4;
            while ($pos < count($listImg)) {
                ?>
                <div class="row text-center" style="margin-bottom: 20px;">
                    <?php
                    for ($i = ($pos == 4 ? 0 : ($pos-1)); $i <= ($pos == 4 ? 3 : (3+($pos-1))); $i++) {
                        if (isset($listImg[$i])) {
                            ?>
                            <div class="col-sm-3">
                                <img class="img-fluid" style="cursor: pointer;" src="<?=($site.'img/'.$listImg[$i]);?>" alt="Chania" width="35" height="35" onclick="selectImg('<?=$listImg[$i];?>');" data-dismiss="modal">
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                $pos = $pos + 4;
            }
            ?>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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

    function selectImg(name) {
        $("#img_cat").attr("value",name);
    }


    $(document).ready(function(){
		/*$('#listCategorias a').click(function(){
		    $('#listCategorias a').removeClass("active");
		    $(this).addClass("active");
		    $("#id_cat").attr("value",$(this).attr("id"));
		});*/
		
		$('#listCategorias a').click(function(){
		    if ($(this).attr("class").indexOf("active") != -1) {
		        $(this).removeClass("active");
		        $("#id_cat").attr("value",$("#id_cat").val().replace($(this).attr("id")+",",""));
		        return;
		    }
		    $(this).addClass("active");
		    $("#id_cat").attr("value",$("#id_cat").attr("value")+$(this).attr("id")+",");
		});
		
		/*$('#content_listItens').click(function(){
		    $('#content_listItens a').removeClass("active");
		    $("#96").addClass("active");
		    $('#content_listItens a').removeClass("active");
		    $(this).addClass("active");
		    $("#id_itens").attr("value",$(this).attr("id"));
		}); */
	});
	
	var arr_listItens = [];
	function listItens() {
	    var cat = $('#listCategorias');
	    var category = [];
        $(cat).children("a").each(function() {
            var class_a = $(this).attr("class");
            if (class_a.indexOf("active") != -1) {
                category.push($(this).attr("id"));
                /*$.ajax({
                    url: '<?= $site; ?>includes/adicionais-categoria-func.php',
				    method: "post",
				    type: "post",
				    dataType: "json",
				    data: {"action" : "list", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : $(this).attr("id")},
				    success: function(response) {
				        $("#content_listItens").html("");
				        arr_listItens = [];
				        var res = response;
				        for (i = 0; i < res.length; i++) {
				            $("#content_listItens").html($("#content_listItens").html()+'<a id="item_'+res[i]['id']+'" onclick="select_listItens(\''+res[i]['id']+'\');" class="list-group-item list-group-item-action" style="cursor: pointer;">'+res[i]['nome_item']+'</a>');
				            arr_listItens.push(res[i]['id']);
				        }
				        $("#showCollapse_listItens").click();
				        return true;
				    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                        alert(xhr.responseText);
                    }
                });*/
            }
        });
        
        if (category.length > 0) {
            $.ajax({
                url: '<?= $site; ?>includes/adicionais-categoria-func.php',
    		    method: "post",
    		    type: "post",
    		    dataType: "json",
    		    data: {"action" : "list", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : category},
    		    success: function(response) {
    		        var res = response;
    		        //alert(res.toString());
    		        $("#content_listItens").html("");
    		        arr_listItens = [];
    		        var current_cat = -1;
    		        for (i = 0; i < res.length; i++) {
    		            if (current_cat != res[i]['id_cat']) {
    		                current_cat = res[i]['id_cat'];
    		                $("#content_listItens").html($("#content_listItens").html()+"</br>");
    		            }
    		            $("#content_listItens").html($("#content_listItens").html()+'<a id="item_'+res[i]['id']+'" onclick="select_listItens(\''+res[i]['id']+'\');" class="list-group-item list-group-item-action" style="cursor: pointer;">'+res[i]['nome_item']+'</a>');
    		            arr_listItens.push(res[i]['id']);
    		        }
    		        $("#showCollapse_listItens").click();
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
	    var cat = $('#listCategorias');
        $(cat).children("a").each(function() {
            var class_a = $(this).attr("class");
            if (class_a.indexOf("active") != -1) {
                $.ajax({
                    url: '<?= $site; ?>includes/adicionais-categoria-func.php',
				    method: "post",
				    type: "post",
				    dataType: "json",
				    data: {"action" : "list", "user_id" : "<?=$userlogin['user_id'];?>", "cat_id" : $(this).attr("id")},
				    success: function(response) {
				        $("#content_listItens").html("");
				        arr_listItens = [];
				        var res = response;
				        for (i = 0; i < res.length; i++) {
				            $("#content_listItens").html($("#content_listItens").html()+'<a id="item_'+res[i]['id']+'" onclick="select_listItens(\''+res[i]['id']+'\');" class="list-group-item list-group-item-action" style="cursor: pointer;">'+res[i]['nome_item']+'</a>');
				            arr_listItens.push(res[i]['id']);
				        }
				        $("#showCollapse_listItens").click();
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
	    
	    if ($("#item_"+id).attr("class").indexOf("active") != -1) {
	        $("#item_"+id).removeClass("active");
	        $("#id_itens").attr("value",$("#id_itens").val().replace(id+",",""));
	    }
	    else {
	        $("#item_"+id).addClass("active");
	        $("#id_itens").attr("value",$("#id_itens").val()+id+",");
	    }
	    
	    //$("#item_"+id).addClass("active");
	    //$("#id_itens").attr("value",id)
	}
</script>




