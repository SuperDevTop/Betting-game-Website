<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$sessao = null;
$mr_u = 0;
$adm_type = 'user';

if(isset($_SESSION['mr_usuario']) && isset($_SESSION['mr_type'])){
    if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        
        // Nível usuário
        $adm_type = $_SESSION['mr_type'];
        
        if($adm_type == 'admin' || $adm_type == 'suport' || $adm_type == 'financial'){
            $sessao = 'Ativa';
        }
   } 
}

if($sessao == null){
    header("location:/backend");
}

if(isset($_GET['cancelar'])){
    $wID = $_GET['cancelar'];
    
    $conn->consultar("SELECT * FROM referral_withdraws WHERE id = $wID");
    $dados = $conn->escrever();
    $id_user = $dados['id_affiliate'];
    
    $sql = "UPDATE referral_withdraws SET referral_withdraws.status = 'canceled' WHERE id = $wID";
    $conn->consultar($sql);
    
    $id_suport = $_SESSION['mr_cod'];
    
    $conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Solicitação de saque de Afiliado cancelada por $mr_u.')");
    header("location:/backend/saquesafiliado");
}

if(isset($_GET['pagar'])){
    $wID = $_GET['pagar'];
    
    $conn->consultar("SELECT * FROM referral_withdraws WHERE id = $wID");
    $dados = $conn->escrever();
    $id_user = $dados['id_affiliate'];
    
    $sql = "UPDATE referral_withdraws SET referral_withdraws.status = 'success' WHERE id = $wID";
    $conn->consultar($sql);
    
    $id_suport = $_SESSION['mr_cod'];
    $conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Solicitação de saque de Afiliado efetuada por $mr_u.')");
    
    header("location:/backend/saquesafiliado");
}

