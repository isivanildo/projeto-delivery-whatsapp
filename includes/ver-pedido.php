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


(int) $pegaId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(empty($pegaId)):
  header("Location: {$site}");
else:
  $lerbanco->ExeRead('ws_pedidos', "WHERE user_id = :userid AND id = :f", "userid={$userlogin['user_id']}&f={$pegaId}");
  if (!$lerbanco->getResult()):
   header("Location: {$site}");
 else:
  foreach ($lerbanco->getResult() as $i):
    extract($i);
  endforeach;
endif;
endif;

?>

<div id="atualizaStatus"></div>
<div style="background-color:#ffffff;" class="container margin_60">

  <div class="big-title3 text-center">
    <h3 class="big_title3"><?=$codigo_pedido;?></h3>
    <p style=" border-bottom: 5px solid red;border-bottom-width: medium; padding-bottom: 10px;" class="title-para3">Código do Pedido!</p>
  </div>

  <?php
  $pegaStatusPost = filter_input_array(INPUT_POST, FILTER_DEFAULT); 

  if(!empty($pegaStatusPost)):

    $confirmarenviozap = (!empty($pegaStatusPost['confirm_whatsapp']) ? $pegaStatusPost['confirm_whatsapp'] : "");
    if(!empty($pegaStatusPost['confirm_whatsapp'])):
      unset($pegaStatusPost['confirm_whatsapp']);
    endif;

    unset($pegaStatusPost['enviarNovoStatus']);

    $pegaStatusPost = array_map('strip_tags', $pegaStatusPost);
    $pegaStatusPost = array_map('trim', $pegaStatusPost);

    if(in_array('', $pegaStatusPost)):
      echo "<div class=\"alert alert-info alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <center>Preencha todos os campos!</center>
      </div>";
    elseif(!isset($pegaStatusPost['status']) || $pegaStatusPost['status'] == ''):
      echo "<div class=\"alert alert-info alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <center>Selecione um Status!</center>
      </div>";
    elseif(!isset($pegaStatusPost['campomsg']) || $pegaStatusPost['campomsg'] == ''):
      echo "<div class=\"alert alert-info alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <center>Escreva uma mensagem para enviar ao ciente!</center>
      </div>";
    elseif(($pegaStatusPost['forma_pagamento'] == 'Dinheiro' || $pegaStatusPost['forma_pagamento'] == 'DINHEIRO' || $pegaStatusPost['forma_pagamento'] == 'dinheiro') && $pegaStatusPost['valor_troco'] != '0,00' && !empty($pegaStatusPost['valor_troco']) && Check::Valor($pegaStatusPost['valor_troco']) <= $total):

      echo "<div class=\"alert alert-info alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <center>Opss... O valor do troco não pode ser menor que o valor total!</center>
      </div>";
    else:


      $textoGet = $pegaStatusPost['campomsg'];
      unset($pegaStatusPost['campomsg']);

      $pegaStatusPost['valor_troco'] = Check::Valor($pegaStatusPost['valor_troco']);

      $updatebanco->ExeUpdate("ws_pedidos", $pegaStatusPost, "WHERE user_id = :userid AND id = :up", "userid={$userlogin['user_id']}&up={$pegaStatusPost['id']}");
      if ($updatebanco->getResult()):
        echo "<div class=\"alert alert-success alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
        <center>
        <b class=\"alert-link\">SUCESSO!</b> STATUS ATUALIZADO.
        </center>
        </div>";
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        $telefoneEmpresa = preg_replace("/[^0-9]/", "", $telefone_empresa);

        $empresaNome  = (!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');
        $msgAenviar = "🔔 *{$empresaNome}*%0A%0A{$textoGet} %0A%0A*Preparado por {$empresaNome}*";

        if(!empty($confirmarenviozap)):
        ?>
        <script type="text/javascript">
          var link1 = "https://api.whatsapp.com/send?phone=55<?=$telefone;?>&text=<?=$msgAenviar;?>";
          window.open( link1, "_blank");
        </script>
        <?php
      else:
      endif;

        header("Refresh: 2; url={$site}{$Url[0]}/pedidos");
      else:
        echo "<div class=\"alert alert-danger alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><center>
        <b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
        </center>
        </div>";
      endif;
    endif;
  endif;
  ?>
  
   <!-- The Modal -->
  <span id="modal_listMotoboys_open" data-toggle="modal" data-target="#modal_listMotoboys"></span>
  <div class="modal" style="margin-top: 80px;" id="modal_listMotoboys">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Motoboys</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <span>Envie o pedido diretamente no whatsapp do motoboy.</span></br></br>
            <!-- Function Modal -->
            <script>
                
            </script>
            <div id="content_listMotoboys">
                <table id="table_listMotoboys" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome do Entregador</th>
                            <th>Número de Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="table_tbody_listMotoboys">
                        <tr>
                            <td>1</td>
                            <td>Ronaldo Vasquez</td>
                            <td>(15) 12345-6789</td>
                            <td>
                                <button class="btn btn-primary btn-xs">Enviar Pedido</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <script>listMotoboys(<?=$codigo_pedido;?>);</script>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>
  
<script>
    function listMotoboys(id_ped) {
        <?= $lerbanco->ExeRead('ws_pedidos', "WHERE user_id = :userid", "userid={$userlogin['user_id']}"); ?>
        var listPedidos = <?=json_encode($lerbanco->getResult());?>;
        
        <?= $lerbanco->ExeRead('ws_motoboys', "WHERE user_id = :userid", "userid={$userlogin['user_id']}"); ?>
        var data = <?=json_encode($lerbanco->getResult());?>;
        
        var exists = false;
        if (listPedidos.length > 0) {
            for (i = 0; i < listPedidos.length; i++) {
                if (listPedidos[i]['id'] == id_ped) {
                    exists = i;
                    break;
                }
            }
        }
        
        if (exists == false) {
            alert("Pedido inválido no sistema");
            return;
        }
        
        var str = "";
        for (i = 0; i < data.length; i++) {
            var name = data[i]['deliveryman_name'];
            var phone_number = data[i]['deliveryman_phone_number'];
            var phone_number_nopont = phone_number.replace("(","");
            var phone_number_nopont = phone_number_nopont.replace(")","");
            var phone_number_nopont = phone_number_nopont.replace(" ","");
            var phone_number_nopont = phone_number_nopont.replace("-","");
            var text = "Pedido: "+listPedidos[exists]['codigo_pedido']+"%0ANome do Cliente: "+listPedidos[exists]['nome']+"%0ATelefone: "+listPedidos[exists]['telefone']+"%0AEndereço: "+listPedidos[exists]['rua']+", nº "+listPedidos[exists]['unidade']+"%0A"+listPedidos[exists]['bairro']+"%0A"+listPedidos[exists]['cidade']+"-"+listPedidos[exists]['uf']+"%0A%0AForma de Pagamento: "+listPedidos[exists]['forma_pagamento']+"%0AValor Total: "+listPedidos[exists]['total']+"%0ATroco: "+listPedidos[exists]['valor_troco'];
            var str = str+"<tr><td>"+(i+1)+"</td><td>"+name+"</td><td>"+phone_number+"</td><td><a target=\"_blank\" href=\"https://api.whatsapp.com/send?phone=55"+phone_number_nopont+"&text="+text+"\"><button class=\"btn btn-primary btn-xs\">Enviar Pedido</button></a></td></tr>";
        }
        $("#table_tbody_listMotoboys").html(str);
        $("#modal_listMotoboys_open").click();
    }
</script>

  <style type="text/css">
    #divImprimir{
     size: auto;

     margin: 2mm 2mm 2mm 2mm;  

     font-family: monospace;

     font-size: 9pt;

     width: 80mm;
   }
 </style>

 <center>
  <a href="<?=$site,$Url[0];?>/pedidos"><button class="btn_1"><i class="fa fa-reply" aria-hidden="true"></i> voltar</button></a>

  <a href="https://api.whatsapp.com/send?phone=55<?=$telefone;?>&text=🔔 Olá, você acaba de realizar um pedido conosco. Estamos ansiosos para lhe atender. Podemos confirmar o pedido?"><button class="btn_1">Confirmar o Pedido <i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>
  
  <button id="botaoPrint" class="btn_1">Imprimir Pedido <i class="icon-print-2" aria-hidden="true"></i></button></a>
  
  
