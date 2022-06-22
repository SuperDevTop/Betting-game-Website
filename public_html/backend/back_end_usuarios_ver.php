<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function __autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

$conn = new Conexao();

#-> Verifica se esta logado
$sessao = null;
$mr_u = 0;
$adm_type = 'user';

if(isset($_SESSION['mr_usuario']) && isset($_SESSION['mr_type'])){
    if($_SESSION['mr_usuario'] != ""){
        $mr_u = $_SESSION['mr_usuario'];
        
        // Nível usuário
        $adm_type = $_SESSION['mr_type'];
        
        if($adm_type == 'admin' || $adm_type == 'suport' || $adm_type == 'financial'){
            $sessao = 'Ativa';
        }
    } 
}

if($sessao == null){
    header("location:/backend");
}


#-> Edita CPF
if(isset($_POST['editCPF'])){
	$cpf = $_POST['editCPF'];
	$id_user = $_POST['id_user'];
	
    $sql = "UPDATE users SET cpf = '$cpf' WHERE id = $id_user";
    if($conn->consultar($sql)){
		$id_suport = $_SESSION['mr_cod'];
		$conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'CPF alterado por $mr_u.')");
		header("location:/backend/usuarios/".$id_user);
	}
}

#-> ADD Bônus
if(isset($_POST['addBonus'])){
	$bonus = $_POST['addBonus'];
	$id_user = $_POST['id_user'];
	
    $sql = "UPDATE users SET balance = balance+'$bonus' WHERE id = $id_user";
    if($conn->consultar($sql)){
		$id_suport = $_SESSION['mr_cod'];
		$conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Bônus de $bonus adicionado por $mr_u.')");
		header("location:/backend/usuarios/".$id_user);
	}
}

#-> Edita Percentual de Afiliado
if(isset($_POST['editPER'])){
	$percent = $_POST['editPER'];
	$id_user = $_POST['id_user'];
	
    $sql = "UPDATE users SET referral_rate = '$percent' WHERE id = $id_user";
    if($conn->consultar($sql)){
		$id_suport = $_SESSION['mr_cod'];
		$conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Percentual de Afiliado alterado para $percent por $mr_u.')");
		header("location:/backend/usuarios/".$id_user);
	}
}

#-> Exclui conta do usuário, apenas registro da bela user, nas demais fica conservado.
if(isset($_GET['excuser'])){
	$id_user = $_GET['excuser'];
	
    $sql = "DELETE FROM users WHERE id = $id_user";
    if($conn->consultar($sql)){
		$id_suport = $_SESSION['mr_cod'];
		$conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Usuário $id_user, excluído por $mr_u.')");
		header("location:/backend/usuarios");
	}
}

