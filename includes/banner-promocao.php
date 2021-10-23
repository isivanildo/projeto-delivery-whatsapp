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

$updatebanco = new Update();


$lerbanco->ExeRead('banner_promocional', "WHERE user_id = :useridd", "useridd={$userlogin['user_id']}");
if(!$lerbanco->getResult()):
else:
	foreach ($lerbanco->getResult() as $dadosC):
		extract($dadosC);
	endforeach;
endif;
?>

<?php
$getdel = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
if(!empty($getdel) && $getdel == 1):

	$deletbanco->ExeDelete("banner_promocional", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
	if($deletbanco->getResult()):
		unlink("uploads/{$img_banner}");
		header("Location: {$site}{$Url[0]}/banner-promocao"); 
	else:
		echo "<script>
		x0p('Opss...', 
		'Ocorreu um erro ao cadastrar!',
		'error', false);
		</script>";
	endif;

endif;
?>

<div id="contato_do_site">
	<div style="background-color:#ffffff;" class="container margin_60">	 		
		<div class="row">	
			<div class="col-md-8 col-md-offset-2">	

				<div id="sendnewpass" class="indent_title_in">
					<i class="fa fa-picture-o" aria-hidden="true"></i>
					<h3>BANNER</h3>
					<p>
						Banner Promocional
					</p>
				</div>

				<br />
				<br />
				<br />
				<div class="row row-sm mg-t-20">

					<div class="col-lg-12">
						<div class="card card-info">
							<div class="card-body pd-40" align="justify" style="margin-top:-40px">

								<form action="" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-12">											
											<div class="form-group">
												<input type="hidden" name="confirma_banner" value="1">
												<label>Tamanho ideal 1000x333 pixels</label>
												<input type="file" name="img_banner" id="img_banner" class="form-control" required>
												<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="center"><button type="submit" class="btn btn-primary">Salvar <i class="fa fa-arrow-right"></i></button></div>
											</div>
										</div>
									</div>
									<!-- /row-->
								</form>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group" align="center">
											<?php
											$inputDadosItem = filter_input_array(INPUT_POST, FILTER_DEFAULT);

											if(!empty($inputDadosItem)): 

											// INICIO DA VALIDAÇÃO DA IMAGEM ITEM:
												if (isset($_FILES['img_banner']['tmp_name']) && $_FILES['img_banner']['tmp_name'] != ""):
													$inputDadosItem['img_banner'] = $_FILES['img_banner'];
												else:
													$inputDadosItem['img_banner'] = '';
													unset($inputDadosItem['img_banner']);     
												endif;

												if(!empty($inputDadosItem['img_banner'])):                        
													$upload = new Upload("uploads/");
													$upload->Image($inputDadosItem['img_banner']);

													if(isset($upload) && $upload->getResult()):
														$inputDadosItem['img_banner'] = $upload->getResult();
													if(!empty($inputDadosItem['img_banner']) && !empty($img_banner) && file_exists("uploads/{$img_banner}") && !is_dir("uploads/{$img_banner}")):
														unlink("uploads/{$img_banner}");
												endif;
											elseif(is_array($inputDadosItem['img_banner'])):
												$inputDadosItem['img_banner'] = 'null';
											endif; 
										else:                  
										endif;
									// FINAL DA VALIDAÇÃO DA IMAGEM ITEM:

										$inputDadosItem['confirma_banner'] = (!empty($inputDadosItem['confirma_banner']) ? $inputDadosItem['confirma_banner'] : 0);

										$lerbanco->ExeRead('banner_promocional', "WHERE user_id = :useridd", "useridd={$userlogin['user_id']}");

										if(!$lerbanco->getResult()):
											$addbanco->ExeCreate("banner_promocional", $inputDadosItem);
											header("Location: {$site}{$Url[0]}/banner-promocao"); 
										else:
											$updatebanco->ExeUpdate("banner_promocional", $inputDadosItem, "WHERE user_id = :uuserid", "uuserid={$userlogin['user_id']}");
											header("Location: {$site}{$Url[0]}/banner-promocao"); 
										endif;
									endif;

									if(!empty($img_banner)):
										echo "<img src=\"{$site}uploads/{$img_banner}\" width=\"350\"/>";
										echo "<br />";
										echo "<br />";
										echo "<center style='margin-top:10px;'><a href='{$site}{$Url[0]}/banner-promocao&del=1'><button class=\"btn btn-danger\">Remover banner</button></a></center>";
									else:
									endif;
									?>


								</div>
							</div>
						</div>	

					</div>
				</div>
			</div>

		</div>
	</div><!-- End col  -->			
</div><!-- End row  -->
</div>
</div><!-- End container  -->