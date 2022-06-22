<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
header('Content-Type: text/html; charset=utf-8');

error_reporting(ALL);
ini_set('display_errors', 1);

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$mr_u = null;
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
       $mr_u = $_SESSION['mr_usuario'];
   } 
}

if($mr_u == null){
    header("location:/stage/login");
}


$chave = $_POST['chave'];
$valor = $_POST['valor'];

#-> Deposito
$curl = curl_init();

curl_setopt_array($curl, [
CURLOPT_URL => "https://api.iugu.com/v1/invoices/$chave?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => [
"Accept: application/json"
],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    //echo "cURL Error #:" . $err;
    echo 'erro';
} else {

    $dados = json_decode($response,true);

    if($dados['status'] == 'paid'){
        //--------------------------- Atualiza Transação para Pago (complete)
        $conn->consultar("SELECT * FROM transactions WHERE transactions.status = 'pending' AND transaction_id = '$chave'");
        if($conn->nResultados() == 1){
            $conn->consultar("UPDATE transactions SET transactions.status = 'complete' WHERE transaction_id = '$chave'");
    
            //--------------------------- Consulta Transação para Pegar ID do Usuário
            $conn->consultar("SELECT transactions.to as para FROM transactions WHERE transaction_id = '$chave'");
            $userID = $conn->escrever();
            $userID = $userID['para'];
            
            //--------------------------- Consulta Saldo Atual do Usuário e Adiciona Depósito
            $conn->consultar("SELECT * FROM users WHERE id = $userID");
            $saldo = $conn->escrever();
            $saldoIni = $saldo['balance'];
            $afiliado = $saldo['affiliate_id'];
            $saldo = (float)$saldo['balance']+(float)$valor;
            $saldoIni = $saldo['balance'];
            
            //--------------------------- Consulta total de Transações do Usuário
            
            $conn->consultar("SELECT * FROM transactions WHERE transactions.type = 'deposit' AND  transactions.to = $userID");
            $transacoes = $conn->nResultados();
            
            if($transacoes == 1){
                if((float)$valor >= 100){
                    $bonus = (float)$valor * 0.3;
                }else if((float)$valor >= 50){
                    $bonus = (float)$valor * 0.2;
                }else if((float)$valor >= 30){
                    $bonus = (float)$valor * 0.1;
                }else{
                    $bonus = 0;
                }
                
                if((float)$bonus > 150){
                    $bonus = 150;    
                }
                
                $saldo = (float)$saldo + (float)$bonus;
                
                //----------------------- Bônus Amigo (Afiliado)
                if((float)$valor >= 40){
                    if($afiliado != ""){
                        $conn->consultar("SELECT * FROM users WHERE id = $afiliado AND referral_rate = 0");
                        if($conn->nResultados() == 1){
                            $bonusAfiliado = $conn->escrever();
                            $totalAfiliado = $bonusAfiliado['referral_users'] + 1;
                            $bonusAfiliado = (float)$bonusAfiliado['balance'] + 25;
                            $conn->consultar("UPDATE users SET referral_users = $totalAfiliado, balance = '$bonusAfiliado' WHERE id = $afiliado");
                        }
                    }
                }
                
            }
            
            //--------------------------- Atualiza Saldo do Usuário
            $sql = "UPDATE users SET balance = '$saldo' WHERE id = $userID";
            $conn->consultar($sql);
            
            //--------------------------- Log de Transação
            $sqlEncode = htmlentities($sql." S- ".$saldoIni." V- ".$valor." B- ".$bonus, ENT_QUOTES);
            $conn->consultar("INSERT INTO transaction_log (id_user, evento) VALUES ($userID,'$sqlEncode')");
        }
    }    

    echo $dados['status'];
}