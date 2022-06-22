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

if(isset($_SESSION['mr_usuario'])){
    if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        
        // Nível usuário
        $conn->consultar("SELECT adm_type FROM users WHERE email = '$mr_u'");
        $dados = $conn->escrever();
        $adm_type = $dados['adm_type'];
        
        if($adm_type == 'admin' || $adm_type == 'suport'){
            $sessao = 'Ativa';
        }
   } 
}

if($sessao == null){
    //die("Erro");
}

// Busca
$busca = null;
if(isset($_GET['busca'])){
    $_SESSION['busca'] = $_GET['busca'];
    $busca = $_GET['busca'];
}else if(isset($_GET['limpar'])){
    $_SESSION['busca'] = null;
    $busca = null;
    header("location:/backend/usuarios");
}else if(isset($_SESSION['busca'])){
    $busca = $_SESSION['busca'];
}

// Paginação
$sql = "SELECT count(id) as total FROM users";
if($busca != null){
    $sql = "SELECT count(id) as total FROM users WHERE email LIKE '%$busca%' OR full_name LIKE '%$busca%'";
}
$conn->consultar($sql);
$dados = $conn->escrever();
$pgTotal = round($dados['total']/20,0);
$pgAtual = 0;
$pgAnterior = 0;
$pgProxima = 20;

if(isset($_GET['pagina'])){
    $pgAtual = $_GET['pagina'];
    
    $pgAnterior = $pgAtual - 20;
    if($pgAnterior < 0){ $pgAnterior = 0; }
    
    $pgProxima = $pgAtual + 20;
    if($pgProxima > $pgTotal){ $pgProxima = $pgTotal; }
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
    .menuUsuarios{
        background-color: #273038;
        box-shadow: 0 0 2px 1px #111;
    }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        
        <h1>Usuários</h1>
        <span class="breadcrumbs">Painel > Usuarios</span>
        <?php
        $sql = "SELECT id, full_name, email, balance, updated_at FROM users LIMIT $pgAtual,20";
        if($busca != null){
            $sql = "SELECT id, full_name, email, balance, updated_at FROM users WHERE email LIKE '%$busca%' OR full_name LIKE '%$busca%' LIMIT $pgAtual,20";
        }
        $conn->consultar($sql);
    
        echo '<table class="lista">';
            echo '<tr style="    background-color: transparent; border: 0; box-shadow: unset;">';
            echo '<th width="30%">&nbsp;</th>';
            echo '<th width="20%">&nbsp;</th>';
            echo '<th width="20%">&nbsp;</th>';
            echo '<th width="30%"><form method="get">';
            echo '<input type="text" name="busca" value="'.$busca.'" class="buscar">';
            if($busca == null){
                echo '<input type="submit" value="🔎" class="buscarBt">';
            }else{
                echo '<input type="buttom" value="❌" onClick="location.href=\'?limpar\'" class="buscarBt">';
            }
            echo '</form></th>';
            echo '</tr>';
            
            echo '<tr>';
            echo '<th width="30%">Nome</th>';
            echo '<th width="30%">Email</th>';
            echo '<th width="20%">Saldo</th>';
            echo '<th width="20%">Ultimo Acesso</th>';
            echo '</tr>';
        
            while($dados = $conn->escrever()){
                echo '<tr>';
                echo '<td width="30%"><a href="usuarios/'.$dados['id'].'">'.$dados['full_name'].'</td>';
                echo '<td width="30%">'.$dados['email'].'</td>';
                echo '<td width="25%" style="text-align:center;">R$ '.number_format($dados['balance'],2,',','.').'</td>';
                echo '<td width="15%" style="text-align:center;">'.$dados['updated_at'].'</td>';
                echo '</tr>';
            }
            
            echo '<tr>';
            echo '<th width="30%">&nbsp;</th>';
            echo '<th width="20%" style="text-align:center;"><a href="?pagina='.$pgAnterior.'"><i class="fas fa-angle-double-left"></i> Anterior</a></th>';
            echo '<th width="20%" style="text-align:center;"><a href="?pagina='.$pgProxima.'">Próxima <i class="fas fa-angle-double-right"></i></a></th>';
            echo '<th width="30%">&nbsp;</th>';
            echo '</tr>';
        echo '</table>';
        ?>
    <section>
</body>    
</html>