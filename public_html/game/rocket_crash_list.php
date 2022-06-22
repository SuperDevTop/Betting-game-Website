<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/class/".$class.".class.php";
}

$conn = new Conexao();
$conn2 = new Conexao();

#-> Verifica se esta logado
$mr_u = null;
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
       $mr_u = $_SESSION['mr_usuario'];
   } 
}

if($mr_u == null){
    die("Erro");
}

$conn->consultar("SELECT * FROM ( SELECT * FROM rocket_jogos WHERE ativo = 0 ORDER BY cod DESC LIMIT 12 ) t1 ORDER BY t1.cod");
while($l = $conn->escrever()){
    $ch = $l['chave'];
    $conn2->consultar("SELECT((SELECT count(cod) FROM extrato WHERE chave = '$ch' AND movimento = 'ganho')-(SELECT count(cod) FROM extrato WHERE chave = '$ch' AND movimento = 'perda')) as qnt");
    $qnt = $conn->escrever();
    $qnt = $qnt['qnt'];
    
    if($l['valGanho'] > $l['valPerda']){
        echo '<li class="verde">'.$l['valor'].'</li>';
    }else{
        echo "<li>".$l['valor']."</li>";
    }
}
                
?>