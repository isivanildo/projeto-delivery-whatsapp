<?php
ob_start();
session_cache_expire(60);
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$detect = new Mobile_Detect;

$site = HOME;

$login = new Login(3);

if($login->CheckLogin()):
  $idusuar = $_SESSION['userlogin']['user_id'];
  $lerbanco->ExeRead('ws_empresa', "WHERE user_id = :idcliente", "idcliente={$idusuar}");

  if (!$lerbanco->getResult()):       
  else:
    foreach ($lerbanco->getResult() as $i):
      extract($i);
    endforeach;
    header("Location: {$site}{$nome_empresa_link}/lojas");
  endif;

else:
endif;
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="pt-br">
<head><meta charset="utf-8">
  
  <title><?=$texto['titulo_site_landing'];?></title>
  <meta name="robots" content="index, fallow" />
  <link rel="canonical" href="<?=$site;?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">    
  <meta name="keywords" content="<?=$texto['keywords_landing'];?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="author" content="<?=$texto['autor_site_landing'];?>">
  <meta property="og:site_name" content="<?=$texto['nome_site_landing'];?>"/>
  <meta property="og:url" content="<?=$site;?>"/>
  <meta name="description" content="<?=$texto['descricao_site_landing'];?>" />
  <meta property="og:description" content="<?=$texto['descricao_site_landing'];?>" />

  <link rel="shortcut icon" href="<?= $site; ?>img/favicon.png" type="image/x-icon">

  <!-- GOOGLE WEB FONT -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>

  <!-- BASE CSS -->
  <link href="<?=$site;?>css/base.css" rel="stylesheet">

  <link href="<?=$site;?>css/suportewats.css" rel="stylesheet">

  <!-- SPECIFIC CSS -->
  <link href="<?=$site;?>css/morphext.css" rel="stylesheet">

  <!-- Radio and check inputs -->
  <link href="<?=$site;?>css/skins/square/grey.css" rel="stylesheet">
  <link href="<?=$site;?>css/ion.rangeSlider.css" rel="stylesheet">
  <link href="<?=$site;?>css/ion.rangeSlider.skinFlat.css" rel="stylesheet" >
  <link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">


  <!-- INCLUDE JQUARY -->
  <script src="<?=$site;?>js/jquery-2.2.4.min.js"></script>

  <link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
  <script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css'>
  <link href="<?= $site; ?>css/color_scheme.css" rel="stylesheet"> 
</head>

<body>

