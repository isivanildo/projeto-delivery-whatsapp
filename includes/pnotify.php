<?

require "../_app/Config.inc.php";

$con = mysqli_connect(HOST,USER,PASS,DBSA);
if ($con) {
    if (isset($_GET) && isset($_GET['user']) && $_GET['user'] != '') {
        $query = mysqli_query($con,"SELECT * FROM ws_empresa WHERE user_id=".$_GET['user']);
        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if (isset($_POST) && isset($_POST['notificationType']) && $_POST['notificationType'] == "transaction") {
                $curl = curl_init("https://ws.pagseguro.uol.com.br/v3/transactions/notifications/".$_POST['notificationCode']."?email=".$data['email_pagseguro']."&token=".$data['token_pagseguro']);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $transaction = curl_exec($curl);
                curl_close($curl);
                
                $transaction = simplexml_load_string($transaction);
                
                if ($transaction->status == '3') {
                    $addt_info = $transaction->reference;
            	    $addt_info = explode("--",$addt_info);
            	    
            	    $phone = $addt_info[8];//$payment->payer->phone->number;
            	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
            	    
            	    if ($addt_info[count($addt_info)-1] === "TRUE") {
            	        $phone = $addt_info[8];//$payment->payer->phone->number;
                	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
                	    
                	    $fields = array (
                	        "telefone" => "(".$addt_info[7].") ".$phone,
                	        "nome" => $addt_info[9],
                	        "bairro2" => $addt_info[4],
                	        "bairro" => $addt_info[4],
                	        "cidade" => $addt_info[2],
                	        "uf" => $addt_info[3],
                	        "rua" => $addt_info[5],
                	        "unidade" => $addt_info[6],
                	        "complemento" => "Vazio",
                	        "observacao" => "Vazio",
                	        "forma_pagamento" => "Cartão",
                	        "valor_troco" => "0,00",
                	        "confirm_whatsapp" => "false",
                	        "valor_taxa" => $addt_info[0],
                	        "sub_total" => $addt_info[1],
                	        "enviar_pedido" => "enviar_agora",
                	        "user_id" => $_GET['user'],
                	        "confirm_whatsapp" => $addt_info[10],
                	        "opcao_delivery" => $addt_info[11]
                	        
                	    );
            	    }
            	    else if ($addt_info[count($addt_info)-1] === "FALSE") {
            	        $phone = $addt_info[3];//$payment->payer->phone->number;
                	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
                	    
                	    $fields = array (
                	        "telefone" => "(".$addt_info[2].") ".$phone,
                	        "nome" => $addt_info[4],
                	        /*"bairro2" => $addt_info[4],
                	        "bairro" => $addt_info[4],
                	        "cidade" => $addt_info[2],
                	        "uf" => $addt_info[3],
                	        "rua" => $addt_info[5],
                	        "unidade" => $addt_info[6],*/
                	        "complemento" => "Vazio",
                	        "observacao" => "Vazio",
                	        "forma_pagamento" => "Cartão",
                	        "valor_troco" => "0,00",
                	        "confirm_whatsapp" => "false",
                	        "valor_taxa" => $addt_info[0],
                	        "sub_total" => $addt_info[1],
                	        "enviar_pedido" => "enviar_agora",
                	        "user_id" => $_GET['user_id'],
                	        "confirm_whatsapp" => $addt_info[5],
                	        "opcao_delivery" => $addt_info[6]
                	        
                	    );
            	    }
            	    else if ($addt_info[count($addt_info)-1] === "FALSE2") {
            	        $phone = $addt_info[3];//$payment->payer->phone->number;
                	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
                	    
                	    $fields = array (
                	        "telefone" => "(".$addt_info[2].") ".$phone,
                	        "nome" => $addt_info[4],
                	        "mesa" => $addt_info[5],
                	        "pessoas" => $addt_info[6],
                	        "name_observacao_mesa" => $addt_info[7],
                	        /*"bairro2" => $addt_info[4],
                	        "bairro" => $addt_info[4],
                	        "cidade" => $addt_info[2],
                	        "uf" => $addt_info[3],
                	        "rua" => $addt_info[5],
                	        "unidade" => $addt_info[6],*/
                	        "complemento" => "Vazio",
                	        "observacao" => "Vazio",
                	        "forma_pagamento" => "Cartão",
                	        "valor_troco" => "0,00",
                	        "confirm_whatsapp" => "false",
                	        "valor_taxa" => $addt_info[0],
                	        "sub_total" => $addt_info[1],
                	        "enviar_pedido" => "enviar_agora",
                	        "user_id" => $_GET['user_id'],
                	        "confirm_whatsapp" => $addt_info[8],
                	        "opcao_delivery" => $addt_info[9]
                	        
                	    );
            	    }
            	    
                    $ch = curl_init();
                    
                    curl_setopt($ch, CURLOPT_URL, HOME."includes/processaenviarpedido.php");
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    
                    $result = curl_exec($ch);
                    
                    curl_close($ch);
                }
            }
        }
    }
}
mysqli_close($con);

?>