</center>
<div> 
  <div class="container">
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">
      <article class="col-md-4">
        <div id="divImprimir" style="background-color: #fdfbe3;" class="boxed-md boxed-padded">
          <?php

          $dataex = explode(' ', $data);
          $dataex[0] = explode('-', $dataex[0]);
          $dataex[0] = array_reverse($dataex[0]);
          $dataex[0] = implode('/', $dataex[0]);

          $dataformatada =  $dataex[0].' - '.$dataex[1];

          $nome = str_replace('%20', ' ', $nome);
          $nomeCliente = $nome;
          $telefoneformatado = formatPhone($telefone);

          $taxaPedido = Check::Real($valor_taxa);
          $valorTroco = Check::Real($valor_troco);
          $totalPedido = Check::Real($total);

          $resumoPedidosFormatado = str_replace('*', '', $resumo_pedidos);
          $resumoPedidosFormatado = str_replace('<b>', '', $resumoPedidosFormatado);
          $resumoPedidosFormatado = str_replace('</b>', '', $resumoPedidosFormatado);

          $telefoneEmpresaFormatado = formatPhone($telefone_empresa);

          echo "<b>".$nome_empresa."</b>";
          echo ".\n <br />";

          echo (!empty($end_rua_n_empresa) && !empty($end_bairro_empresa) && !empty($cidade_empresa) && !empty($end_uf_empresa) ? $end_rua_n_empresa.' <br /> '.$end_bairro_empresa : 'Defina_um_endereço').' - '.$cidade_empresa.' - '.$end_uf_empresa;
          echo "\n <br />";
          echo "Telefone: {$telefoneEmpresaFormatado}";


          echo "\n <br />";
          echo "\n <br />";

          echo "<b>PEDIDO: #{$codigo_pedido}</b>\n <br />";    
          echo "{$dataformatada} <br />";  
          echo "\n <br />";
          echo "-----------------------------"."\n  <br />";      
          if($opcao_delivery != 'true'):
            echo "{$msg_delivery_false}\n  <br />";
            echo "Observações: {$name_observacao_mesa}\n  <br />";
          else:
            echo "Rua: {$logradouro}, Nº {$cidade}\n  <br />";
            echo "Bairro: {$bairro}\n  <br />";
            echo "Cidade: {$cidade} - {$uf}\n  <br />";
            echo "Complemento: {$complemento}\n  <br />";
            echo "Observação: {$observacao}\n  <br />";
          endif;
          echo "-----------------------------"."\n  <br />"; 
          echo "\n <br />";  


          echo "DADOS DO CLIENTE: <br />";

          echo "NOME: {$nomeCliente}\n  <br />";
          echo "TEL: {$telefoneformatado}\n  <br />";  

          echo "-----------------------------"."\n  <br />"; 
          echo "\n <br />"; 

          echo "RESUMO DO PEDIDO: <br />";
          echo "{$resumoPedidosFormatado}";
          
          echo "-----------------------------"."\n  <br />";  

          echo "PAGAMENTO: {$forma_pagamento}\n  <br />";
          echo (!empty($sub_total) || $sub_total != '0.00' ? "SUBTOTAL: R$ ".Check::Real($sub_total)." \n <br />" : "" );
          if(!empty($desconto) && $desconto != 0):
            echo "DESCONTO: {$desconto}% \n <br />";
          endif;
          if($valor_taxa != '0.00'):
            echo "DELIVERY: R$ {$taxaPedido}\n  <br />";
          endif;                    
          echo "TOTAL: R$ {$totalPedido} \n <br />";
          if(!empty($valor_troco) && $valor_troco != '0.00'):
            echo "TROCO PARA: R$ {$valorTroco}\n  <br />";
          endif;
          echo "-----------------------------"." \n <br />";
          
          echo "\n <br />";

          echo "***OBRIGADO E BOM APETITE*** \n <br />";
          ?>
        </div>
      </article>
    </div>
  </div>
