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
$conn2 = new Conexao();

#-> Sair
if(isset($_GET['sair'])){
	$_SESSION['mr_usuario'] = "";
	$_SESSION['mr_cod'] = "";
	$_SESSION['mr_type'] = "";
	session_unset();
	session_destroy();
	header("location:/");
}

#-> Verifica se esta logado
$sessao = null;
$mr_u = 0;
$adm_type = 'user';

if(isset($_SESSION['mr_usuario'])){
    if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        
        // Nível usuário
        $conn->consultar("SELECT id, adm_type FROM users WHERE email = '$mr_u'");
        $dados = $conn->escrever();
        $mr_c = $dados['id'];
        $_SESSION['mr_cod'] = $dados['id'];
        $adm_type = $dados['adm_type'];
        $_SESSION['mr_type'] = $dados['adm_type'];
        
        if($adm_type == 'admin' || $adm_type == 'suport' || $adm_type == 'financial'){
            $_SESSION['mr_type'] = $adm_type;
            $sessao = 'Ativa';
        }
   } 
}

if($sessao == null){
    header("location:/login?pg=backend");
}

// Periodo
$ini = date('Y-m-d', strtotime('-30 days'));
$fim = date('Y-m-d'); 

if(isset($_GET['inicio'])){
    $ini = $_GET['inicio'];
    $fim = $_GET['fim']; 
}

