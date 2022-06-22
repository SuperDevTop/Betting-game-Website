<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Sao_Paulo');

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$mr_p = null;
$sessao = null;
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
            $codigo = $_GET['chave'];
        
            echo "<h1>Código: $codigo</h1>";


            $conn->consultar("SELECT rocket_parceiros.empresa, count(rocket_depositos.cod) as qnt ,sum(rocket_depositos.valor) as total, rocket_parceiros.ganho FROM rocket_parceiros LEFT JOIN usuarios ON usuarios.codPromo = rocket_parceiros.codigo LEFT JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_parceiros.codigo = '$codigo' AND rocket_depositos.status = 'pago' GROUP BY empresa ORDER BY empresa ASC");

            //---------------------------------

            echo '<h2 class="subtitulo">Saldo</h2>';
            if($conn->nResultados()>0){
                echo '<table class="lista">';
                $dados = $conn->escrever();
                    echo '<tr>';
                    $comissao = ((float)$dados['total']/100)*(float)$dados['ganho'];
                    $comissao = number_format($comissao,2,',','.');
                    echo "<td>".$dados['empresa']." | </td>";
                    echo "<td>Quantidade: ".$dados['qnt']."</td>";
                    if($comissao > 0){
                        echo " | <td>Comissão: R$ ".$comissao."</td>";
                    }
                    echo '</tr>';
                echo '</table>';
            }else{
                echo '<table class="lista"><tr><td colspan="3">Sem registros</td></tr></table>';
            }
            //---------------------------------

            echo '<h2 class="subtitulo">Depositos de Maio</h2>';
            $conn->consultar("SELECT rocket_depositos.nome, rocket_depositos.data, rocket_depositos.valor, rocket_parceiros.ganho FROM rocket_parceiros LEFT JOIN usuarios ON usuarios.codPromo = rocket_parceiros.codigo LEFT JOIN rocket_depositos ON rocket_depositos.codUser = usuarios.cod WHERE rocket_parceiros.codigo = '$codigo' AND rocket_depositos.status = 'pago' ORDER BY rocket_depositos.data DESC");

            if($conn->nResultados()>0){
                echo '<table class="lista">';
                while($dados = $conn->escrever()){
                    echo '<tr>';
                    $comissao = ((float)$dados['valor']/100)*(float)$dados['ganho'];
                    $comissao = number_format($comissao,2,',','.');
                    echo "<td>".$dados['nome']." | </td>";
                    echo "<td> ".$dados['data']."</td>";
                    if($comissao > 0){
                        echo "<td> | R$ ".$comissao."</td>";
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }else{
                echo '<table class="lista"><tr><td colspan="2">Sem registros</td></tr></table>';
            }
            
            //---------------------------------

            echo '<h2 class="subtitulo">Cadastros de Maio</h2>';
            $conn->consultar("SELECT usuarios.nome, usuarios.dtCadastro FROM rocket_parceiros LEFT JOIN usuarios ON usuarios.codPromo = rocket_parceiros.codigo WHERE rocket_parceiros.codigo = '$codigo' ORDER BY usuarios.cod DESC");

            if($conn->nResultados()>0){
                echo '<table class="lista">';
                while($dados = $conn->escrever()){
                    echo '<tr>';
                    echo "<td>".$dados['nome']." | </td>";
                    echo "<td> ".$dados['dtCadastro']."</td>";
                    echo '</tr>';
                }
                echo '</table>';
            }else{
                echo '<table class="lista"><tr><td colspan="1">Sem registros</td></tr></table>';
            }
        ?>
    <section>
</body>    
</html>