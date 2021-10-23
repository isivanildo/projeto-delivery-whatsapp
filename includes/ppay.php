<?

function mpay($user,$taxa_v,$sub_total) {
    require "../_app/Config.inc.php";
    $con = mysqli_connect(HOST,USER,PASS,DBSA);
    mysqli_set_charset($con,"utf8");
    if ($con) {
        $query = mysqli_query($con,"SELECT * FROM ws_empresa WHERE user_id=$user");
        if ($query and mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            extract($_POST);
            
            if ($opcao_delivery == "true") {
                if (empty($telefone) or empty($nome) or empty($bairro) or empty($cidade) or empty($uf) or empty($rua) or empty($unidade)) {
                    return print_r(json_encode("fields"));
                }
                else if (!empty($bairro) and ($bairro == "Selecione o seu bairro..." or strpos($bairro,"Selecione") !== false)) {
                    return print_r(json_encode("fields"));
                }
            }
            else if ($opcao_delivery == "false") {
                if (empty($telefone) or empty($nome)) {
                    return print_r(json_encode("fields"));
                }
            }
            else if ($opcao_delivery == "false2") {
                
            }
            
            $phone = str_replace("(","",$telefone);
            $phone = str_replace(")","",$phone);
            $phone = str_replace("-","",$phone);
            $phone = str_replace(" ","",$phone);
            $ddd = substr($phone,0,2);
            $phone = substr($phone,2);
            
            if ($opcao_delivery == "true") {
                $bairro = substr($bairro,0,strpos($bairro,"(")-1);
            }
            
            if ($taxa_v + $sub_total < $data['minimo_delivery']) {
                return print_r("min_delivery");
            }

            setlocale(LC_CTYPE, 'pt_BR'); // Defines para pt-br
            
            $itemDesc = 'Pedido em '.(!empty($data['nome_empresa']) ? $data['nome_empresa'] : 'Nome_do_seu_negocio');
            $itemDesc = strtoupper($itemDesc);
            $itemDesc = str_replace(" ","%20",$itemDesc);
            $itemDesc = str_replace("Ç","C",$itemDesc);
            $itemDesc = str_replace("ç","c",$itemDesc);
            $itemDesc = iconv('UTF-8', 'ASCII//TRANSLIT', $itemDesc);
            
            $itemAmount = ($taxa_v + $sub_total);
            $itemAmount = number_format($itemAmount, 2, '.', '');
            
            $ref = $opcao_delivery == "true" ? "$taxa_v--$sub_total--$cidade--$uf--$bairro--$rua--$unidade--$ddd--$phone--$nome--$confirm_whatsapp--$opcao_delivery" : ($opcao_delivery == "false" ? "$taxa_v--$sub_total--$ddd--$phone--$nome--$confirm_whatsapp--$opcao_delivery" : "$taxa_v--$sub_total--$ddd--$phone--$nome--$mesa--$pessoas--$name_observacao_mesa--$confirm_whatsapp--$opcao_delivery");
            $ref = strtoupper($ref);
            $ref = str_replace(" ","%20",$ref);
            $ref = str_replace("Ç","C",$ref);
            $ref = str_replace("ç","c",$ref);
            $ref = iconv('UTF-8', 'ASCII//TRANSLIT', $ref);
            
            $curl = curl_init("https://ws.pagseguro.uol.com.br/v2/checkout/?email=".$data['email_pagseguro']."&token=".$data['token_pagseguro']."&currency=BRL&itemId1=001&itemDescription1=$itemDesc&itemAmount1=$itemAmount&itemQuantity1=1&itemWeight1=50&shippingAddressRequired=false&notificationURL=".HOME."includes/pnotify.php?user=$user&reference=$ref");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $retorno = curl_exec($curl);
            curl_close($curl);
            
            $xml = simplexml_load_string($retorno);
            
            if (isset($xml->code)) {
                return print("https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$xml->code);
            }
            else {
                return print("undefined");
            }
            
            return print($xml->code);
        }
    }
    mysqli_close($con);
}

if (isset($_POST)) {
    if (isset($_POST['action']) and $_POST['action'] == "add") {
        if (!empty($_POST['user']) and !empty($_POST['taxa_v']) and !empty($_POST['sub_total'])) {
            mpay($_POST['user'],$_POST['taxa_v'],$_POST['sub_total']);
        }
    }
}

?>