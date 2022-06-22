<?php
session_start();
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

if($mr_u == null){
    //header("location:/login");
}

$versao = md5(date("dmyHis"));
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket</title>
	<link rel="icon" href="/img/ico.png">

	<script src="/js/jquery.js"></script>
	<script src="/js/default.js?v=<?php echo $versao;?>"></script>
	<script src="/js/game_rocket.js?v=<?php echo $versao;?>"></script>  

	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default.css?v=<?php echo $versao;?>" rel="stylesheet" type="text/css">
	<link href="/css/game_rocket.css?v=<?php echo $versao;?>" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include_once("header.php")?>

    <div class="gameScreen">
        <div class="timer"><b>6s</b></div>
        <div class="tipoJogo">
            <div class="btJogoNormal">Normal</div>
            <div class="btJogoAuto">Auto</div>
        </div>
        <form class="aposta">
            <input type="button" value="Começar o Jogo" onClick="jogar();" class="btComJogo">
            <input type="button" value="Parar" onClick="parar();" class="btPararJogo">
            <input type="button" value="Aguarde..." class="btAguardeJogo">
            <input type="number" step="0.01" min="1" max="<?php echo $saldo;?>" placeholder="Quantia" pattern="[0-9]+" class="aposVal" required>
            <input type="button" value="2x" class="btMini" id="btDobrar">
            <input type="button" value="1/2" class="btMini" id="btMetade">
            <input type="number" step="0.01" min="1.5" placeholder="Auto Retirar" pattern="[0-9]+" class="aposRet">
        </form>
        <div class="avisoWin"><b>1X</b><span>Winner</span></div>
        <div class="pcoin-rain">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
            <img src="/img/coin_rocket.png">
        </div>
        
        <div class="avisoCrash"><b>1.10X</b><span>CRASHED</span></div>
        <div id="game">
            <ul class="linhas">
                <li>3x</li>
                <li>2x</li>
                <li>1x</li>
            </ul>
            <ul class="colunas">
                <li>3s</li>
                <li>2s</li>
                <li>1s</li>
            </ul>
            <img class="nave" id="logo" src="/img/ico_game.png">
            <div class="crashVal" style="font-size: 2rem;">2.43X</div>
        </div>
        <div class="jogosAnteriores">
            <div class="blur"></div>
            <ul>
                
            </ul>
            <img src="/img/dash.png" class="dash">
        </div>
        <div class="playersOn">
            <ul>
                <li><span>Jogador</span><span>Valor</span><span>Mult</span><span>Lucro</span></li>
            </ul>
        </div>
    </div>

</body>
</html>