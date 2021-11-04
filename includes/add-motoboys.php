<?php

$login = new Login(3);

if(!$login->CheckLogin()):
	unset($_SESSION['userlogin']);
	header("Location: {$site}");
else:
	$userlogin = $_SESSION['userlogin'];
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
					<form id="formMotoboy" method="post">
						<div class="row">							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="motoboy_name">Nome do Entregador</label>
									<input required type="text" name="motoboy_name" id="motoboy_name" class="form-control" placeholder="Digite o nome completo do entregador" />
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="motoboy_phone_number">Número de Telefone (Whatsapp)</label>
									<input required type="text" name="motoboy_phone_number" id="motoboy_phone_number" class="form-control" placeholder="(00) 00000-0000" data-mask="(00) 00000-0000" data-mask-selectonfocus="true" />
								</div>
							</div>
						</div>


						<input type="hidden" name="user_id" id="user_id" value="<?=$userlogin['user_id'];?>">
						<input type="hidden" id="url_site" value="<?=$site;?>">
						<input type="hidden" id="id_motoboy">
						<input type="hidden" id="id_registro" value="novo">
						<button class="btn btn-primary cad-motoboy" id="id_cadastro">Cadastrar</button>
					</form>
					<br />
					<br />
					<br />
				</div>
			</div><!-- End col  -->
		</div><!-- End row  -->

		<?php
			//INICIO PAGINAÇÃO
			$getpage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
			$pager = new Pager("{$site}{$Url[0]}/add-motoboys&page=");
			$pager->ExePager($getpage, 10);
			//FIM PAGINAÇÃO
		?>

		<div id="contentoptions" class="form-group">
			<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
			<?php
			$lerbanco->FullRead("SELECT * FROM ws_motoboys WHERE user_id = :userid ORDER BY id DESC LIMIT :limit OFFSET :offset", "userid={$userlogin['user_id']}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
			if($lerbanco->getResult()):				
				?>		

				<div class="table-responsive">
					<table data-sortable class="table table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th></th>
								<th scope="col">Nome do Entregador</th>
								<th scope="col">Número de Telefone</th>
								<th scope="col" colspan="2">Ações</th>
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
									<td><?=$extractdadositens['id']?></td>
									<td><?=$extractdadositens['motoboy_name'];?></td>
									<td><?=$extractdadositens['motoboy_phone_number'];?></td>						
                                    <td>										
										<button type="button" class="btn btn-danger delete-motoboy" data-toggle="modal" data-target="#exampleModal">Excluir</button>									
										<button type="button" class="btn btn-primary edit-motoboy">Editar</button>										
									</td>									
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
				$pager->ReturnPage();  
			endif;
			?>

			<?php
   				$pager->ExePaginator("ws_motoboys" ,"WHERE user_id = :userid", "userid={$userlogin['user_id']}");
   				echo $pager->getPaginator();
			?>
			<!--|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->
		</div><!-- End form-group -->
	</div>
</div><!-- End container  -->

<!--Tela modal de confirmação-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Confirma a exclusão deste registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" id="confirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>