let userMotoboy = new Motoboys();

$(document).ready(function(){
    //var idMotoboy;
    //Evento responsável por gravar e atualizar informações do motoboy
    $(".cad-motoboy").click(function(event) {
        //event.preventDefault();
        var dataMotoboy = userMotoboy.getValues();

        var nameMotoboy = dataMotoboy.motoboy_name;
        var phoneMotoboy = dataMotoboy.motoboy_phone_number;
        var registro = dataMotoboy.operacao;
        var idMotoboy = dataMotoboy.id;
        
        if (registro == "editar") {
           $("#id_registro").attr("value", "update") 
            registro = $("#id_registro").val();
            idMotoboy = $("#id_motoboy").val()
        }  
        
	    $.ajax({
			url: dataMotoboy.url_site + 'includes/processamotoboy.php',
			method: "post",	
            data: {"nameMotoboy" : nameMotoboy, "phoneMotoboy" : phoneMotoboy, 'idRegistro' : registro, 'idMotoboy': idMotoboy},
							
		    success: function(data) {
                var dados = $.parseJSON(data);

                if (dados.mensagem == "ok1") {
                   x0p("Sucesso!",
                    "Registro salvo com sucesso.",
                    "ok", false);
                }else if (dados.mensagem == "ok2") {
                    x0p("Sucesso!",
                    "Registro atualizado com sucesso.",
                    "ok", false);
                }else if (dados.mensagem == "erro1" || dados.mensagem == "erro2") {
                    x0p("Opss..",
                    "Erro ao salvar ou atualizar o registro.",
                    "error", false);
                }
                setTimeout(function(){
                    location = dados.urlCliente + "/" + 'add-motoboys'
                }, 1000)
		    }
		})

    });

    //Evento responsável por trazer o ID do motoboy da linha selecionada
    document.querySelectorAll(".edit-motoboy").forEach((event)=>{
        event.addEventListener('click', e=>{

            $("#id_registro").attr("value", "editar");
            var registro = $("#id_registro").val();
            userMotoboy.idMotoboy = event.id.replace("btnEditar_","");
            urlSite = $("#url_site").val();
            urlSite += 'includes/processamotoboy.php';

            $.ajax({
                url: urlSite,
                method: "post",	
                data: {'idMotoboy': userMotoboy.idMotoboy, 'idRegistro' : registro},
                                
                success: function(data) {   
                    var dados = $.parseJSON(data);
                    $("#id_motoboy").val(dados.id);
                    $("#motoboy_name").val(dados.nomeMotoboy);
                    $("#motoboy_phone_number").val(dados.telefone);
    
                    $("#id_cadastro").removeClass("cad-motoboy");
                    $("#id_cadastro").addClass("edit-motoboy");             
    
                }
            })
            $("#id_cadastro").html("Atualizar"); //Muda o título do botão de cadastrar para atualizar
        })
    })
    


    //Abre a tela de confrimação para exclusão do registro
    $(".delete-motoboy").click(function(event){
        event.preventDefault();

        $('#exampleModal').modal('show');
    })

    //Caso seja confirmado a exclusão esta ação do click será executada
    document.querySelectorAll(".delete-motoboy").forEach((event)=>{
        $("#confirmar").click(function(event){
            event.preventDefault();
            $('#exampleModal').modal('hide');
    
            $("#id_registro").attr("value", "delete");
            var registro = $("#id_registro").val();
            var urlSite = $("#url_site").val();
            urlSite += 'includes/processamotoboy.php';
    
            $.ajax({
                url: urlSite,
                method: "post",	
                data: {'idMotoboy': userMotoboy.idMotoboy, 'idRegistro' : registro},
                                
                success: function(data) {
                    var dados = $.parseJSON(data);
                    if (dados.mensagem == "true") {
                        x0p('Sucesso!', 
                        'Registro excluído com sucesso.!',
                        'ok', false);
                    }else if (dados.mensagem == "false") {
                        x0p('Opss!',
                        'Erro ao excluir o registro',
                        "error", false);
                    }
    
                    setTimeout(function() {
                        location = dados.urlCliente + "/" + 'add-motoboys';
                    },1000)
                }
            })
        })
    })
    
}) 