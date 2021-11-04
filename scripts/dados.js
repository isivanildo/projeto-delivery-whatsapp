$(document).ready(function(){
    var idMotoboy; //variável que orá guardar o codigo do motoboy

    //Evento responsável por gravar e atualizar informações do motoboy
    $(".cad-motoboy").click(function(event) {
        event.preventDefault();

        var nameMotoboy = $("#motoboy_name").val();
        var phoneMotoboy = $("#motoboy_phone_number").val();
        var registro = $("#id_registro").val();
        
        if (registro == "editar") {
            $("#id_registro").attr("value", "update") 
            registro = $("#id_registro").val();
            idMotoboy = $("#id_motoboy").val()
        }

        var urlSite = $("#url_site").val();
        urlSite += 'includes/processamotoboy.php';

	    $.ajax({
			url: urlSite,
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
    $(".edit-motoboy").click(function(event){
        event.preventDefault();
        var $row = $(this).closest("tr"),
        $tds = $row.find("td:nth-child(2)");
        $.each($tds, function() {
            idMotoboy = $(this).text();
        });  

        $("#id_registro").attr("value", "editar");
        var registro = $("#id_registro").val();
        var urlSite = $("#url_site").val();
        urlSite += 'includes/processamotoboy.php';
	    $.ajax({
			url: urlSite,
			method: "post",	
			data: {'idMotoboy': idMotoboy, 'idRegistro' : registro},
							
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

    //Abre a tela de confrimação para exclusão do registro
    $(".delete-motoboy").click(function(event){
        event.preventDefault();
        event.preventDefault();
        var $row = $(this).closest("tr"),
        $tds = $row.find("td:nth-child(2)");
        $.each($tds, function() {
            idMotoboy = $(this).text();
        });  

        $('#exampleModal').modal(show);
    })

    //Caso seja confirmado a exclusão esta ação do click será executada
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
			data: {'idMotoboy': idMotoboy, 'idRegistro' : registro},
							
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