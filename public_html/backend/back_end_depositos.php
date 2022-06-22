<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');

function __autoload($class){
	include_once "class/".$class.".class.php";
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
        .menuDepositos{
            background-color: #273038;
            box-shadow: 0 0 2px 1px #111;
        }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        
        <h1>Depositos</h1>
        <span class="breadcrumbs">Painel > Depositos</span>
        <form method="post">
            <select>
                <option value="5">Maio</option>
                <option value="6">Junho</option>
            </select>
        </form>
        <h2 class="subtitulo">Depositos Efetuados</h2>
        <?php
        $conn->consultar("SELECT usuarios.nome, rocket_depositos.valor, rocket_depositos.data FROM usuarios INNER JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_depositos.status = 'pago' ORDER BY usuarios.cod DESC LIMIT 20");
    
        echo '<table class="lista">';
        while($dados = $conn->escrever()){
            echo '<tr><td>';
            echo $dados['nome']."-> ".$dados['data']." depositos / R$ ".($dados['valor']/100)."<br>";
            echo '</td></tr>';
        }
        echo '</table>';
        ?>
        
        <h2 class="subtitulo">Depositos Pendentes</h2>
        <?php
        $conn->consultar("SELECT usuarios.cod, usuarios.nome, rocket_depositos.chave, rocket_depositos.valor, rocket_depositos.data FROM usuarios INNER JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_depositos.status = 'pendente' ORDER BY usuarios.cod DESC LIMIT 20");
    
        echo '<table class="lista">';
        while($dados = $conn->escrever()){
            echo '<tr><td>';
            echo $dados['nome']."-> ".$dados['data']." depositos / R$ ".($dados['valor']/100)."</br>";
            echo $dados['chave'];
            echo ' -> <a href="/deposito_status_full.php?cod='.$dados['cod'].'">Verificar</a>';
            echo '</td></tr>';
        }
        echo '</table>';
        ?>
        
        <h2 class="subtitulo">Depositos Pendentes a mais de um dia</h2>
        <?php
        $conn->consultar("SELECT usuarios.cod, usuarios.nome, rocket_depositos.chave, rocket_depositos.valor, rocket_depositos.data FROM usuarios INNER JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_depositos.status = 'pendente' AND rocket_depositos.data < now() - interval 1 day ORDER BY usuarios.cod DESC LIMIT 20");
    
        echo '<table class="lista">';
        while($dados = $conn->escrever()){
            echo '<tr><td>';
            echo $dados['nome']."-> ".$dados['data']." depositos / R$ ".($dados['valor']/100)."</br>";
            echo $dados['chave'];
            echo ' -> <a href="/deposito_pendente_delete.php?cod='.$dados['cod'].'">Excluir</a><br><br>';
            echo '</td></tr>';
        }
        echo '</table>';
        ?>
    <section>
</body>    
</html>