<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
  <![endif]-->

  <div id="preloader">
    <div class="sk-spinner sk-spinner-wave" id="status">
      <div class="sk-rect1"></div>
      <div class="sk-rect2"></div>
      <div class="sk-rect3"></div>
      <div class="sk-rect4"></div>
      <div class="sk-rect5"></div>
    </div>
  </div><!-- End Preload -->

  <!-- Header ================================================== -->
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col--md-4 col-sm-4 col-xs-4">
          <a href="<?=$site;?>" id="logo">
            <img src="<?= $site; ?>img/home.png" height="30" width="40" alt="" data-retina="true" class="hidden-xs">
            <img src="<?= $site; ?>img/home.png" height="30" width="40" alt="" data-retina="true" class="hidden-lg hidden-md hidden-sm">
          </a>
        </div>
        <nav class="col--md-8 col-sm-8 col-xs-8">
          <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
          <div class="main-menu">
            <div id="header_menu">

              <center><b style="color:#78866b;">MENU</b></center>
            </div>
            <a href="#" class="open_close" id="close_in"><i class="icon_close"></i></a>
            <ul>
              <li><a href="https://mrinformatica.net.br/">CONHEÇA A BELEMTECH</a></li>
              <li><a href="<?=$site?>home">LOGISTA - ENTENDA O SISTEMA</a></li>
              <li><a href="<?=$site;?>login">LOGIN</a></li>

            </ul>
          </div><!-- End main-menu -->
        </nav>
      </div><!-- End row -->
    </div><!-- End container -->
  </header>
  <!-- End Header =============================================== -->

  <!-- SubHeader =============================================== -->
  <section class="parallax-window" id="home" data-parallax="scroll" data-image-src="sub_header_cart.jpg" data-natural-width="1400" data-natural-height="350">

   <div id="subheader">

      <div id="sub_content">
        <img src="imagem-logo.png" alt="iFoomeZap" style="width:25%;margin-top:-13%;">
        <h2 style="color: #fff; font-size: 50px !important">Procurando <strong id="js-rotating"><b></b>Os Melhores Restaurantes?</b></strong></h2>
        <p>
          Os melhores cardápios estão aqui. Pará Delivery, Descubra!
        </p>
        <form method="post" id="formsearch">
          <div id="custom-search-input">
            <div class="input-group ">
              <input type="text" class="search-query cep" id="valor_cep" placeholder="Digite o bairro ou nome do estabelecimento">
            </b>            
            <span class="input-group-btn">

              <input class="btn_search" id="pesquisar" value="submit">

            </span>
          </div>
        </div>
      </form>        
    </div><!-- End sub_content -->
  </div><!-- End subheader -->



  <script type="text/javascript">
    $(document).ready(function(){
      $('#pesquisar').click(function(){
        var pesquisa = $('#valor_cep').val();
        pesquisa = pesquisa.replace("-", "").replace(".", "");

        if(pesquisa == ''){
          x0p('Opss...', 
            'Informe o CEP',
            'error', false);
        }else if(pesquisa.length == 1){
          x0p('Opss...', 
            'O formato do CEP e inválido!',
            'error', false);
        }else{


          $.ajax({
            url: '<?=$site?>controlers/processabuscacliente.php',
            method: 'post',
            data: {'valor_do_cep' : pesquisa},
            success: function(data){

              if(data == 1){
                x0p('Opss... 😕', 
                  'Registro não encontrado, verifique novamente.',
                  'error', false);
              }else if(data == 2){
               x0p('Que pena! 😔', 
                'Ainda não temos opções nessa região.',
                'error', false);
             }else{
              $('#resultadobusca').html(data);

              $('html, body').animate({
                scrollTop: $("#resultadobuscaa").offset().top
              }, 2000);

            }    

          }
        });

        }
      });
    });
  </script>


  <div id="count" class="hidden-xs">
   <?php
   $totalCliente = 0;
   $lerbanco->ExeRead("ws_users");
   if( $lerbanco->getResult()):
    $totalCliente = $totalCliente + $lerbanco->getRowCount();
  endif;

  $totalItens = 0;
  $lerbanco->ExeRead("ws_itens");
  if( $lerbanco->getResult()):
    $totalItens = $totalItens + $lerbanco->getRowCount();
  endif;

  $totalPedidos = 0;
  $lerbanco->ExeRead("ws_pedidos");
  if( $lerbanco->getResult()):
    $totalPedidos = $totalPedidos + $lerbanco->getRowCount();
  endif;
  ?>
  <ul>
   <li><span class="number"><?=$totalCliente;?></span> Parceiros</li>
   <li><span class="number"><?=$totalItens;?></span> Itens cadastrados</li>
   <li><span class="number"><?=$totalPedidos;?></span> Pedidos Realizados</li>
 </ul>
</div>
<div id="resultadobuscaa"></div>
</section><!-- End section -->
<!-- End SubHeader ============================================ -->


<div id="resultadobusca">


</div>






<?php

