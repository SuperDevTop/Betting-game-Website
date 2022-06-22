<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
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
$mr_u = 0;

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

if(isset($_GET['efetuarSaque'])){
    $codSaque = $_GET['efetuarSaque'];
    $valorSaque = $_GET['valorSaque'];
    $userSaque = $_GET['userSaque'];
    $chaveSaque = $_GET['chaveSaque'];
    $dt = date("Y-m-d H:i:s");
                               
    
    //echo "UPDATE rocket_saques SET status='Efetuado' WHERE cod=$codSaque";
    $conn->consultar("UPDATE rocket_saques SET status='Efetuado' WHERE cod=$codSaque");
    $conn->consultar("INSERT INTO extrato (codUser,data,valor,movimento,chave) VALUES ($userSaque,'$dt','$valorSaque','Saque','$chaveSaque')");
    $conn->consultar("UPDATE casa SET saques = saques+'$valorSaque' ORDER BY cod DESC LIMIT 1");
    header("location:/backend/saques");
}