// Total de usuários
$conn->consultar("SELECT count(id) as total FROM users WHERE updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalUsuarios = $dados['total'];

// Total de usuários online
$dtUserOn = date('Y-m-d H:i:s', strtotime('-60 seconds'));
$conn->consultar("SELECT count(DISTINCT user_id) as total FROM crash_bettings WHERE updated_at >= '$dtUserOn'");
$dados = $conn->escrever();
$totalUsuariosOn = $dados['total'];

// Total de usuários com deposito
$conn->consultar("SELECT count(DISTINCT transactions.to) as total FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'complete' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalUsuariosDeposito = $dados['total'];

// Total de usuários com mais de um deposito
$conn->consultar("SELECT count(transactions.to) as qnt FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'complete' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59' GROUP BY transactions.to HAVING qnt > 1");
$totalUsuariosDepositoRecorrente = $conn->nResultados();

// Total de usuários com mais de 5 depositos
$conn->consultar("SELECT count(transactions.to) as qnt FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'complete' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59' GROUP BY transactions.to HAVING qnt = 5");
$totalUsuariosDepositoRecorrente5 = $conn->nResultados();

// Total de usuários com saldo acima de 49,99
$conn->consultar("SELECT count(id) as total FROM users WHERE balance > 49.99");
$dados = $conn->escrever();
$totalUsuariosSaldo = $dados['total'];

// Total de usuários ativos
$conn->consultar("SELECT count(id) as total FROM users WHERE updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalUsuariosAtivosMes = $dados['total'];

// Total de solicitacoes de saque do mês
$conn->consultar("SELECT count(id) as total FROM withdraws WHERE updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalSolicitacoesSaqueMes = $dados['total'];

// Total de solicitacoes de saque pendentes do mês
$conn->consultar("SELECT count(id) as total FROM withdraws WHERE status='pending' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalSolicitacoesSaquePendentesMes = $dados['total'];

// Total de Depositos
$conn->consultar("SELECT SUM(transactions.amount) as total FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'complete' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalDeposito = $dados['total'];

// Total de Saques
$conn->consultar("SELECT SUM(paid_amount) as total FROM withdraws WHERE withdraws.status = 'success' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59'");
$dados = $conn->escrever();
$totalSaque = $dados['total'];

// Total com Usuário
$conn->consultar("SELECT SUM(balance) as total FROM users WHERE balance > 0");
$dados = $conn->escrever();
$totalComUsuario = $dados['total'];

// Total com Usuário acima de 5
$conn->consultar("SELECT SUM(balance) as total FROM users WHERE balance > 5");
$dados = $conn->escrever();
$totalComUsuarioAcimaValor = $dados['total'];

//----------------EXTRATO-----------------EXTRATO--------------
$sql = "SELECT SUM(amount) as total, updated_at FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'complete' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59' GROUP BY DATE(updated_at) ORDER BY updated_at ASC";

$conn->consultar($sql);

if($conn->nResultados()>0){
        
	$dados = $conn->escrever();
	
	// Verifica saque
	$conn2->consultar("SELECT SUM(requested_amount) as total FROM withdraws WHERE date(updated_at) = '".$dados['updated_at']."'");
	if($conn->nResultados()>0){
		$dados2 = $conn2->escrever();
		$back_end_valor_y_saq = "'".$dados2['total']."'";
	}else{
		$back_end_valor_y_saq = "'0.00'";
	}
	
	$back_end_valor_x = "'".date('d/m/Y',strtotime($dados['updated_at']))."'";
	$back_end_valor_y_dep = "'".$dados['total']."'";
	$back_end_amount = $dados['total'];
	$i = 0;

	$back_end_max = $dados['total'];
    $back_end_min = $dados['total'];
	
	while($dados = $conn->escrever()){
		
		// Verifica saque
		$conn2->consultar("SELECT SUM(requested_amount) as total FROM withdraws WHERE date(updated_at) = '".date('Y-m-d',strtotime($dados['updated_at']))."'");
		if($conn2->nResultados()>0){
			$dados2 = $conn2->escrever();
			$back_end_valor_y_saq .= ",'".$dados2['total']."'";
		}else{
			$back_end_valor_y_saq .= ",'0.00'";
		}
		
		$back_end_amount = $dados['total'];
		$back_end_valor_y_dep .= ",'".$dados['total']."'";

		$i++;
		$back_end_valor_x .= ",'".date('d/m/Y',strtotime($dados['updated_at']))."'";
		
		if($back_end_max < $back_end_amount){ $back_end_max = $back_end_amount; }
        if($back_end_min > $back_end_amount){ $back_end_min = $back_end_amount; }
	}
	
	$back_end_max += 10;
	$back_end_min = 0;
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
	<script src="/js/default_backend.js"></script>
	<!-- Estilos -->
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default_backend.css" rel="stylesheet" type="text/css">
	<!-- Chart JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .menuHome{
            background-color: #273038;
            box-shadow: 0 0 2px 1px #111;
        }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        <h1>Resumo (<?php echo $adm_type;?>)</h1>
        <span class="breadcrumbs">Painel > Resumo</span>
        
        <div style="display: block; width: calc(100% - 20px); background-color: #525960; color: #fff; text-align: right; padding: 10px; margin: 5px 10px; font-size: 1rem; border-radius: 3px;">
            Período:
            <form style="display: inline-block; margin-left: 10px;">
                <input type="date" name="inicio" onChange="dataMin(this.value)" value="<?php echo $ini;?>" style="text-align: center; border: 0; border-radius: 5px; padding: 3px; background-color: #ccc;">
                <input type="date" name="fim" id="dtMax" value="<?php echo $fim;?>" min="<?php echo $ini;?>" style="text-align: center; border: 0; border-radius: 5px; padding: 3px; background-color: #ccc;">
                <input type="submit" value="Filtrar" style="color: #fff; background-image: linear-gradient(0deg,#283D71,#466DA5); border-radius: 5px; padding: 4px 12px; border: 0;">
            </form>
            <script>
                function dataMin(dt){
                    document.getElementById("dtMax").setAttribute("min", dt);
                }
            </script>
        </div>
        
        <div class="box">
            <p>
                <b><?php echo $totalUsuariosOn;?></b>
                Usuários online
            </p>
            <span>Ver mais</span>
        </div>
        <!-- ####################### -->
		<div class="box">
            <p>
                <b><?php echo $totalUsuarios;?></b>
                Usuários cadastrados
            </p>
            <span>Ver mais</span>
        </div>
        <!-- ####################### -->
        <div class="box">
            <p>
                <b><?php echo $totalUsuariosDeposito;?></b>
                Usuários com depósito
            </p>
            <span>Ver mais</span>
        </div>
        <!-- ####################### -->
        <div class="box">
            <p>
                <b><?php echo $totalUsuariosAtivosMes;?></b>
                Usuários ativos
            </p>
            <span>Ver mais</span>
        </div>
        <!-- ####################### -->
        <div class="box">
            <p>
                <b><?php echo $totalSolicitacoesSaqueMes;?></b>
                Solicitações de saque
            </p>
            <span><?php echo $totalSolicitacoesSaquePendentesMes;?> Pendente(s)</span>
        </div>
		
		<div class="box">
            <p>
                <b><?php echo $totalUsuariosDepositoRecorrente;?></b>
                Usuários com mais de um depósito
            </p>
            <span><?php echo $totalUsuariosDepositoRecorrente5;?> (cinco ou mais)</span>
        </div>
        <!-- ####################### -->
        <?php if($adm_type == 'admin' || $adm_type == 'financial'){?>
			<div class="box">
				<p>
					<b><?php echo 'R$ '.number_format($totalDeposito,2,",",".");?></b>
					Depósitos
				</p>
				<span>Ver mais</span>
			</div>
			<!-- ####################### -->
			<div class="box">
				<p>
					<b><?php echo 'R$ '.number_format($totalSaque,2,",",".");?></b>
					Saques
				</p>
				<span>Ver mais</span>
			</div>
			<!-- ####################### -->
			<div class="box">
				<p>
					<b><?php echo 'R$ '.number_format($totalComUsuario,2,",",".");?></b>
					Saldo dos usuários
				</p>
				<span><?php echo 'R$ '.number_format($totalComUsuarioAcimaValor,2,",",".");?> (Acima de 49,99 | <?php echo $totalUsuariosSaldo;?> usuários)</span>
			</div>
		
		
			<canvas id="myChart" class="grafUser"></canvas>
			<script>
			var xValues = [<?php echo $back_end_valor_x;?>];
			var yValuesD = [<?php echo $back_end_valor_y_dep;?>];
			var yValuesS = [<?php echo $back_end_valor_y_saq;?>];
			var uType = [<?php echo $back_end_valor_x;?>];

			new Chart("myChart", {
			  type: "line",
			  data: {
				labels: uType,
				datasets: [{
				  fill: false,
				  lineTension: 0,
				  backgroundColor: "rgba(0,0,255,1.0)",
				  borderColor: "rgba(0,0,255,0.1)",
				  data: yValuesD
				},{
				  fill: false,
				  lineTension: 0,
				  backgroundColor: "rgba(255,0,0,1.0)",
				  borderColor: "rgba(255,0,255,0.1)",
				  data: yValuesS
				}]
			  },
			  options: {
				legend: {display: false},
				scales: {
				  yAxes: [{ticks: {min: <?php echo $back_end_min;?>, max:<?php echo $back_end_max;?>}}],
				}
			  }
			});
			</script>
        <?php }?>
    <section>
</body>    
</html>