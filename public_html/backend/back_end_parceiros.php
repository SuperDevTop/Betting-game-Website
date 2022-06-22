<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$sessao = null;
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
       $mr_u = $_SESSION['mr_cod'];
       if($mr_u == 17 || $mr_u == 19){
            $sessao = 'Ativa';
        }
   } 
}

if($sessao == null){
    //die("Erro");
}
?>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Backend</title>
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
        
        <h1>Parceiros</h1>
        <span class="breadcrumbs">Painel > Parceiros</span>
        <form method="post">
            <select>
                <option value="5">Maio</option>
                <option value="6">Junho</option>
            </select>
        </form>
        <?php
        $conn->consultar("SELECT rocket_parceiros.empresa, count(rocket_depositos.cod) as qnt ,sum(rocket_depositos.valor) as total, rocket_parceiros.ganho FROM rocket_parceiros LEFT JOIN usuarios ON usuarios.codPromo = rocket_parceiros.codigo LEFT JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_depositos.status = 'pago' GROUP BY empresa ORDER BY empresa ASC");
    
        echo '<ul class="lista">';
        while($dados = $conn->escrever()){
            echo '<li>';
            $comissao = ((float)$dados['total']/100)*(float)$dados['ganho'];
            $comissao = number_format($comissao,2,',','.');
            echo $dados['empresa']."-> ".$dados['qnt']." depositos / R$ ".$comissao."<br>";
            echo '</li>';
        }
        echo '</ul>';
        ?>
    <section>
</body>    
</html>