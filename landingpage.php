<?php
$login = new Login(3);
if($login->CheckLogin()):
  $idusuar = $_SESSION['userlogin']['user_id'];
  $lerbanco->ExeRead('ws_empresa', "WHERE user_id = :idcliente", "idcliente={$idusuar}");
  if (!$lerbanco->getResult()):       
  else:
    foreach ($lerbanco->getResult() as $i):
      extract($i);
    endforeach;
    header("Location: {$site}{$nome_empresa_link}/pedidos");
  endif;
else:
endif;
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="pt-BR">
<!--<![endif]-->

<head><meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title><?=$texto['titulo_site_landing'];?></title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="assets_land/images/favicon.png">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/bootstrap.css">
    <!--Order Object CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/ordenacao.css">
    <!--Owl Carousel CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/owl.carousel.min.css">
    <!--Magnific PopUp Stylesheet-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/magnific-popup.css">
    <!--Icofont CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/icofont.css">
    <!--Mailer CSS-->
    <link rel="stylesheet" type="text/css" href="mailer_land/mailer-style.css">
    <!--Animate CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/animate.css">
    <!--Bootsnav CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/bootsnav.css">
    <!--Main CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/style.css">
    <!--Responsive CSS-->
    <link rel="stylesheet" type="text/css" href="assets_land/css/responsive.css">

    
    <script src="https://kit.fontawesome.com/d0c2777bf0.js" crossorigin="anonymous"></script>


   
</head>