$lerbanco->FullRead("select * from ws_empresa join views on ws_empresa.user_id = views.user_id WHERE ws_empresa.empresa_data_renovacao >= CURRENT_DATE ORDER BY views.contar DESC LIMIT 10");
if(!$lerbanco->getResult()):
else: 
  ?>

  <div class="white_bg">
    <div class="container margin_60">

      <div class="main_title">
        <h2 class="nomargin_top">Parceiros Selecionados para Você</h2>
        <p>

        </p>
      </div>

      <div class="row">
       <?php
       foreach ($lerbanco->getResult() as $i):
        extract($i);
        ?>
        <div class="col-md-6">
          <a href="<?=$site.$nome_empresa_link?>" class="strip_list">
            <div class="ribbon_1">Popular</div>
            <div class="desc">
              <div class="thumb_strip">


                <?php
                if(!empty($img_logo)):
                  echo "<img width=\"240\" height=\"240\" src=\"{$site}uploads/{$img_logo}\" alt=\"\">";
                else:
                  echo "<img src=\"{$site}img/thumb_restaurant.jpg\" alt=\"\">";
                endif;
                ?>
              </div>
              <div class="rating">
                <i class="icon_star voted"></i>
                <i class="icon_star voted"></i>
                <i class="icon_star voted"></i>
                <i class="icon_star voted"></i>
                <i class="icon_star voted"></i>
              </div>
              <h3><?=(!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');?></h3>              
              

              <div class="location">
                Rua <?=$end_rua_n_empresa;?>
                <?=$end_bairro_empresa;?><br />

                <?php
            // REQUERIDOS
    // Definir horário de funcionamento diário
    // Deve estar no formato de 24 horas, separado por traço
    // Se fechado para o dia, deixe em branco (por exemplo, domingo) ou não adicione linha
    // Se aberto várias vezes em um dia, insira intervalos de tempo separados por vírgula



                $hours = array();      



         //CONFIGURAÇÃO DE SEGUNDA FEIRA
                if(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "false"):
                  $hours['mon'] = array();
              elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "true"):
                $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate, $segunda_tarde_de.'-'.$segunda_tarde_ate);

            elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "false"):
              $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate);
          elseif(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "true"):
            $hours['mon'] = array($segunda_tarde_de.'-'.$segunda_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE SEGUNDA FEIRA

        //CONFIGURAÇÃO DE TERÇA FEIRA
        if(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "false"):
          $hours['tue'] = array();
      elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "true"):
        $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate, $terca_tarde_de.'-'.$terca_tarde_ate);

    elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "false"):
      $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate);
  elseif(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "true"):
    $hours['tue'] = array($terca_tarde_de.'-'.$terca_tarde_ate);
endif;
        //CONFIGURAÇÃO DE TERÇA FEIRA

         //CONFIGURAÇÃO DE QUARTA FEIRA
if(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "false"):
  $hours['wed'] = array();
elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "true"):
  $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate, $quarta_tarde_de.'-'.$quarta_tarde_ate);

elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "false"):
  $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate);
elseif(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "true"):
  $hours['wed'] = array($quarta_tarde_de.'-'.$quarta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUARTA FEIRA

         //CONFIGURAÇÃO DE QUINTA FEIRA
if(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "false"):
  $hours['thu'] = array();
elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "true"):
  $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate, $quinta_tarde_de.'-'.$quinta_tarde_ate);

elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "false"):
  $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate);
elseif(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "true"):
  $hours['thu'] = array($quinta_tarde_de.'-'.$quinta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUINTA FEIRA

        //CONFIGURAÇÃO DE SEXTA FEIRA
if(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "false"):
  $hours['fri'] = array();
elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "true"):
  $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate, $sexta_tarde_de.'-'.$sexta_tarde_ate);

elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "false"):
  $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate);
elseif(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "true"):
  $hours['fri'] = array($sexta_tarde_de.'-'.$sexta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SEXTA FEIRA

         //CONFIGURAÇÃO DE SABADO
if(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "false"):
  $hours['sat'] = array();
elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "true"):
  $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate, $sabado_tarde_de.'-'.$sabado_tarde_ate);

elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "false"):
  $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate);
elseif(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "true"):
  $hours['sat'] = array($sabado_tarde_de.'-'.$sabado_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SABADO

        //CONFIGURAÇÃO DE DOMINGO
if(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "false"):
  $hours['sun'] = array();
elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "true"):
  $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate, $domingo_tarde_de.'-'.$domingo_tarde_ate);

elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "false"):
  $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate);
elseif(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "true"):
  $hours['sun'] = array($domingo_tarde_de.'-'.$domingo_tarde_ate);
endif;
        //CONFIGURAÇÃO DE DOMINGO

$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :delivdata", "delivdata={$user_id}");
$exceptions = array();
if($lerbanco->getResult()):
  foreach($lerbanco->getResult() as $dadosC):
    extract($dadosC);
    $i = explode('/', $data);
    $i = array_reverse($i);
    $i = implode("-", $i);              

    if(isDateExpired($i, 1)):
      $exceptions["{$i}"] = array();              
    endif;
  endforeach;
endif;


          // Iniciando a classe
$store_hours = new StoreHours($hours, $exceptions);


           // Display open / closed menssagem
if($store_hours->is_open()) {
  echo "<span style='color:#86c953;'>ABERTO AGORA</span>";
} else {
  echo "<span class=\"opening\">FECHADO</span>";
}
?>   