if(isset($_GET['estornar'])){
    $wID = $_GET['estornar'];
    
    $conn->consultar("SELECT * FROM referral_withdraws WHERE id = $wID");
    $dados = $conn->escrever();
    $id_user = $dados['id_affiliate'];
    
    $sql = "UPDATE referral_withdraws SET referral_withdraws.status = 'pending' WHERE id = $wID";
    $conn->consultar($sql);
    
    $id_suport = $_SESSION['mr_cod'];
    $conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Saque de Afiliado efetuado foi estornado $mr_u.')");
    
    header("location:/backend/saquesafiliado");
}
?>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Saques de Afiliados</title>
	<link rel="icon" href="/img/ico.png">
    <!-- Scripts -->
	<script src="/js/jquery.js"></script>
	<script src="/js/default_backend.js"></script>
	<!-- Estilos -->
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default_backend.css" rel="stylesheet" type="text/css">
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
    <style>
        .menuParceiros{
            background-color: #273038;
            box-shadow: 0 0 2px 1px #111;
        }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        
        <h1>Saques de Afiliados</h1>
        <span class="breadcrumbs">Painel > Saques de Afiliados</span>
        <h2 class="subtitulo">Saques Solicitados</h2>
        <?php
        $conn->consultar("SELECT * FROM referral_withdraws WHERE referral_withdraws.status = 'pending'");
    
        echo '<table class="lista">';
            echo '<tr>';
                echo '<th width="50%" style="text-align:left;">Nome</th>';
                echo '<th width="10%" style="text-align:center;">Valor</th>';
                echo '<th width="25%" style="text-align:center;">Data</th>';
                echo '<th width="15%">Ação</th>';
            echo '</tr>';
        while($dados = $conn->escrever()){
            echo '<tr style="border-radius: 10px 10px 0 0;">';
                echo '<td width="50%" style="text-align:left;">'.$dados['full_name'].'</td>';
                echo '<td width="10%" style="text-align:center;"><b>R$ '.number_format($dados['amount'],2,',','.').'</b></td>';
                echo '<td width="25%" style="text-align:center;">'.date('d/m/Y - H:i:s', strtotime($dados['date'])).'</td>';
                if($adm_type == 'financial' || $adm_type == 'admin'){
                    echo '<td width="15%"><a href="saquesafiliados/pagar/'.$dados['id'].'">Pagar</a> | <a href="saquesafiliados/cancelar/'.$dados['id'].'">Cancelar</a></td>';
                }else{
                    echo '<td width="15%">&nbsp;</td>';
                }
            echo '</tr>';
            echo '<tr style="border-radius: 0 0 10px 10px; margin-top: -5px;">';
                $cpf = str_replace(".","",$dados['cpf']);
                $cpf = str_replace("-","",$dados['cpf']);
                echo '<td colspan="5">'.$cpf.' | ';
                echo 'Banco: '.$dados['bank'].' | ';
                echo 'Agência: '.$dados['agency'].' | ';
                echo 'Tipo: '.$dados['account_type'].' | ';
                echo 'Conta:'.$dados['account'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
        
        <h2 class="subtitulo">Ultimos 15 Saques Efetuados</h2>
        <?php
        $conn->consultar("SELECT * FROM referral_withdraws WHERE referral_withdraws.status = 'success' ORDER BY date DESC LIMIT 15");
    
        echo '<table class="lista">';
            echo '<tr>';
                echo '<th width="50%" style="text-align:left;">Nome</th>';
                echo '<th width="10%" style="text-align:center;">Valor</th>';
                echo '<th width="25%" style="text-align:center;">Data</th>';
                echo '<th width="15%">Ação</th>';
            echo '</tr>';
        while($dados = $conn->escrever()){
            echo '<tr style="border-radius: 10px 10px 0 0;">';
                echo '<td width="50%" style="text-align:left;">'.$dados['full_name'].'</td>';
                echo '<td width="10%" style="text-align:center;"><b>R$ '.number_format($dados['amount'],2,',','.').'</b></td>';
                echo '<td width="30%" style="text-align:center;">'.date('d/m/Y - H:i:s', strtotime($dados['date'])).'</td>';
            echo '</tr>';
            echo '<tr style="border-radius: 0 0 10px 10px; margin-top: -5px;">';
                $cpf = str_replace(".","",$dados['cpf']);
                $cpf = str_replace("-","",$dados['cpf']);
                echo '<td colspan="5">'.$cpf.' | ';
                echo 'Banco: '.$dados['bank'].' | ';
                echo 'Agência: '.$dados['agency'].' | ';
                echo 'Tipo: '.$dados['account_type'].' | ';
                echo 'Conta:'.$dados['account'].'</td>';
                if($adm_type == 'financial' || $adm_type == 'admin'){
                    echo '<td width="15%"> <a href="saquesafiliados/estornar/'.$dados['id'].'"> Estornar</a></td>';
                }else{
                    echo '<td width="15%">&nbsp;</td>';
                }
            echo '</tr>';
        }
        echo '</table>';
        ?>
        
        <h2 class="subtitulo">Ultimos 15 Saques Cancelados</h2>
        <?php
        $conn->consultar("SELECT * FROM referral_withdraws WHERE referral_withdraws.status = 'canceled' ORDER BY date DESC LIMIT 15");
    
        echo '<table class="lista">';
            echo '<tr>';
                echo '<th width="50%" style="text-align:left;">Nome</th>';
                echo '<th width="10%" style="text-align:center;">Valor</th>';
                echo '<th width="30%" style="text-align:center;">Data</th>';
            echo '</tr>';
        while($dados = $conn->escrever()){
            echo '<tr style="border-radius: 10px 10px 0 0;">';
                echo '<td width="50%" style="text-align:left;">'.$dados['full_name'].'</td>';
                echo '<td width="10%" style="text-align:center;"><b>R$ '.number_format($dados['amount'],2,',','.').'</b></td>';
                echo '<td width="30%" style="text-align:center;">'.date('d/m/Y - H:i:s', strtotime($dados['date'])).'</td>';
            echo '</tr>';
            echo '<tr style="border-radius: 0 0 10px 10px; margin-top: -5px;">';
                $cpf = str_replace(".","",$dados['cpf']);
                $cpf = str_replace("-","",$dados['cpf']);
                echo '<td colspan="5">'.$cpf.' | ';
                echo 'Banco: '.$dados['bank'].' | ';
                echo 'Agência: '.$dados['agency'].' | ';
                echo 'Tipo: '.$dados['account_type'].' | ';
                echo 'Conta:'.$dados['account'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
    <section>
</body>    
</html>