</div>
<center>
    
    
    
 <a style="margin: 15px;" id="botaoPrint2" class="btn btn-primary">Reimprimir Pedido<i class="icon-print-2"></i></button></a>
 <button onclick="listMotoboys(<?=$id;?>);" class="btn btn-success btn-xs">Enviar ao Motoboy</button>
</center>
<div class="container">
  <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">

    <form method="post" action="#atualizaStatus">
      <div class="text__center">
        <h3>Status do pedido: <strong><?=$status;?></strong></h3>

        <select name="status" required class="form-control status">
         <option value="" disabled selected><b>Atualizar Status</b></option>
         <?php
         if($opcao_delivery == 'true'):
          ?>
          <option value="Em Andamento">Em Andamento</option>
          <option value="Saiu para Entrega">Saiu para Entrega</option>            
          <option value="Finalizado">Finalizado</option>
          <option value="Cancelado">Cancelado</option>
          <?php
        else:
          ?>
          <option value="Em Andamento">Em Andamento</option>
          <option value="Disponível para Retirada">Disponível para Retirada</option> 
          <option value="Finalizado">Finalizado</option>
          <option value="Cancelado">Cancelado</option>
          <?php
        endif;
        ?> 
      </select>




    </div>
      <br />
    <div class="form-group">                
      <div class="icheck-material-green">
        <input type="checkbox" name="confirm_whatsapp" value="true" id="green" />
        <label for="green"><strong>Enviar msg para o whatsapp do cliente.</strong></label>
      </div>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea5"></label>
      <textarea id="campomsg" name="campomsg" required class="form-control" rows="5" ></textarea>
      <center><small>Essa msg será enviada ao cliente pelo whatsapp.</small></center>
    </div>


    <input type="hidden" name="id" value="<?=$id;?>">
    <hr />
    <div class="form-group">
      <label for="forma_pagamento"><span style="color: red;">* </span><?=$texto['msg_f_pagamento'];?></label>
      <select class="form-control" required name="forma_pagamento" id="forma_pagamento">  
        <?php 
        $lerbanco->ExeRead('ws_formas_pagamento', 'WHERE user_id = :idus', "idus={$getu}");
        if($lerbanco->getResult()):
          foreach ($lerbanco->getResult() as $getBancoBairros):
            extract($getBancoBairros);
            ?>
            <option <?=(!empty($forma_pagamento) && $forma_pagamento == $f_pagamento ? "selected" : "");?> value="<?=$f_pagamento;?>"><?=$f_pagamento;?></option>
            <?php
          endforeach;
        endif;

        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="valor_troco"><span style="color: red;">* </span><?=$texto['msg_troco'];?></label>
      <input type="tel" maxlength="11" value="<?=(!empty($valor_troco) && $valor_troco != "0.00" ? Check::Real($valor_troco) : "0,00");?>" data-mask="#.##0,00" data-mask-reverse="true" name="valor_troco" id="valor_troco" class="form-control" placeholder="0,00" />
    </div>

    <input type="hidden" name="enviarNovoStatus" value="true" />
    <center><button type="input" class="btn_1">SALVAR ALTERAÇAO</button></center>

  </form>