<?=(!empty($minimo_delivery) && $minimo_delivery != '0.00' ? "- Valor mínimo Delivery: R$ ".Check::Real($minimo_delivery) : '');?>
</div>


<ul> 
  <?php if(!empty($confirm_delivery) && $confirm_delivery == "true"): ?>

    <li>Delivery<i class="icon_check_alt2 ok"></i></li>
    <?php else: ?>
      <li>Delivery<i class="icon_check_alt2 no"></i></li>
    <?php endif; ?>



    <?php if(!empty($confirm_balcao) && $confirm_balcao == "true"): ?>
      <li>Retirar no Balcão<i class="icon_check_alt2 ok"></i></li>
      <?php else: ?>
        <li>Retirar no Balcão<i class="icon_check_alt2 no"></i></li>
      <?php endif; ?>

    </ul>
  </div><!-- End desc-->
</a><!-- End strip_list-->


</div><!-- End col-md-6-->   
<?php
endforeach;
?>   
</div><!-- End row -->           
</div><!-- End container -->
</div><!-- End white_bg -->

<?php

endif;
?>






<?php

$lerbanco->FullRead("select * from ws_empresa WHERE empresa_data_renovacao >= CURRENT_DATE ORDER BY id_empresa DESC LIMIT 10");
if(!$lerbanco->getResult()):
else: 
  ?>

  <div class="white_bg">
    <div class="container margin_60">

      <div class="main_title">
        <h2 class="nomargin_top">Últimos parceiros</h2>
        <p>

        </p>
      </div>

      <div class="row">
       <?php
       foreach ($lerbanco->getResult() as $i):
        extract($i);
        ?>
        <div class="col-md-6">
          <a href="<?=$site.$nome_empresa_link?>" class="strip_list">
         
            <div class="desc">
              <div class="thumb_strip">


                <?php
                if(!empty($img_logo)):
                  echo "<img width=\"240\" height=\"240\" src=\"{$site}uploads/{$img_logo}\" alt=\"\">";
                else:
                  echo "<img src=\"{$site}img/thumb_restaurant.jpg\" alt=\"\">";
                endif;
                ?>
              </div>
              <h3><?=(!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');?></h3>              
              

              <div class="location">
                Rua <?=$end_rua_n_empresa;?>
                <?=$end_bairro_empresa;?><br />

                <?php
            // REQUERIDOS
    // Definir horário de funcionamento diário
    // Deve estar no formato de 24 horas, separado por traço
    // Se fechado para o dia, deixe em branco (por exemplo, domingo) ou não adicione linha
    // Se aberto várias vezes em um dia, insira intervalos de tempo separados por vírgula



                $hours = array();      



         //CONFIGURAÇÃO DE SEGUNDA FEIRA
                if(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "false"):
                  $hours['mon'] = array();
              elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "true"):
                $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate, $segunda_tarde_de.'-'.$segunda_tarde_ate);

            elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "false"):
              $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate);
          elseif(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "true"):
            $hours['mon'] = array($segunda_tarde_de.'-'.$segunda_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE SEGUNDA FEIRA

        //CONFIGURAÇÃO DE TERÇA FEIRA
        if(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "false"):
          $hours['tue'] = array();
      elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "true"):
        $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate, $terca_tarde_de.'-'.$terca_tarde_ate);

    elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "false"):
      $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate);
  elseif(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "true"):
    $hours['tue'] = array($terca_tarde_de.'-'.$terca_tarde_ate);
endif;
        //CONFIGURAÇÃO DE TERÇA FEIRA

         //CONFIGURAÇÃO DE QUARTA FEIRA
if(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "false"):
  $hours['wed'] = array();
elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "true"):
  $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate, $quarta_tarde_de.'-'.$quarta_tarde_ate);

elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "false"):
  $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate);
elseif(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "true"):
  $hours['wed'] = array($quarta_tarde_de.'-'.$quarta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUARTA FEIRA

         //CONFIGURAÇÃO DE QUINTA FEIRA
if(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "false"):
  $hours['thu'] = array();
elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "true"):
  $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate, $quinta_tarde_de.'-'.$quinta_tarde_ate);

elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "false"):
  $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate);
elseif(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "true"):
  $hours['thu'] = array($quinta_tarde_de.'-'.$quinta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE QUINTA FEIRA

        //CONFIGURAÇÃO DE SEXTA FEIRA
if(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "false"):
  $hours['fri'] = array();
elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "true"):
  $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate, $sexta_tarde_de.'-'.$sexta_tarde_ate);

elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "false"):
  $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate);
elseif(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "true"):
  $hours['fri'] = array($sexta_tarde_de.'-'.$sexta_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SEXTA FEIRA

         //CONFIGURAÇÃO DE SABADO
if(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "false"):
  $hours['sat'] = array();
elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "true"):
  $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate, $sabado_tarde_de.'-'.$sabado_tarde_ate);

elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "false"):
  $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate);
elseif(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "true"):
  $hours['sat'] = array($sabado_tarde_de.'-'.$sabado_tarde_ate);
endif;
        //CONFIGURAÇÃO DE SABADO

        //CONFIGURAÇÃO DE DOMINGO
if(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "false"):
  $hours['sun'] = array();
elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "true"):
  $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate, $domingo_tarde_de.'-'.$domingo_tarde_ate);

elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "false"):
  $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate);
elseif(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "true"):
  $hours['sun'] = array($domingo_tarde_de.'-'.$domingo_tarde_ate);
endif;
        //CONFIGURAÇÃO DE DOMINGO

$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :delivdata", "delivdata={$user_id}");
$exceptions = array();
if($lerbanco->getResult()):
  foreach($lerbanco->getResult() as $dadosC):
    extract($dadosC);
    $i = explode('/', $data);
    $i = array_reverse($i);
    $i = implode("-", $i);              

    if(isDateExpired($i, 1)):
      $exceptions["{$i}"] = array();              
    endif;
  endforeach;
endif;


          // Iniciando a classe
$store_hours = new StoreHours($hours, $exceptions);


           // Display open / closed menssagem
if($store_hours->is_open()) {
  echo "<span style='color:#86c953;'>ABERTO AGORA</span>";
} else {
  echo "<span class=\"opening\">FECHADO</span>";
}
?>   


<?=(!empty($minimo_delivery) && $minimo_delivery != '0.00' ? "- Valor mínimo Delivery: R$ ".Check::Real($minimo_delivery) : '');?>
</div>


<ul> 
  <?php if(!empty($confirm_delivery) && $confirm_delivery == "true"): ?>

    <li>Delivery<i class="icon_check_alt2 ok"></i></li>
    <?php else: ?>
      <li>Delivery<i class="icon_check_alt2 no"></i></li>
    <?php endif; ?>



    <?php if(!empty($confirm_balcao) && $confirm_balcao == "true"): ?>
      <li>Retirar no Balcão<i class="icon_check_alt2 ok"></i></li>
      <?php else: ?>
        <li>Retirar no Balcão<i class="icon_check_alt2 no"></i></li>
      <?php endif; ?>

    </ul>
  </div><!-- End desc-->
</a><!-- End strip_list-->


</div><!-- End col-md-6-->   
<?php
endforeach;
?>   
</div><!-- End row -->           
</div><!-- End container -->
</div><!-- End white_bg -->

<?php

endif;
?>








<!-- Content ================================================== -->
<div class="container">

 <div class="main_title">
  <br />
  <h2 class="nomargin_top" style="padding-top:0">Seu delivery Facil</h2>
  <p>
    Veja como e simples fazer seu pedido.
  </p>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="box_home" id="one">
      <span>1</span>
      <h3>Pesquisa por endereço</h3>
      <p>
        Encontre todos os restaurantes disponíveis em sua região.
      </p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box_home" id="two">
      <span>2</span>
      <h3>Escolha um restaurante</h3>
      <p>temos os melhores Parceiros disponíveis aqui.
      </p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box_home" id="three">
      <span>3</span>
      <h3>Forma de pagamento</h3>
      <p>
        escolha como vai pagar e faça seu Pedido!
      </p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box_home" id="four">
      <span>4</span>
      <h3>E por fim, Receba seu Pedido</h3>
      <p>
        Envie seu pedido para o restaurante via whatsapp.
      </p>
    </div>
  </div>
</div><!-- End row -->        
</div><!-- End container -->

