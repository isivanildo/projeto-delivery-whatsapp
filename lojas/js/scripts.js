let address = new Address();

$(document).ready(function(){
    $('#pesquisar').click(function(){
      var pesquisa = $('#valor_cep').val();
      pesquisa = pesquisa.replace("-", "").replace(".", "");

      address.endereco = $("#name_site").text();

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
          url: address.endereco + 'controlers/processabuscacliente.php',
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

    $(this).keyup(e=>{

      if (e.key == 'Enter'){
        $('#pesquisar').click();
    }
    })
    
  });