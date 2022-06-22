<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
date_default_timezone_set('America/Sao_Paulo');
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
    //header("location:/stage/login");
}

//Consulta dados do usuário
$conn->consultar("SELECT * FROM users WHERE email = '$mr_u'");
$idUser = $conn->escrever();
$idUser = $idUser['id'];

//Montante apostado
$conn->consultar("SELECT sum(user_bet_amount) as total FROM crash_bettings WHERE user_id = $idUser");
$apostas = $conn->escrever();
$apostas = $apostas['total'];

//Montante depositado
$conn->consultar("SELECT sum(amount) as total FROM transactions WHERE transactions.to = $idUser AND transactions.type = 'deposit'");
$depositos = $conn->escrever();
$depositos = $depositos['total'];

echo "$apostas/$depositos";
?>