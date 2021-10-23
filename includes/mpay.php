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
            
            // SDK de Mercado Pago
            require '../mercadopago/vendor/autoload.php';
            
            // Configura credenciais
            MercadoPago\SDK::setAccessToken($data['access_token_mp']);
            
            //MercadoPago\SDK::setAccessToken("APP-dsadsadsa");
            
            // Cria um objeto de preferência
            $preference = new MercadoPago\Preference();
            
            // Cria um item na preferência
            $item = new MercadoPago\Item();
            $item->title = 'Pedido em '.(!empty($data['nome_empresa']) ? $data['nome_empresa'] : 'Nome_do_seu_negócio');
            $item->quantity = 1;
            $item->unit_price = ($taxa_v + $sub_total);
            
            if ($taxa_v + $sub_total < $data['minimo_delivery']) {
                return print_r("min_delivery");
            }
            
            $payer = new MercadoPago\Payer();
            $payer->name = $nome;
            $payer->phone = array (
                "area_code" => $ddd,
                "number" => $phone
            );
            $payer->address = array (
                //"street_name" => "$taxa_v&$sub_total&$cidade&$uf&$bairro&$rua&$unidade&$ddd&$phone&$nome&$confirm_whatsapp&$opcao_delivery",
                "street_name" => ($opcao_delivery == "true" ? "$taxa_v&$sub_total&$cidade&$uf&$bairro&$rua&$unidade&$ddd&$phone&$nome&$confirm_whatsapp&$opcao_delivery" : ($opcao_delivery == "false" ? "$taxa_v&$sub_total&$ddd&$phone&$nome&$confirm_whatsapp&$opcao_delivery" : "$taxa_v&$sub_total&$ddd&$phone&$nome&$mesa&$pessoas&$name_observacao_mesa&$confirm_whatsapp&$opcao_delivery")),
                //"street_number" => $unidade
                "street_number" => ($opcao_delivery == "true" ? $unidade : "")
            );
            
            $preference->notification_url = HOME."includes/mnotify.php?user_id=$user";
            if ($confirm_whatsapp) {
                $preference->back_urls = array (
                    "success" => "https://api.whatsapp.com/send?phone=55$ddd$phone&text=🔔%20Olá!%A0Acabei de realizar meu pedido.%A0Nome: $nome%A0Telefone: ($ddd) $phone%A0"
                );
            }
            else {
                $preference->back_urls = array (
                    "success" => HOME.$nome_empresa_link
                );
            }
            //$preference->additional_info = "$taxa_v&$sub_total&$cidade&$uf&$bairro&$rua&$unidade&$ddd&$phone&$nome";
            
            $preference->items = array($item);
            $preference->payer = $payer;
            $preference->save();
            
            mysqli_close($con);
            //return print_r(json_encode($preference->init_point));
            return print_r($preference->init_point);
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