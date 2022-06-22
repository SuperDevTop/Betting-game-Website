<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=utf-8');

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$mr_u = null;
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
       $mr_u = $_SESSION['mr_usuario'];
   } 
}

if($mr_u != null){
    header("location:/game");
}

#-> Recuperar Senha
if(isset($_POST['recEmail'])){
    $re = $_POST['recEmail'];
    $at = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    
    $sql = "UPDATE usuarios SET status = 'rec-$at' WHERE email = '$re'";
    
    if($conn->consultar($sql)){
        $cb = "MIME-Version: 1.1\n";
        $cb.= "Content-type: text/html; charset=utf-8\n";
        $cb.= "From: millionrocket@millionrocket.com\n";
        $cb.= "Return-Path: no-reply@millionrocket.com\n";

        $cl = 'https://millionrocket.com/recsenha/rec-'.$at;

        $msg = file_get_contents('emails/recsenha.php');
        $msg = str_replace("#LINK", $cl, $msg);

        $envio = mail($re, "Recuperação de Senha - Million Rocket", $msg, $cb);
        if($envio){
            header("location:/recsenha/ok");
        }else{
            header("location:/recsenha/erro");
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Recuperar Senha</title>
	<link rel="icon" href="/img/ico.png">
   
<script src="/js/jquery.js"></script>
<script src="/js/default.js"></script>
	
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	body,td,th {
	font-family: "Open Sans", Helvetica, sans-serif;
}
    </style>
	
<script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
</head>

<body class="forms">
    <span class="frm_box_titulo">
        <img class="frm_logo" src="/img/ico_azul.png">
        <h1 class="tituloCLR" style="margin-top: -5px;">Recuperar<br>Senha</h1>
    </span>
    <form class="frmCLR" method="post" action="">
        <?php
            if(isset($_GET['recsenhaok'])){
                echo "<p>Email de recuperação enviado!</p>";
            }
            if(isset($_GET['recsenhaerro'])){
                echo "<p>Erro ao buscar email!</p>";
            }
        ?>
        <label for="recEmail">E-mail</label>
        <input type="email" name="recEmail" id="recEmail" equired>
        <input type="submit" value="Recuperar" class="frmBt">
    </form>
    <script>frmCLRlabel();</script>
</body>
</html>