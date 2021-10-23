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
<style type="text/css">
  #custom-search-input{
    padding: 3px;
    border: solid 1px #E4E4E4;
    border-radius: 6px;
    background-color: #fff;
  }

  #custom-search-input input{
    border: 0;
    box-shadow: none;
  }

  #custom-search-input button{
    margin: 2px 0 0 0;
    background: none;
    box-shadow: none;
    border: 0;
    color: #666666;
    padding: 0 8px 0 10px;
    border-left: solid 1px #ccc;
  }

  #custom-search-input button:hover{
    border: 0;
    box-shadow: none;
    border-left: solid 1px #ccc;
  }

  #custom-search-input .glyphicon-search{
    font-size: 23px;
  }
</style>
<div id="idview-item"></div>
<div style="background-color:#ffffff;" class="row">
  <div class="col-md-12">
    <div class="widget">
      <div class="indent_title_in">
        <i class="fa fa-cutlery" aria-hidden="true"></i>
        <h3>Ver todos os itens do Menu!</h3>
        <p><b style="color: red;">OBSERVAÇÃO: Em "Qtd. adicionais grátis" e "Qtd. adicionais pagos" você determina o total de adicionais que pode ser selecionado pelo  cliente.<br />0 = significa que o cliente pode selecionar todos os adicionais!<br />Se o item não tiver adicionais basta ignorar esse campo, para alterar basta informar a quantidade e clicar fora do campo.</b></p>
      </div>
      <div class="widget-content">


        <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="container">
          <div class="row">
            <form action="#search" method="post">
              <div class="col-md-6">           
                <div id="custom-search-input">
                  <div class="input-group col-md-12">
                    <input type="text" name="s" class="form-control input-lg" placeholder="Pesquisar Item" />
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-lg" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <br />
        <br />


        <div class="table-responsive" id="search">
          <table data-sortable class="table table-hover table-striped">
            <thead>
              <tr>
                <th>Imagem</th>              
                <th>Categoria</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>                      
                <th>Qtd. adicionais grátis</th>                      
                <th>Qtd. adicionais pagos</th>                      
                <th data-sortable="false">Disponível</th>
                <th data-sortable="false">Editar</th>
                <th data-sortable="false">Excluir</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $seach = filter_input(INPUT_POST, 's', FILTER_DEFAULT);
              if(!empty($seach)):
                $seach = strip_tags(trim(urlencode($seach)));
                header("Location: {$site}{$Url[0]}/view-item&s={$seach}");
              endif;


              $search_url = filter_input(INPUT_GET, 's', FILTER_DEFAULT);
              if(!empty($search_url)):
                $searchpage = $search_url;
                $search_url = urldecode($search_url);
              endif;

//INICIO PAGINAÇÃO
              $getpage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

              $quary   = "WHERE user_id = :userid ";
              $quary2  = "userid={$userlogin['user_id']}&";

              if(!empty($search_url)):

                $pager = new Pager("{$site}{$Url[0]}/view-item&s={$search_url}&page="); 
                $quary   = "WHERE user_id = ".$userlogin['user_id']." AND (nome_item LIKE '%' :linkum '%' or descricao_item LIKE '%' :linkdois '%') ";
                $quary2  = "linkum={$search_url}&linkdois={$search_url}&";

              else:
                //$pager = new Pager("{$site}admin/painel.php?exe=home&page="); 
                $pager = new Pager("{$site}{$Url[0]}/view-item&page=");

              endif;

              $pager->ExePager($getpage, 10);
