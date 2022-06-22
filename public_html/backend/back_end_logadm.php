<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$sessao = null;
$mr_u = 0;

if(isset($_SESSION['mr_usuario'])){
    if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        $mr_c = $_SESSION['mr_cod'];
        
        // Nível usuário
        $adm_type = $_SESSION['mr_type'];
        
        if($adm_type == 'admin' || $adm_type == 'suport' || $adm_type == 'financial'){
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
        .menuLogAdm{
            background-color: #273038;
            box-shadow: 0 0 2px 1px #111;
        }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        
        <h1>Saques</h1>
        <span class="breadcrumbs">Painel > Log Adm</span>
        
        <?php
        if($adm_type == 'admin'){
            echo '<h2 class="subtitulo">Resumo das alterações feitas pela equipe</h2>';
            $conn->consultar("SELECT * FROM suport_log ORDER BY id DESC");
        }else{
            echo '<h2 class="subtitulo">Resumo das alterações feitas</h2>';
            $conn->consultar("SELECT * FROM suport_log WHERE id_suport = $mr_c  ORDER BY id DESC");
        }    
    
        echo '<table class="lista">';
            echo '<tr>';
                echo '<th width="90%" style="text-align:left;">Data</th>';
                echo '<th width="10%" style="text-align:center;">Atividade</th>';
            echo '</tr>';
            while($dados = $conn->escrever()){
                echo '<tr style="border-radius: 10px 10px 0 0;">';
                    echo '<td width="50%" style="text-align:left;">'.$dados['created_at'].'</td>';
                    echo '<td width="50%" style="text-align:left;">'.$dados['atividade'].'</td>';
                echo '</tr>';
            }
        echo '</table>';
        ?>
    <section>
</body>    
</html>