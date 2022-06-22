<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

$conn = new Conexao();

?>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Backend</title>
	<link rel="icon" href="/img/ico.png">
    <!-- Scripts -->
	<script src="/js/jquery.js"></script>
	<script src="/js/default_backend.js?v=4"></script>
	<!-- Estilos -->
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default_backend.css?v=4" rel="stylesheet" type="text/css">
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
    <style>
        .menuParceiros{
            background-color: #273038;
            box-shadow: 0 0 2px 1px #111;
        }
    </style>
</head>

<body>
    <section>
        <header class="listaParceiro"><img src="/img/ico.png">Million Rocket</header>
        
            <?php
            $email = $_GET['email'];
        
            echo "<h1>Email: $email</h1>";
        
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $conn->consultar($sql);
            $cod = $conn->escrever();
            $cod = $cod['id'];
        
            $conn->consultar("SELECT * FROM users WHERE users.affiliate_id = $cod");
            $cadastros = $conn->nResultados();
        
            $conn->consultar("SELECT * FROM users WHERE users.affiliate_id = $cod AND balance > 0");
            $cadastroscomsaldo = $conn->nResultados();
        
            //---------------------------------

            $conn->consultar("SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod ORDER BY transactions.id DESC");

            echo '<h2 class="subtitulo">Total de Cadastros: '.$cadastros.' | Com Deposito: '.$conn->nResultados().'</h2>';
            echo '<table style="color:#fff;">';
            while($dados = $conn->escrever()){
                echo '<tr>';
                $comissao = ((float)$dados['amount']/100)*(float)$dados['referral_rate'];
                $comissao = number_format($comissao,2,',','.');
                echo "<td>".$dados['full_name']." | </td>";
                echo "<td> ".date('d/m/Y H:i:s', strtotime('-3 hours', strtotime($dados['created_at'])))."</td>";
                if($comissao > 0){
                    echo "<td> | R$ ".$comissao."</td>";
                }
                echo '</tr>';
            }
            echo '</table>';
        ?>
    <section>
</body>    
</html>