//FIM PAGINAÇÃO
                
                //echo $quary;
              $lerbanco->ExeRead("ws_itens", "{$quary}ORDER BY id DESC LIMIT :limit OFFSET :offset", "{$quary2}limit={$pager->getLimit()}&offset={$pager->getOffset()}"); 



              if (!$lerbanco->getResult()):

               if(!empty($search_url)):

                 echo "
                <div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
                <center>RESULTADO DA PESQUISA: 0 <BR /><strong><a href='{$site}{$Url[0]}/view-item'>CLIQUE AQUI PARA VOLTAR</a></strong></center>
                </div>

                ";
              else:
                echo "
                <div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
                <center><strong>Sem dados a serem exibidos.</strong></center>
                </div>

                ";
              endif;



              $pager->ReturnPage();               
            else:
             
                    if(!empty($search_url)):
                        echo '<center><a href="'.$site.$Url[0].'/view-item"><button id="demo-btn-addrow" class="btn btn-outline btn-primary btn-sm"> VOLTAR PARA TODOS OS ITENS</button></a></center><br /><br />';
                    endif;
           
              foreach ($lerbanco->getResult() as $getItensBanco):
                extract($getItensBanco);               
                ?>
                <!-- INICIO DO LOOP DA LEITURA DO BANCO --> 
                <tr>
                 <td>
                  <div style="width:40px;" class="img-wrap">
                    <?php
                    if (!empty($img_item) && $img_item != "" && file_exists("uploads/{$img_item}") && !is_dir("uploads/{$img_item}")):
                      echo Check::Image('uploads/'.$img_item, 'Imagem-item', 40, 33);
                  else:
                    echo Check::Image('img/camara2.png', 'Imagem-item', 40, 33);
                  endif;
                  ?>
                </div>
              </td>
              <td>
                <strong>
                  <?php
                  $lerbanco->ExeRead('ws_cat', "WHERE user_id = :userid AND id = :idcatt", "userid={$userlogin['user_id']}&idcatt={$id_cat}");
                  if($lerbanco->getResult()):
                    $dadoscat = $lerbanco->getResult();
                    echo $dadoscat[0]['nome_cat'];
                  endif;
                  ?>
                </strong>
              </td>
              <td><?=(!empty($nome_item) ? limitarTexto($nome_item, 40) : '');?></td>
              <td><?=(!empty($preco_item) ? 'R$ '.Check::Real($preco_item) : '');?></td>
              <td><?=(!empty($descricao_item) ? limitarTexto($descricao_item, 30) : '');?></td>

              <td><input type="number" data-produtoid="<?=$id;?>" class="form-control numero number_adicional" name="number_adicional" min="1" max="1000" value="<?=(!empty($number_adicional) ? $number_adicional : "")?>" placeholder="0">
              </td>

              <td><input type="number" data-produtoid="<?=$id;?>" class="form-control numero number_adicional_pago" name="number_adicional_pago" min="1" max="1000" value="<?=(!empty($number_adicional_pago) ? $number_adicional_pago : "")?>" placeholder="0">
              </td>

              <td>
                <div class="ckbx-style-14">
                  <input <?=(!empty($disponivel) && $disponivel == 1 ? 'checked' : '');?> value="<?=$id;?>" type="checkbox" id="atualizar_<?=$id;?>" name="ckbx-style-14">
                  <label class="atualizar_<?=$id;?>" for="atualizar_<?=$id;?>"></label>
                </div>                  
                
                <script type="text/javascript">
                  $(document).ready(function(){
                    $('.atualizar_<?=$id;?>').click(function(){
                      var idDoItem = $('#atualizar_<?=$id;?>').val();
                      $.ajax({
                        url: '<?=$site;?>includes/processaDisponibilidadeItens.php',
                        method: "post",
                        data: {'iditem' : idDoItem, 'iduser' : '<?=$userlogin['user_id'];?>'},

                        success: function(data){  
                        }
                      });
                    });
                  });


                </script>
              </td>              
              <td>
                <center>
                  <a href="<?=$site.$Url[0].'/up-item&id='.$id.'#upitem';?>"><p data-placement="top" data-toggle="tooltip" title="Editar"><button class="btn btn-primary" data-title="Editar"><span class="glyphicon glyphicon-pencil"></span></button></p></a>
                </center>
              </td>
              <td>
                <center>
                  <button data-getiddell="<?=$id;?>" class="btn btn-danger deletarItem"><span class="glyphicon glyphicon-trash"></span></button>
                </center>
              </td>
            </tr>  
            <!-- FINAL DO LOOP DA LEITURA DO BANCO --> 
            <?php
          endforeach;
        endif;
        ?>              
      </tbody>
    </table>
  </div>
  <div class="data-table-toolbar">
   <?php
      //INICIO PAGINAÇÃO
   $pager->ExePaginator("ws_itens",  "{$quary}", "{$quary2}");
   echo $pager->getPaginator();
      //FIM PAGINAÇÃO
   ?>  

 </div>
</div>
</div>
</div>

</div>

<div id="resultadiasemana"></div>

<script type="text/javascript">
  $('.number_adicional_pago').change(function (){

    var valor_total_number = $(this).val();
    var id_produto = $(this).data('produtoid');
    var iduser = '<?=$userlogin['user_id'];?>';

    $.ajax({
      url: '<?=$site;?>controlers/edit-opcao-adicionais-pagos.php',
      method: "post",
      data: {'idproduto' : id_produto, 'valor' : valor_total_number, 'iduser' : iduser},

      success: function(data){       
        if(data == 'true'){
          x0p('Sucesso!', 
            'O item foi atualizado!', 
            'ok', false);
        }else if(data == 'false'){
          x0p('Opss...', 
            'OCORREU UM ERRO!',
            'error', false);
        }
      }
    }); 

  });
</script>

<script type="text/javascript">
  $('.number_adicional').change(function (){

    var valor_total_number = $(this).val();
    var id_produto = $(this).data('produtoid');
    var iduser = '<?=$userlogin['user_id'];?>';

    $.ajax({
      url: '<?=$site;?>controlers/edit-opcao-adicionais.php',
      method: "post",
      data: {'idproduto' : id_produto, 'valor' : valor_total_number, 'iduser' : iduser},

      success: function(data){       
        if(data == 'true'){
          x0p('Sucesso!', 
            'O item foi atualizado!', 
            'ok', false);
        }else if(data == 'false'){
          x0p('Opss...', 
            'OCORREU UM ERRO!',
            'error', false);
        }
      }
    }); 

  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $(".deletarItem").click(function(){

      var iddoitemdel = $(this).data('getiddell');

      GrowlNotification.notify({
        title: 'Atenção!',
        description: 'Tem certeza de que deseja deletar este item?',
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
            text: ' Deletar',
            callback: function(){
              $.ajax({
                url: '<?=$site;?>includes/processadeletaritem.php',
                method: 'post',
                data: {'iditemdeletar' : iddoitemdel, 'iduser' : '<?=$userlogin['user_id'];?>'},
                success: function(data){
                  if(data == 'true'){
                    window.location.reload(1);
                  }
                }
              });

            }
          },
          cancel: {
            text: ' Cancelar'
          }
        },
        closeTimeout: 0
      });         

    });
  });
</script>


