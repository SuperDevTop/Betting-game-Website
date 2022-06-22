<?php
if(isset($_POST['crash'])){
    date_default_timezone_set('America/Sao_Paulo');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $jogo = new DateTime("2022-06-08 09:19:00");
    $atual = new DateTime(date('Y-m-d H:i:s.u'));
    $crash = 2;
    
    $segundos = ($jogo->diff($atual)->s);
    $minutos = ($jogo->diff($atual)->i);
    
    $tempo = ($segundos + $minutos*60)/2;
    
    $valor = $tempo*0.01;
    
    echo number_format($valor,2);
}
?>