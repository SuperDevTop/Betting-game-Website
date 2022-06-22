<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=utf-8');

error_reporting(ALL);
ini_set('display_errors', 1);

if(isset($_POST['email'])){
   if($_POST['email'] != ""){
       $mr_u = $_POST['email'];
       $_SESSION['mr_usuario'] = $_POST['email'];
       echo 'sucess';
   }else{
       echo 'error';
   }
}else{
   echo 'error';
}
?>