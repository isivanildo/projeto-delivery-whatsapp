<div style="background-color:#ffffff;" class="container margin_60"> 

  <div class="indent_title_in">
    <i class="fa fa-qrcode" aria-hidden="true"></i>
    <h3>QR CODE E COMPARTILHAMENTO</h3>
    <p>Gere o seu QR Code do Cardápio Digital Agora</p>
  </div>

<!-- Tool -->





  <div class="container">
    <div class="card-body pd-40">
      <div class="row">
        <div class="col-md-3" ></a>
          <img src="<?=$site;?>img/wp.png" width="210" class="img-thumbnail"/>
        </div>
        <div class="col-md-9" align="justify">
          <br>
          <span style="font-size:18px"><i class="fa fa-external-link" aria-hidden="true"></i> ENVIAR LINK NO WHATSAPP</span><br><br>
          <form action="" method="post">
            <input type="hidden" id="mensagem" value="🙋‍♀️😍 *<?=(!empty($nome_empresa) ? $nome_empresa : 'Nome_do_seu_negócio');?>* 😱😎 %0A%0A Click no link abaixo 👇 para você acessar e fazer seu pedido com mais agilidade.%0A%0A🍱 <?=trim($site.$nome_empresa_link);?> %0A%0A Estamos aguardando o seu pedido.%0A%0A🍟 🍔 🍕 🥟 🍧 🍽
            ">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Número do Cliente</label>
                  <input type="text" class="form-control" id="celular" name="celular" maxlength="11" required>
                  <br />
                  <button type="submit" class="btn btn-success btn-block" onclick="enviarMensagem()">Enviar no WhatsApp <i class="fa fa-arrow-right"></i></button>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  <script type="text/javascript">
    function enviarMensagem(){
      var celular = document.querySelector("#celular").value;
      celular = celular.replace(/\D/g,'');
      if(celular.length < 13){
        celular = "55" + celular;
      }
      var texto = document.querySelector("#mensagem").value;
      window.open("https://api.whatsapp.com/send?phone=" + celular + "&text=" + texto, "_blank");
    }
  </script>
  <br />
  <br />
  <div class="container">
    <div class="card-body pd-40">
      <div class="row">
        <div class="col-md-3" ></a>
          <a href="https://api.qrserver.com/v1/create-qr-code/?data=<?=trim($site.$nome_empresa_link);?>/&amp;size=400x400" target="_blank"><img src="https://api.qrserver.com/v1/create-qr-code/?data=<?=trim($site.$nome_empresa_link);?>/&amp;size=200x200" alt="" title="" class="img-thumbnail"/></a>
        </div>
        <div class="col-md-9" align="justify">
          <br>
          <span style="font-size:18px"><i class="fa fa-qrcode" aria-hidden="true"></i> SEU QRCODE PARA DELIVERY E RETIRADA</span>
          <br><br>
          <span>Este é o QR code para seus clientes acessarem o cardápio de delivery e retirada.<br /> Utilize-o em materiais impressos ou onde você quiser!</span><br><br>
          <span><i class="fa fa-arrow-left" aria-hidden="true"></i> Clique na imagem para para baixar em maior resolução.</span><br>
        </div>
      </div>
    </div>
  </div>
  <br />
  <br />
  <div class="box_style_2" id="help">
    <h4>COMPARTILHE SEU LINK NAS REDES SOCIAIS</h4>
    <!-- AddToAny BEGIN -->
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?=$site.$nome_empresa_link;?>">        
      <a class="a2a_button_facebook"></a>
      <a class="a2a_button_facebook_messenger"></a>
      <a class="a2a_button_twitter"></a>
      <a class="a2a_button_google_plus"></a>
      <a class="a2a_button_whatsapp"></a>
      <a class="a2a_button_telegram"></a>
      <a class="a2a_button_link"></a> 
    </div>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <!-- AddToAny END -->
  </div>





  
</div>