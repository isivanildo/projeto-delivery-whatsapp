<?

function exeNotify() {
    require "../_app/Config.inc.php";
    require '../mercadopago/vendor/autoload.php';
    
    $con = mysqli_connect(HOST,USER,PASS,DBSA);
    if ($con) {
        $query = mysqli_query($con,"SELECT * FROM ws_empresa WHERE user_id=".$_GET['user_id']);
        if ($query) {
            $data = mysqli_fetch_assoc($query);
            MercadoPago\SDK::setAccessToken($data['access_token_mp']); //ENV_ACCESS_TOKEN
        }
    }

	$merchant_order = null;

	switch($_GET["topic"]) {
		case "payment":
			$payment = MercadoPago\Payment::find_by_id($_GET["id"]);
			// Get the payment and the corresponding merchant_order reported by the IPN.
			$merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
			break;
		case "merchant_order":
			$merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
			break;
	}
	
	if ($payment->status == "approved") {
	    $addt_info = $payment->additional_info->payer->address->street_name;
	    $addt_info = explode("&",$addt_info);
	    
	    $phone = $addt_info[8];//$payment->payer->phone->number;
	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
	    
	    if ($addt_info[count($addt_info)-1] === "true") {
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
    	        "valor_taxa" => $addt_info[0],
    	        "sub_total" => number_format($addt_info[1], 2, '.', ' '),
    	        "enviar_pedido" => "enviar_agora",
    	        "user_id" => $_GET['user_id'],
    	        "confirm_whatsapp" => $addt_info[10],
    	        "opcao_delivery" => $addt_info[11],
    	        "add_class" => 1
    	    );
	    }
	    else if ($addt_info[count($addt_info)-1] === "false") {
	        $phone = $addt_info[3];//$payment->payer->phone->number;
    	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
    	    
    	    $fields = array (
    	        "telefone" => "(".$addt_info[2].") ".$phone,
    	        "nome" => $addt_info[4],
    	        "complemento" => "Vazio",
    	        "observacao" => "Vazio",
    	        "forma_pagamento" => "Cartão",
    	        "valor_troco" => "0,00",
    	        "valor_taxa" => $addt_info[0],
    	        "sub_total" => $addt_info[1],
    	        "enviar_pedido" => "enviar_agora",
    	        "user_id" => $_GET['user_id'],
    	        "confirm_whatsapp" => $addt_info[5],
    	        "opcao_delivery" => $addt_info[6],
    	        "add_class" => 1
    	    );
	    }
	    else if ($addt_info[count($addt_info)-1] === "false2") {
	        $phone = $addt_info[3];//$payment->payer->phone->number;
    	    $phone = strlen($phone) == 9 ? substr($phone,0,5)."-".substr($phone,5) : "9".substr($phone,0,4)."-".substr($phone,4);
    	    
    	    $fields = array (
    	        "telefone" => "(".$addt_info[2].") ".$phone,
    	        "nome" => $addt_info[4],
    	        "mesa" => $addt_info[5],
    	        "pessoas" => $addt_info[6],
    	        "name_observacao_mesa" => $addt_info[7],
    	        "complemento" => "Vazio",
    	        "observacao" => "Vazio",
    	        "forma_pagamento" => "Cartão",
    	        "valor_troco" => "0,00",
    	        "valor_taxa" => $addt_info[0],
    	        "sub_total" => $addt_info[1],
    	        "enviar_pedido" => "enviar_agora",
    	        "user_id" => $_GET['user_id'],
    	        "confirm_whatsapp" => $addt_info[8],
    	        "opcao_delivery" => $addt_info[9],
    	        "add_class" => 1
    	    );
	    }
	    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, HOME."includes/processaenviarpedido.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        
	}
	
	

	/*$paid_amount = 0;
	foreach ($merchant_order->payments as $payment) {	
		if ($payment['status'] == 'approved'){
			$paid_amount += $payment['transaction_amount'];
		}
	}
	
	// If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
	if($paid_amount >= $merchant_order->total_amount){
		if (count($merchant_order->shipments)>0) { // The merchant_order has shipments
			if($merchant_order->shipments[0]->status == "ready_to_ship") {
				print_r("Totally paid. Print the label and release your item.");
			}
		} else { // The merchant_order don't has any shipments
			print_r("Totally paid. Release your item.");
		}
	} else {
		print_r("Not paid yet. Do not release your item.");
	}*/
    
    
    
    
    
    /*$con = mysqli_connect(HOST,USER,PASS,DBSA);
    if ($con) {
        //$query = mysqli_query($con,"UPDATE ateste SET topic='$topic' AND id='$id'");
        $query = mysqli_query($con,"INSERT INTO ateste (topic,id) VALUES ('is topic','$atrrrr')");
    }
    mysqli_close($con);*/
}

if (isset($_POST)) {
    header("HTTP/1.1 200 OK");
    //return exeNotify();
    exeNotify();
    /*if (isset($_POST['topic']) and !empty($_POST['topic']) and isset($_POST['id']) and !empty($_POST['id'])) {
        exeNotify($_POST['topic'],$_POST['id']);
    }*/
}

?>