#-> Exclui depósito pendente
if(isset($_GET['cancelar'])){
    $curl = curl_init();
    $chave = $_GET['cancelar'];

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.iugu.com/v1/invoices/$chave/cancel?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_HTTPHEADER => [
        "Accept: application/json"
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo 'Erro ao cancelar na IUGU';
    } else {
        $sql = "UPDATE transactions SET status = 'canceled' WHERE transaction_id = '$chave'";
        if($conn->consultar($sql)){
            $id_suport = $_SESSION['mr_cod'];
			$id_user = $_GET['id_user'];
			$conn->consultar("INSERT INTO suport_log (id_suport,id_user,atividade) VALUES ($id_suport,$id_user,'Solicitação de deposito $chave cancelada por $mr_u.')");
			header("location:/backend/usuarios/".$id_user);   
        }else{
            echo 'Erro ao cancelar';   
        }
        
    }
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
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
	<!-- Chart JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
    .menuUsuarios{
        background-color: #273038;
        box-shadow: 0 0 2px 1px #111;
    }
    </style>
</head>

<body>
    <?php include_once('back_end_header.php')?>
    
    <section>
        
        <h1>Usuários</h1>
        <span class="breadcrumbs">Painel > Usuarios</span>
        <?php
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $conn->consultar($sql);
        $dadosUser = $conn->escrever();
        
        $ini = date('Y-m-d');
        $fim = date('Y-m-d'); 
        
        if(isset($_GET['inicio'])){
            $ini = $_GET['inicio'];
            $fim = $_GET['fim']; 
            $sql = "SELECT * FROM transactions WHERE transactions.to = $user_id AND transactions.status != 'pending' AND updated_at >= '$ini' AND updated_at <= '$fim 23:59:59' ORDER BY updated_at ASC";
        }else{
            $sql = "SELECT * FROM transactions WHERE transactions.to = $user_id AND transactions.status != 'pending' ORDER BY updated_at ASC";
        }
        
        $conn->consultar($sql);
        
        if($conn->nResultados()>0){
        
            $dados = $conn->escrever();
            $user_valor_x = '0';
            $user_valor_y = $dados['amount'];
            $user_amount = $dados['amount'];
            $user_type = "'".$dados['type']."'";
            $i = 0;
            
            $user_max = 0;
            $user_min = 10000;
            
            //----------------EXTRATO-----------------EXTRATO--------------
            $user_extrato = '';
            $user_dep = 0;
            $user_ganho = 0;
            $user_perda = 0;
			
			$dt = date_format(date_create($dados['updated_at']), 'd/m/Y H:i:s');
            
            if($dados['type'] == 'deposit'){
                $user_dep += $dados['amount'];
                $user_extrato .= '<li class="deposito">'.$dt.' | Depósito <span>'.$dados['amount'].'</span></li>';
            }else if($dados['amount']>0){
                $user_ganho += $dados['amount'];
                $user_extrato .= '<li class="ganho">'.$dt.' | Ganho <span>'.$dados['amount'].'</span></li>';
            }else if($dados['amount']<0){
                $user_perda += $dados['amount'];
                $user_extrato .= '<li class="perda">'.$dt.' | Perda <span>'.$dados['amount'].'</span></li>';
            }
            
            while($dados = $conn->escrever()){
                
                $user_type .= ",'".$dados['type']."'";
                
                $user_amount = $user_amount + (float)$dados['amount'];
                $user_valor_y .= ','.$user_amount;
                
                $i++;
                $user_valor_x .= ','.$i;
                
                if($user_max < $user_amount){ $user_max = $user_amount; }
                if($user_min > $user_amount){ $user_min = $user_amount; }
                
                $dt = date_format(date_create($dados['updated_at']), 'd/m/Y H:i:s');
				
                if($dados['type'] == 'deposit'){
                    $user_dep += $dados['amount'];
                    $user_extrato .= '<li class="deposito">'.$dt.' | Depósito <span>R$ '.number_format($dados['amount'],2,",",".").'</span></li>';
                }else if($dados['amount']>0){
                    $user_ganho += $dados['amount'];
                    $user_extrato .= '<li class="ganho">'.$dt.' | Ganho <span>R$ '.number_format($dados['amount'],2,",",".").'</span></li>';
                }else if($dados['amount']<0){
                    $user_perda += $dados['amount'];
                    $user_extrato .= '<li class="perda">'.$dt.' | Perda <span>R$ '.number_format($dados['amount'],2,",",".").'</span></li>';
                }
            }
            
            $saldo = $dadosUser['balance'] - ($user_dep+$user_ganho+$user_perda);
            
            $user_extrato  = '<ul class="userExtrato"><li class="saldo">Saldo*: <span>R$ '.number_format($saldo,2,",",".").'</span></li>'.$user_extrato;
            $user_extrato .= '<li class="total">TOTAL: <span>R$ '.number_format($dadosUser['balance'],2,",",".").'</span></li>';
            $user_extrato .= '*Valor acumulado do periodo anterior, pode ser um dia antes ou mais dias.';
            $user_extrato .= '<ul class="userExtrato">';
        }
        ?>
        
        <h2 class="subtitulo"><?php echo  $dadosUser['full_name'];?></h2>
        <div style="display: block; width: 100%; max-width: 600px; background-color: #525960; color: #fff; text-align: right; padding: 10px; margin: 5px 0; font-size: 1rem; border-radius: 3px 3px 0 0;">
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
        
        <canvas id="myChart" class="grafUser"></canvas>
        
        <h2 class="userData">Dados do usuário</h2>
        <ul class="userData">
            <li>Nome: <span><?php echo  $dadosUser['full_name'];?></span></li>
            <li>Email: <span><?php echo  $dadosUser['email'];?></span></li>
            <li>CPF: 
				<span><?php echo  $dadosUser['cpf'];?></span> <a href="javascript:void(0);" onClick="editCPF()">✏️ Editar</a>
				<form method="post" class="editUser editCPF">
					CPF:
					<input type="hidden" name="id_user" value="<?php echo  $dadosUser['id'];?>">
					<input type="number" step="1" name="editCPF">
					<input type="submit" value="Alterar" class="btAlt">
					<a href="javascript:void(0);" class="btCan" onClick="editCPF(0)">Cancelar</a>
				</form>
			</li>
            <li>Telefone: <span><?php echo  $dadosUser['phone'];?></span></li>
            <li>Saldo: 
				<span><?php echo  $dadosUser['balance'];?></span> <a href="javascript:void(0);" onClick="addBonus()">💵 Add Bônus</a>
				<form method="post" class="editUser addBonus">
					Bônus:
					<input type="hidden" name="id_user" value="<?php echo  $dadosUser['id'];?>">
					<input type="number" step="1" name="addBonus">
					<input type="submit" value="Add" class="btAlt">
					<a href="javascript:void(0);" class="btCan" onClick="addBonus(0)">Cancelar</a>
				</form>
			</li>
            <li>Status: <span><?php echo  $dadosUser['status'];?></span></li>
            <li>Afiliado: <span><?php echo  $dadosUser['affiliate_id'];?></span></li>
            <li>% Bônus: 
				<span><?php echo  $dadosUser['referral_rate'];?></span> <a href="javascript:void(0);" onClick="editPER()">✏️ Editar</a>
				<form method="post" class="editUser editPer">
					% Bônus:
					<input type="hidden" name="id_user" value="<?php echo  $dadosUser['id'];?>">
					<input type="number" step="0.01" name="editPER">
					<input type="submit" value="Alterar" class="btAlt">
					<a href="javascript:void(0);" class="btCan" onClick="editPER(0)">Cancelar</a>
				</form>
			</li>
            <li>R$ Bônus: <span><?php echo  $dadosUser['referral_earning'];?></span></li>
            <li>Qnt Bônus: <span><?php echo  $dadosUser['referral_users'];?></span></li>
            <li>Dt Cadastro: <span><?php echo  date_format(date_create($dadosUser['created_at']), 'd/m/Y H:i:s');?></span></li>
            <li>Ultimo Acesso: <span><?php echo  date_format(date_create($dadosUser['updated_at']), 'd/m/Y H:i:s');?></span></li>
			<li>
			<a href="javascript:void(0);" class="btCan" onClick="excUser('<?php echo  $dadosUser['id'];?>','<?php echo  $dadosUser['full_name'];?>')">EXCLUIR USUÁRIO</a>
			</li>
        </ul>  
		
		<h2 class="extrato">Solicitações de Depósito</h2>
		<?php
		$conn->consultar("SELECT transactions.created_at, transactions.amount, transactions.transaction_id FROM transactions WHERE transactions.type = 'deposit' AND transactions.status = 'pending' AND transactions.to = ".$dadosUser['id']." ORDER BY transactions.id DESC");
		
		echo "<table border='1' class='user_depositos'>";
		while($dados = $conn->escrever()){  
			echo "<tr>";
				echo "<td>".date('d/m/Y H:i:s', strtotime('-3 hours', strtotime($dados['created_at'])))."</td>";
				echo "<td>".$dados['amount']."</td>";
				echo "<td colspan='5'>IUGU: ".$dados['transaction_id'];
				echo ' | <a href="javascript:void(0);" onClick="verificaDeposito(\''.$dados['transaction_id'].'\',\''.$dados['amount'].'\',\''.$dadosUser['id'].'\',this)">Verifica</a>';
				echo '</td>';
			echo "</tr>";
		}
		echo "<table>";
		?>
        
        <h2 class="extrato">Extrato</h2>
        <ul class="userExtrato">
            <li class="extratoBox dep">Depositos: <?php echo "R$ ".number_format($user_dep,2,",",".");?></li>
            <li class="extratoBox gan">Ganho: <?php echo "R$ ".number_format($user_ganho,2,",",".");?></li>
            <li class="extratoBox per">Perda: <?php echo "R$ ".number_format($user_perda,2,",",".");?></li>
        </ul>
        <?php echo $user_extrato;?>
        
        <script>
        var xValues = [<?php echo $user_valor_x;?>];
        var yValues = [<?php echo $user_valor_y;?>];
        var uType = [<?php echo $user_type;?>];
        
        new Chart("myChart", {
          type: "line",
          data: {
            labels: uType,
            datasets: [{
              fill: false,
              lineTension: 0,
              backgroundColor: "rgba(0,0,255,1.0)",
              borderColor: "rgba(0,0,255,0.1)",
              data: yValues
            }]
          },
          options: {
            legend: {display: false},
            scales: {
              yAxes: [{ticks: {min: <?php echo $user_min;?>, max:<?php echo $user_max;?>}}],
            }
          }
        });
        </script>
    <section>
</body>    
</html>