<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 nopadding features-intro-img">
      <div class="features-bg img_2">
        <div class="features-img">
        </div>
      </div>
    </div>
    <div class="col-md-6 nopadding">
      <div class="features-content">
        <h3>A fome Bateu? Pará Delivery te Ajuda</h3>
        <ul class="list_ok">
          <li> Restaurantes</li>
          <li> Bares</li>
          <li> Pizzarias</li>
          <li> Lanchonetes</li>
          <li> Hamburguerias</li>
          <li> Sorveterias, etc.</li>
        </ul>
      </div>
    </div>
  </div>
</div><!-- End container-fluid  -->


<div class="high_light">
  <div class="container">
    <h3>Dono de <strong>restaurante</strong> ?</h3>
    <p>Crie agora seu cardápio online e comece a divulgar hoje mesmo.</p>
    <a href="<?=$site?>cadastro">Teste Gratis</a>
  </div><!-- End container -->
</div><!-- End hight_light -->





<!-- Footer ================================================== -->
<footer>
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div id="social_footer">
          <ul>
            <li><a target="_blank" href="<?=(!empty($texto['link_do_face']) ? $texto['link_do_face'] : "");?>"><i class="icon-facebook"></i></a></li>
            <!--<li><a href="#0"><i class="icon-twitter"></i></a></li>-->
            <!--<li><a href="#0"><i class="icon-google"></i></a></li>-->
            <li><a target="_blank" href="<?=(!empty($texto['link_do_insta']) ? $texto['link_do_insta'] : "");?>"><i class="icon-instagram"></i></a></li>
            <!--<li><a href="#0"><i class="icon-pinterest"></i></a></li>-->
            <!--<li><a href="#0"><i class="icon-vimeo"></i></a></li>-->
            <li><a target="_blank" href="<?=(!empty($texto['link_do_youtube']) ? $texto['link_do_youtube'] : "");?>"><i class="icon-youtube-play"></i></a></li>
          </ul>
          <p>© <?=$texto['nome_site_landing'];?></p>
        </div>
      </div>
    </div><!-- End row -->
  </div><!-- End container -->
</footer>
<!-- End Footer =============================================== -->

<div class="layer"></div><!-- Mobile menu overlay mask -->

<!-- Login modal -->   
<div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-popup">
      <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
      <form action="#" class="popup-form" id="myLogin">
        <div class="login_icon"><i class="icon_lock_alt"></i></div>
        <input type="text" class="form-control form-white" placeholder="Username">
        <input type="text" class="form-control form-white" placeholder="Password">
        <div class="text-left">
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-submit">Submit</button>
      </form>
    </div>
  </div>
</div><!-- End modal -->   

<!-- Register modal -->   
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myRegister" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-popup">
      <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
      <form action="#" class="popup-form" id="myRegister">
        <div class="login_icon"><i class="icon_lock_alt"></i></div>
        <input type="text" class="form-control form-white" placeholder="Name">
        <input type="text" class="form-control form-white" placeholder="Last Name">
        <input type="email" class="form-control form-white" placeholder="Email">
        <input type="text" class="form-control form-white" placeholder="Password"  id="password1">
        <input type="text" class="form-control form-white" placeholder="Confirm password"  id="password2">
        <div id="pass-info" class="clearfix"></div>
        <div class="checkbox-holder text-left">
          <div class="checkbox">
            <input type="checkbox" value="accept_2" id="check_2" name="check_2" />
            <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
          </div>
        </div>
        <button type="submit" class="btn btn-submit">Register</button>
      </form>
    </div>
  </div>
</div><!-- End Register modal -->

<!-- COMMON SCRIPTS -->
<script src="<?=$site;?>js/jquery-2.2.4.min.js"></script>
<script src="<?=$site;?>js/common_scripts_min.js"></script>
<script src="<?=$site;?>js/functions.js"></script>
<script src="<?=$site;?>assets/validate.js"></script>
<script src="<?=$site;?>js/jquery.mask.js"></script>
<script src="<?=$site;?>js/suportewats.js"></script>

<script>

  $('#dinheiro').mask('#.##0,00', {reverse: true});
  $('.telefone').mask('(00) 0 0000-0000');
  $('.estado').mask('AA');
  $('.cpf').mask('000-000.000-00');
  $('.cnpj').mask('00.000.000/0000-00');
  $('.rg').mask('00.000.000-0');
  //$('.cep').mask('00000-000');
  $('.dataNascimento').mask('00/00/0000');
  $('.placaCarro').mask('AAA-0000');
  $('.horasMinutos').mask('00:00');
  $('.cartaoCredito').mask('0000 0000 0000 0000');
  $('.numero').mask('#########0');
  $('.descontoporcentagem').mask('##0');