<body>
    <!--Start Preloader-->
    <div class="preloader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <!--End Preloader-->

    <!--Start Body Wrap-->
    <div id="body-wrap">
        <!--Start Header-->
        <header id="header">
            <nav class="navbar navbar-default bootsnav" data-spy="affix" data-offset-top="10">
                <div class="container">
                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li><a href="<?=$site?>Demo"><i class="icofont icofont-download-alt"></i>Demo</a></li>
                        </ul>
                    </div>
                    <!-- End Atribute Navigation -->

                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="icofont icofont-navigation-menu"></i>
                        </button>
                        <a class="navbar-brand" href="<?=$site;?>"><img src="assets_land/images/logo.png" class="logo" alt=""></a>
                    </div>
                    <!-- End Header Navigation -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
                            <li class="active"><a href="<?=$site;?>">Home</a></li>
                            <li><a href="#about">Sobre</a></li>
                            <li><a href="<?=$site?>lojas">Estabelecimentos</a></li>
                            <li><a href="#app-screenshot">Veja o Sistema</a></li>
                            <li><a href="#pricing">Planos</a></li>
                            <li><a href="#faq">D??vidas</a></li>
                            <li><a href="#contact">Contato</a></li>
                            <li><a href="<?=$site?>login">Login</a></li>
                            <li><a href="<?=$site?>cadastro">Cadastro</a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
            <div class="clearfix"></div>
        </header>
        <!--End Header-->

        <!--Start Banner Section-->
        <section id="banner" class="gradient-bg full-height">
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Banner Caption-->
                    <div class="col-sm-12 col-md-6 order-2 order-sm-1">
                        <div class="caption-content topo-small">
                            <h1 class="font-700 color-white text-uppercase wow fadeInUp" data-wow-delay="0.1s">Receba Pedidos pelo Whatsapp</h1>
                            <p class="color-white wow fadeInUp" data-wow-delay="0.2s">Conhe??a a nossa plataforma de Delivery, onde 100% do valor do pedido ?? do estabelecimento. Sem comiss??es abusivas, onde o pre??o dos seus produdos ?? igual para cliente no WebApp e no seu local fisico de atendimento.</p>
                            <div class="caption-btn wow fadeInUp" data-wow-delay="0.3s">
                                <a class="font-600" href="<?=$site?>Demo">Ver Demonstra????o</a><a class="font-600" href="<?=$site?>cadastro">Teste gr??tis</a>
                            </div>
                        </div>
                    </div>
                    <!--End Banner Caption-->

                    <!--Start Banner Image-->
                    <div class="col-sm-12 col-md-6 order-1 order-sm-1 topo-small">
                        <div class="banner-img wow fadeIn" data-wow-delay="0.4s">
                            <img src="assets_land/images/app1.png" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End Banner Image-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Banner Section-->

        <!--Start About Section-->
        <section id="about">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                     <!--propaganda-->
                    
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">PARCEIROS</h2>
                            <div class="why-choose-img wow fadeIn" data-wow-delay="0.2s">
                                <img src="assets_land/images/parceiro1.png" class="img-fluid" alt="Image">
                            </div>
                            
                            
                        </div>
                    </div>
                    <!--Start Heading content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s"> Plataforma Par?? Delivery</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Veja como funciona e como podemos ajudar sua Empresa!</p>
                        </div>
                    </div>
                    <!--End Heading content-->
                </div>
                <!--End Heading Row-->

                <!--Start About Row-->
                <div class="row">
                    <!--Start About Image-->
                    <div class="col">
                        <div class="about-img wow fadeIn" data-wow-delay="0.2s" style="display: block; margin-left: auto; margin-right: auto;">
                            <img src="assets_land/images/app2.png" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End About Image-->

                    <!--Start About Content-->
                    <div class="col">
                        <div class="about-content">
                            <h3 class="font-700 wow fadeInUp" data-wow-delay="0.1s">Revolucionamos a maneira de fazer pedidos.</h3>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">O Par?? Delivery chegou revolucionando a forma de realizar pedidos via whatsapp, uma plataforma leve, simples para o seu cliente e complexa para o seu estabelecimento. Seu estabelecimento pode receber pagamentos On-line ou na entrega!</p>
                            <p class="wow fadeInUp" data-wow-delay="0.3s">Diferente de outras plataformas conhecidas do mercado que que se tornam "s??cios" do seu neg??cio com mensalidade e comiss??es abusivas por pedidos realizados em suas plataformas. N??s queremos apenas te ajudar, n??o cobramos porcentagem sobre suas vendas, apenas um valor mensal fixo para a manuten????o do seu WebApp.</p>
                        </div>
                        <div class="about-btn btn-lg p-0 wow fadeInUp" data-wow-delay="0.3s">
                            <a class="gradient-bg-1" href="https://api.whatsapp.com/send?phone=5591991803701&text=Ol?? Gostaria de conhecer mais sobre o sistema." target="_blank"></i><span class="float-right text-center font-w-700">Quero Conhecer</a>
                        </div>
                    </div>
                    <!--End About Content-->
                </div>
                <!--End About Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End About Section-->

        <!--Start Features Section-->
        <section id="features" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Nossas Funcionalidades</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Aqui voc?? ver?? todos os recursos que a nossa plataforma te oferece.</p>
                        </div>
                    </div>
                    <!--End Heading content-->
                </div>
                <!--End Heading Row-->

                <!--Start Feature Items Row-->
                <div class="row">
                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.1s">
                            <i class="icofont icofont-edit gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Configure seu delivery</h5>
                            <p>Cadastre os dados do seu estabelecimento, como: Produtos, Adicionais (Pagos e Gratuitos), Endere??o, Banner Promocinal, Cupons de Descontos, Motoboys, Qr Code de Compartilhamento, Redes Sociais, Hor??rio de Atendimento, Pagamentos On-Line e seu n??mero de whatsapp e muitos mais.</p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.2s">
                            <i class="icofont icofont-touch gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Configure seus produtos</h5>
                            <p>Cadastro de Categorias e Produtos, Cadastro de Tamanhos e Tipos, Cadastro de Varia????es e Opcionais (incluindo ingredientes opcionais para aumentar seu ticket de venda), Cadastro de Bairros e Taxas de Delivery, Integra????es com Pagamentos On-line e muito mais...</p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.3s">
                            <i class="icofont icofont-motor-biker gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Configure sua entrega</h5>
                            <p>Configure os bairros ou faixas de CEP onde seu estabelecimento faz entregas e parametrize as formas de pagamento que voc?? aceita, como: PIX, Pagamanto na entrega (com op????o de troco), Pagamento na entrega com maquininha de cart??o e pagamentos on-line via API Mercado Pago e/ou PagSeguro.</p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.4s">
                            <i class="icofont icofont-food-cart gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Controle seus pedidos</h5>
                            <p>Fa??a o controle de seus pedidos atrav??s de uma tela ??nica, e tenha maior controle sobre todas as suas vendas. Uma copia de cada pedido chega no WhatsApp do seu estabelecimento, o mesmo possui um "ID" c??digo de pedido unico para controle no sistema administrativo do seu estabelecimento com relat??rios e estat??sticas das suas vendas. Voc?? acompanha a chegada de cada pedidos com aviso sonoro, e ent??o decide se aceita ou n??o o pedido, ap??s a decid??o poder?? imprimir cada pedido direto em impressoras n??o fiscais.</p>
                        </div>
                    </div>
                    <!--End Feature Item-->
                </div>
                <!--End Feature Items Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Features Section-->

        <!--Start Why Choose Section-->
        <section id="why-choose">
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Why Choose Content-->
                    <div class="col-md-6">
                        <div class="why-choose-content">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">O que Ofrecemos</h2>
                            <!--Start Why Choose Item-->
                            <div class="why-choose-single fix wow fadeInUp" data-wow-delay="0.1s">
                                <div class="why-chose-icon float-left">
                                    <i class="icofont icofont-restaurant-menu"></i>
                                </div>
                                <div class="why-choose-single-details float-right">
                                    <h5 class="font-600">Card??pio Simples</h5>
                                    <p>Tenha um card??pio simples e intuitivo. F??cil para seus clientes e pr??tico para voc??.</p>
                                </div>
                            </div>
                            <!--End Why Choose Item-->

                            <!--Start Why Choose Item-->
                            <div class="why-choose-single fix wow fadeInUp" data-wow-delay="0.1s">
                                <div class="why-chose-icon float-left">
                                    <i class="icofont icofont-money-bag"></i>
                                </div>
                                <div class="why-choose-single-details float-right">
                                    <h5 class="font-600">Aumente seu Faturamento</h5>
                                    <p>Com a Par?? Delivery voc?? consegue aumentar seu faturamento, otimizando tempo no recebimento do seu pedido.</p>
                                </div>
                            </div>
                            <!--End Why Choose Item-->

                            <!--Start Why Choose Item-->
                            <div class="why-choose-single fix wow fadeInUp" data-wow-delay="0.1s">
                                <div class="why-chose-icon float-left">
                                    <i class="icofont icofont-ruler-pencil"></i>
                                </div>
                                <div class="why-choose-single-details float-right">
                                    <h5 class="font-600">F??cil para Editar</h5>
                                    <p>Um sistema muito simples, aonde voc?? consegue configurar sua loja, seu card??pio, seus itens, cupons, Formas de Pagamento e etc.</p>
                                </div>
                            </div>
                            <!--End Why Choose Item-->

                            <!--Start Why Choose Item-->
                            <div class="why-choose-single fix wow fadeInUp" data-wow-delay="0.1s">
                                <div class="why-chose-icon float-left">
                                    <i class="icofont icofont-link"></i>
                                </div>
                                <div class="why-choose-single-details float-right">
                                    <h5 class="font-600">Link Amig??vel</h5>
                                    <p>Tenha um link simples e amig??vel sistema totalmente responsivo, passe a ter seu pr??prio aplicativo Exclusivo.</p>
                                </div>
                            </div>
                            <!--End Why Choose Item-->
                        </div>
                    </div>
                    <!--End Why Choose Content-->

                    <!--Start Why Choose Image-->
                    <div class="col-md-6">
                        <div class="why-choose-img wow fadeIn" data-wow-delay="0.2s">
                            <img src="assets_land/images/app3.png" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End Why Choose Image-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Why Choose Section-->

        <!--Start App Screenshots Section-->
        <section id="app-screenshot" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Nossa plataforma</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Confira abaixo algumas imagens da nossa plataforma.</p>
                        </div>
                    </div>
                    <!--End Heading Content-->
                </div>
                <!--End Heading Row-->

                <!--Start Screenshots Slider-->
                <div class="screenshots-slider owl-carousel wow fadeIn" data-wow-delay="0.1s">
                    <img src="assets_land/images/screenshot-1.jpg" class="img-responsive" alt="Image">
                    <img src="assets_land/images/screenshot-2.jpg" class="img-responsive" alt="Image">
                    <img src="assets_land/images/screenshot-3.jpg" class="img-responsive" alt="Image">
                    <img src="assets_land/images/screenshot-4.jpg" class="img-responsive" alt="Image">
                    <img src="assets_land/images/screenshot-5.jpg" class="img-responsive" alt="Image">
                </div>
                <!--End Screenshots Slider-->
            </div>
            <!--End Container-->
        </section>
        <!--End App Screenshots Section-->

        <!--Start Demo Video Section-->
        <section id="demo-video" class="bg-cover position-relative">
            <div class="overlay"></div>
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Video Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="video-content text-center">
                            <h2 class="font-700 text-uppercase color-white wow fadeInUp" data-wow-delay="0.1s">VEJA COMO FUNCIONA</h2>
                            <p class="color-white wow fadeInUp" data-wow-delay="0.2s">Assista ao v??deo e veja como ?? simples e f??cil deixar o Par?? Delivery te Ajudar em seu estabelecimento.</p>
                            <div class="video-popup-icon position-relative">
                                <div class="pulse1"></div>
                                <div class="pulse2"></div>
                                <a class="popup-video" href="https://www.youtube.com/"><i class="icofont icofont-play-alt-2"></i></a>
                            </div>

                        </div>
                    </div>
                    <!--End Video Content-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Demo Video Section-->

        <!--Start Pricing Section-->
        <section id="pricing">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                   
                    <!--Start Heading Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Nossos Planos</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Confira abaixo os valores de nossos planos, teste gr??tis por 7 dias.</p>
                        </div>
                    </div>
                    <!--End Heading Content-->
                </div>
                <!--End Heading Row-->

                <!--Start Pricing Row-->
                <div class="row">
                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.1s">
                            <div class="pricing-title">
                                <h3 class="font-700"><?=$texto['nomePlanoTeste']?></h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span><?=$texto['descricaoPlanoTeste']?></span></h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500 ">Clientes Ilimitados</li>
                                    <li class="font-500 ">Pedidos Ilimitados</li>
                                    <li class="font-500 ">Link Amig??vel</li>
                                    <li class="font-500 no">Suporte para Instala????o</li>
                                    <li class="font-500 no">Configura????o e Cadastro dos <br>Produtos</li>
                                    <li class="font-500">Gr??tis 7 Dias</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" href="<?=$site?>/cadastro">Assinar</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->

                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.2s">
                            <div class="pricing-title">
                                <h3 class="font-700"><?=$texto['nomePlanoUm']?></h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span>R$</span><?=substr($texto['valorPlanoUm'], 0, -3)?><sup class="font-800"><?=substr($texto['valorPlanoUm'], -3)?></sup> <sub class="font-600"></sub></h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500 ">Clientes Ilimitados</li>
                                    <li class="font-500 ">Pedidos Ilimitados</li>
                                    <li class="font-500 ">Link Amig??vel</li>
                                    <li class="font-500 ">Suporte para Instala????o</li>
                                    <li class="font-500 ">Configura????o e Cadastro dos <br>Produtos</li>
                                    <li class="font-500">Menos de <b>R$ <?=Check::Real($texto['valorPlanoUm']/$texto['DiasPlanoUm'])?></b> por dia</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" href="<?=$site?>/cadastro">Assinar</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->

                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.3s">
                            <div class="pricing-title">
                                <h3 class="font-700"><?=$texto['nomePlanoDois']?></h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span>R$</span><?=substr($texto['valorPlanoDois'], 0, -3)?><sup><?=substr($texto['valorPlanoDois'], -3)?></sup> <sub></sub></h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500 ">Clientes Ilimitados</li>
                                    <li class="font-500 ">Pedidos Ilimitados</li>
                                    <li class="font-500 ">Link Amig??vel</li>
                                    <li class="font-500 ">Suporte para Instala????o</li>
                                    <li class="font-500 ">Configura????o e Cadastro dos <br>Produtos</li>
                                    <li class="font-500">Apenas <b>R$ <?=Check::Real($texto['valorPlanoDois']/$texto['DiasPlanoDois'])?></b> por dia</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" href="<?=$site?>/cadastro">Assinar</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->

                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.4s">
                            <div class="pricing-title">
                                <h3 class="font-700 "><?=$texto['nomePlanoTres']?></h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span>R$</span><?=substr($texto['valorPlanoTres'], 0, -3)?><sup><?=substr($texto['valorPlanoTres'], -3)?></sup> <sub></sub></h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500 ">Clientes Ilimitados</li>
                                    <li class="font-500 ">Pedidos Ilimitados</li>
                                    <li class="font-500 ">Link Amig??vel</li>
                                    <li class="font-500 ">Suporte para Instala????o</li>
                                    <li class="font-500 ">Configura????o e Cadastro dos <br>Produtos</li>
                                    <li class="font-500">Menos de <b>R$ <?=Check::Real($texto['valorPlanoTres']/$texto['DiasPlanoTres'])?></b> por dia</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" href="<?=$site?>/cadastro">Assinar</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->
                </div>
                <!--End Pricing Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Pricing Section-->

        <!--Start Faq Section-->
        <section id="faq" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Perguntas Frequentes</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Confira abaixo algumas d??vidas frequentes relacionadas a nossa plataforma.</p>
                        </div>
                    </div>
                    <!--End Heading Content-->
                </div>
                <!--End Heading Row-->

                <!--Start Faq Row-->
                <div class="row">
                    <!--Start Faq Accordian-->
                    <div class="col-md-6">
                        <div class="panel-group" id="accordion">
                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.1s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1">A Plataforma ?? responsiva? funciona bem no celular? ? </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="font-500 panel-body">Sim, Funciona Perfeitamente no Celular, Tablet, Computador, nosso WebApp roda sem bugs em navegadores Safari para IOS.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.2s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Meu cliente precisa baixar algum aplicativo ? </a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">N??o, apenas com o link do seu card??pio o cliente pode realizar os pedidos, atrav??s do WebApp respons??vel.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.3s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3">O cliente realiza o pagamento pela plataforma ?</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">Sim, Voc?? pode definir Pagamento On-Line pela Plataforma (PAGSEGURO ou MERCADO PAGO) e tamb??m via Balc??o ou na Entrega, voc?? quem decide as formas de pagamento que ir?? utilizar em seu estabelecimento. Colocamos todas a sua disposi????o.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.4s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse4">Funciona no meu celular?</a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">Sim, nossa plataforma foi desenvolvida para atender a necessidade de todos, voc?? consegue acessar apenas com um smartphone ou computador conectado a internet. Nossa plataforma ?? totalmente responsiva.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.5s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse5">O Par?? Delivery tem fidelidade ?</a>
                                    </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">N??o, voc?? pode cancelar a sua assinatura assim que desejar sem custo algum.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.5s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse6">Posso usar minha impressora t??rmica ?</a>
                                    </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">SIM! Somos compat??veis com todos os principais modelos do mercado. Consultar modelos de impressoras com nosso suporte via e-mail ou whatsapp.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.5s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse7">Voc??s realizam a entrega dos produtos ?</a>
                                    </h4>
                                </div>
                                <div id="collapse7" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">N??o! Nesse momento a ferramenta apoia somente no recebimento dos pedidos, tornando o processo de produ????o mais pr??tico e organizado.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->

                            <!--Start Accordian Single-->
                            <div class="panel panel-default wow fadeInUp" data-wow-delay="0.5s">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="font-600 accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse8">Quem fica respons??vel pela divulga????o ?</a>
                                    </h4>
                                </div>
                                <div id="collapse8" class="panel-collapse collapse">
                                    <div class="font-500 panel-body">O pr??prio estabelecimento ?? respons??vel pela divulga????o do seu card??pio on-line atrav??s do link, afinal, ningu??m melhor que voc?? para saber onde est??o seus cliente. Mas, voc?? pode por exemplo, enviar o seu link p??blico do Par?? Delivery por e-mail, Whatsapp e disponibilizar nas redes sociais. Al??m disso, criar uma lista de transmiss??o no Whatsapp e divulgar aos seus contatos pode ser uma ??tima ideia! Estamos tamb??m preparando um blog para ajudar com dicas para seu neg??cio evoluir cada vez mais.</div>
                                </div>
                            </div>
                            <!--End Accordian Single-->      
                                                        
                        </div>
                    </div>
                    <!--End Faq Accordian-->

                    <!--Start Faq Image-->
                    <div class="col-md-6">
                        <div class="faq-img float-right wow fadeIn" data-wow-delay="0.2s">
                            <img src="assets_land/images/app8.png" class="img-responsive" alt="Image">
                        </div>
                    </div>
                    <!--End Faq Image-->
                </div>
                <!--Start Faq Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Faq Section-->

        <!--Start Testimonial Section-->
        <section id="testimonial" class="gradient-bg">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-white text-uppercase wow fadeInUp" data-wow-delay="0.1s">O QUE ANDAM FALANDO DE N??S</h2>
                            <p class="color-white wow fadeInUp" data-wow-delay="0.2s">Confira abaixo alguns clientes ap??s conhecerem e usarem o Par?? Delivery em seu estabelecimento.</p>
                        </div>
                    </div>
                    <!--End Heading Content-->
                </div>
                <!--End Heading Row-->

                <!--Start Testimonial Row-->
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <!--Start Testimonial Carousel-->
                        <div class="testimonial-carousel owl-carousel">
                            <!--Start Testimonial Single-->
                            <div class="testimonial-single row">
                                <div class="col-sm-3">
                                    <div class="client-info text-center wow fadeInUp" data-wow-delay="0.1s">
                                        <img src="assets_land/images/client-2.jpg" alt="">
                                        <h4 class="font-600">Andrezza</h4>
                                        <p>Magic Burger</p>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="testimonial-border"></div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="client-comment">
                                        <p class="wow fadeInUp" data-wow-delay="0.1s">O Par?? Delivery nos ajudou bastante, nossos clientes agora n??o precisam ficar pedindo card??pio, escolhendo ou perguntando. Muito pr??tico, ??gil e f??cil de utilizar, recomendo a todos.</p>
                                        <span class="wow fadeInUp" data-wow-delay="0.2s"><i class="icofont icofont-star"></i><i class="icofont icofont-star"></i><i class="icofont icofont-star"></i><i class="icofont icofont-star"></i><i class="icofont icofont-star"></i></span><span class="float-right"><i class="icofont icofont-quote-right"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--End Testimonial Single-->

                        </div>
                        <!--End Testimonial Carousel-->
                    </div>
                </div>
                <!--End Testimonial Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Testimonial Section-->
	
        <!--Start Contact Section-->
        <section id="contact" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Col-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <!--Start Heading-->
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Entre em contato conosco</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Estamos esperando o seu contato, escolha um de nossos canais de atendimento.</p>
                        </div>
                        <!--End Heading-->
                    </div>
                    <!--End Heading Col-->
                </div>
                <!--End Heading Row-->

                <!--Start Contact Info-->
              <div class="contact-info">
                    <!--Start Row-->
                    <div class="row">
                        <!--Start Contact Info Single-->
                        <div class="col-sm-3">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.1s">
                                <i class="icofont icofont-email gradient-bg-1 color-white"></i>
                                <p></p><a href="" title="Email" target="new">contato@paradelivery.com.br</a></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-3">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.2s">
                                <i class="icofont icofont-phone gradient-bg-1 color-white"></i>
                                <p><a href="https://api.whatsapp.com/send?phone=5591991803701&text=Ol??! Gostaria de conhecer mais sobre o sistema." target="new">91 99180-3701</a></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-3">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.3s">
                                <i class="icofont icofont-social-google-map gradient-bg-1 color-white"></i>
                                <p><a href="https://www.google.com/maps/place/MR+Inform%C3%A1tica/@-1.4228396,-48.47908,17z/data=!3m1!4b1!4m5!3m4!1s0x92a48be2cd4d8721:0x67332170dae80e84!8m2!3d-1.4228588!4d-48.4769004" target="new">Bel??m-PA</a></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-3">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.4s">
                                <i class="icofont icofont-social-instagram gradient-bg-1 color-white" href="https://www.instagram.com"></i>
                                <p><a href="https://www.instagram.com" target="new">@BelemTech</a></p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->
                    </div>
                    <!--End Row-->
                </div>
                <!--End Contact Info-->               
            </div>
            <!--End Container-->
        </section>
        <!--End Contact Section-->

        <!--Start Footer-->
        <footer id="footer">
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Footer Social-->
                    <div class="col-sm-4">
                        <div class="footer-social text-left wow fadeIn" data-wow-delay="0.1s">
                            <ul>
                                <li><a href="https://www.facebook.com/"><i class="icofont icofont-social-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/"><i class="icofont icofont-social-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!--End Footer Social-->

                    <!--Start Copyright Text-->
                    <div class="col-sm-8">
                        <div class="copyright-text text-right wow fadeIn" data-wow-delay="0.2s">
                            <p class="color-white">&copy; 2021 Todos os direitos reservados <a class="color-direito-footer" href="#">Par?? Delivery</a></p>
                        </div>
                    </div>
                    <!--End Copyright Text-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->

            <!--Start ClickToTop-->
            <div class="click-to-top">
                <a class="gradient-bg" href="#header"><i class="icofont icofont-simple-up"></i></a>                
            </div>

            <div class="whatsappvisible">               
                <a class="whatsapp-link" href="https://wa.me/5591991803701" target="_blank"><i class="fab fa-whatsapp"></i></a>              
            </div>
            
            <!--End ClickToTop-->
        </footer>
        <!--End Footer-->
    </div>
    <!--End Body Wrap-->

    <script src="lojas/js/scriptkey.js"></script>

    <!--jQuery JS-->
    <script src="assets_land/js/jquery.min.js"></script>
    <!--Counter JS-->
    <script src="assets_land/js/waypoints.js"></script>
    <script src="assets_land/js/jquery.counterup.min.js"></script>
    <!--Bootstrap JS-->
    <script src="assets_land/js/bootstrap.min.js"></script>
    <!--Magnic PopUp JS-->
    <script src="assets_land/js/magnific-popup.min.js"></script>
    <!--Owl Carousel JS-->
    <script src="assets_land/js/owl.carousel.min.js"></script>
    <!--Wow JS-->
    <script src="assets_land/js/wow.min.js"></script>
    <!--Bootsnavs JS-->
    <script src="assets_land/js/bootsnav.js"></script>
    <!--Contact Form JS-->
    <script src="mailer_land/ajax-contact-form.js"></script>
    <!--Main-->
    <script src="assets_land/js/custom.js"></script>

</body>

</html>