</div></div>
</div>
<br />
<div class="alert alert-info container margin_60">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon-attach-3"></i> NOTAS!</h4>
  <p>
   <strong style="color: red;">Não envia a mensagem para o whatsapp do cliente!</strong> se estiver em um computador verifique se seu navegador não esta bloqueando pop-ups.<br /> 
   <strong style="color: red;">Erro com impressão em térmicas!</strong> Tente atualizar os drivers da impressora!

 </p>

</div>



<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#botaoPrint').click(function(){
      $('#divImprimir').printThis({
        doctypeString: '<meta charset="utf-8">', 
        importStyle: true,
        base: false,
      });
    });
  });
</script>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#botaoPrint2').click(function(){
      $('#divImprimir').printThis({
        doctypeString: '<meta charset="utf-8">', 
        importStyle: true,
        base: false,
      });
    });
  });
</script>



<script type="text/javascript"> 
  $(document).ready(function() {
    $('.status').change(function (){
     var newStatus = $(this).val();

     if(newStatus == 'Em Andamento'){
      $("#campomsg").val('Ola! Já estamos preparando seu pedido.');
    }else if(newStatus == 'Saiu para Entrega'){
      $("#campomsg").val('Ola! O seu pedido está a caminho.');
    }else if(newStatus == 'Disponível para Retirada'){
      $("#campomsg").val('Ola! Seu pedido já esta disponível para retirada em nosso estabelecimento.');
    }else if(newStatus == 'Finalizado'){
      $("#campomsg").val('Pedido entregue! Obrigado pela preferência.');
    }else if(newStatus == 'Cancelado'){
      $("#campomsg").val('Ola! Seu pedido foi cancelado.');
    }    
  });
  });
</script>

<script type="text/javascript">

    //Recupera o valor para validar o campo troco.
    $('#forma_pagamento').change(function (){

      var tell = $(this).val();
      
      if (tell == "Dinheiro" || tell == "DINHEIRO" || tell == "dinheiro") {
        $('#valor_troco').prop('readonly', false);
      }
      else {
        $('#valor_troco').val('0,00');
        $('#valor_troco').prop('readonly', true);
      }
    });
  </script>