</script>


<!-- SPECIFIC SCRIPTS -->
<script  src="<?=$site;?>js/cat_nav_mobile.js"></script>
<script>$('#cat_nav').mobileMenu();</script>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="<?=$site;?>js/map.js"></script>
<script src="<?=$site;?>js/infobox.js"></script>
<script src="<?=$site;?>js/ion.rangeSlider.js"></script>
<script>
  $(function () {
   'use strict';
   $("#range").ionRangeSlider({
    hide_min_max: true,
    keyboard: true,
    min: 0,
    max: 15,
    from: 0,
    to:5,
    type: 'double',
    step: 1,
    prefix: "Km ",
    grid: true
  });
 });
</script>





<!-- SPECIFIC SCRIPTS -->
<script src="js/morphext.min.js"></script>
<script>
  $("#js-rotating").Morphext({
    animation: "fadeIn", // Overrides default "bounceIn"
    separator: ",", // Overrides default ","
    speed: 2300, // Overrides default 2000
    complete: function () {
        // Overrides default empty function
      }
    });
  </script>

  <script language="JavaScript">
    window.onload = function() {
      document.addEventListener("contextmenu", function(e){
        e.preventDefault();
      }, false);
      document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
                disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
                disabledEvent(e);
              }
            }, false);
      function disabledEvent(e){
        if (e.stopPropagation){
          e.stopPropagation();
        } else if (window.event){
          window.event.cancelBubble = true;
        }
        e.preventDefault();
        return false;
      }
    };
  </script>

  <div id='whatsapp-chat' class='hide'>
    <div class='header-chat'>
      <div class='head-home'>
        <h3 style="color: #ffffff;">    
          <?php
          $hr = date(" H ");
          if($hr >= 12 && $hr<18) {
            $resp = "Boa tarde!";}
            else if ($hr >= 0 && $hr <12 ){
              $resp = "Bom dia!";}
              else {
                $resp = "Boa noite!";}
                echo "$resp";
                ?>
              </h3>
              <p>Clique em um de nossos representantes abaixo para conversar no WhatsApp ou envie um email para <?=$texto['emailSuporteSite'];?></p></div>
              <div class='get-new hide'><div id='get-label'></div><div id='get-nama'></div></div></div>
              <div class='home-chat'>
                <!-- Info Contact Start -->
                <a class='informasi' href='javascript:void' title='Chat Whatsapp'>
                  <div class='info-avatar'><img src='<?=$site?>img/supportmale.png'/></div>
                  <div class='info-chat'>
                    <span class='chat-label'>Suporte Ao Cliente</span>
                    <span class='chat-nama'>Atendimento ao Cliente</span>
                  </div><span class='my-number'><?=$texto['telefoneAdministracaoTecnica'];?></span>
                </a>
                <!-- Info Contact End -->
                <!-- Info Contact Start -->
                <a class='informasi' href='javascript:void' title='Chat Whatsapp'>
                  <div class='info-avatar'><img src='<?=$site?>img/supportfemale.png'/></div>
                  <div class='info-chat'>
                    <span class='chat-label'>Suporte ao Lojista</span>
                    <span class='chat-nama'>Atendimento ao Lojista</span>
                  </div><span class='my-number'><?=$texto['telefoneAdministracaoVendas'];?></span>
                </a>
                <!-- Info Contact End -->
                <div class='blanter-msg'><b>HORÁRIOS: </b> de <i><?=$texto['horariosSuporteSite']?></i></div></div>
                <div class='start-chat hide'>
                  <div class='first-msg'><span>Olá, Como posso te ajudar?</span></div>
                  <div class='blanter-msg'>
                    <input type="text" id='chat-input2' maxlength='120' class="form-control" placeholder='Escreva uma pergunta...' />
                    <a href='javascript:void;' id='send-it'><i class="fa fa-paper-plane" aria-hidden="true"></i></a></div></div>
                    <div id='get-number'></div><a class='close-chat' href='javascript:void'>×</a>
                  </div>
                  <a class='blantershow-chat' href='javascript:void' title='Show Chat'><i class='fab fa-whatsapp'></i>Precisa de ajuda?</a>
                </body>
                </html>