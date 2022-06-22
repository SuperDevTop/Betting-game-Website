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
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        if($mr_u == "lpdzandre@gmail.com" || $mr_u == "jonataslenz@gmail.com"){
            $sessao = 'Ativa';
        }
   } 
}

if($sessao == null){
    die("Erro");
}

#-> EMAIL
$email = new Email();

$email->setDe("noreply@millionrocket.com");
$email->setPara("lpdzandre@gmail.com");
$email->setResposta("noreply@millionrocket.com");
$email->setAssunto("Indique um amigo e Ganhe! Million Rocket");

$msg = file_get_contents('bonus_indicacao.php');

$email->setMensagem($msg);

if($email->enviar()){
    echo "ok";
}else{
    echo "erro";
}
?>