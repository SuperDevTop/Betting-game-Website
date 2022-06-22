<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
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
    header("location:/stage/affiliate_earning");
}

if(isset($_POST['saqNome'])){
    $sn = $_POST['saqNome'];
    $sc = $_POST['saqCPF'];
    $sv = $_POST['saqValor'];
    $dt = date("Y-m-d H:i:s",time());
    
    $conn->consultar("SELECT * FROM users WHERE email = '$mr_u'");
    $dados = $conn->escrever();
    $id_affiliate = $dados['id'];
    $perRef = $dados['referral_rate'];
    
    #-> Total depósitos
    $sql = "SELECT SUM(transactions.amount) as total FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $id_affiliate ORDER BY transactions.id DESC";
    
    $conn->consultar($sql);
    $dados = $conn->escrever();
    $totaldeposito = $dados['total'];
    $totaldeposito = $totaldeposito*$perRef;
    
    #-> Total Saques
    $sql = "SELECT SUM(amount) as total FROM referral_withdraws WHERE id_affiliate = $id_affiliate";
    $conn->consultar($sql);
    $dados = $conn->escrever();
    $totalsaque = $dados['total'];
    
    #-> Total final
    $totalfinal = $totaldeposito - $totalsaque;
    
    if((float)$sv >= 50){
        if((float)$totalfinal >= (float)$sv){
            if($_POST['pixoubanco'] == "dadosPix"){
                $pix = $_POST['saqPix'];
                
                //$sql = "INSERT INTO withdraws (user_id,full_name,cpf,pix,requested_amount,status,created_at,updated_at) VALUES ";
                //$sql.= "($id_user,'$sn','$sc','$pix','$sv','Pending','$dt','$dt')";

            }else if($_POST['pixoubanco'] == "dadosConta"){
                $sb = $_POST['saqBanco'];
                $sa = $_POST['saqAgencia'];
                $stp = $_POST['saqTpConta'];
                $scc = $_POST['saqConta'];
                
                $sql = "INSERT INTO referral_withdraws (id_affiliate,full_name,cpf,bank,agency,account_type,account,amount,status) VALUES ";
                $sql.= "($id_affiliate,'$sn','$sc','$sb',$sa,'$stp',$scc,'$sv','Pending')";
                //echo $sql;
            }
            $conn->consultar($sql);
            header("location:/stage/affiliate_earning");
            
        }else{
            echo "<h3>Saldo insuficiente! $totalfinal</h3>";
        }
    }else{
        echo '<h3>Valor mínimo deve ser de R$50,00!</h3>';
    }
}

$versao = md5(date("dmyHis"));
$_POST = array();
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Solicitação de Saque de Afiliado</title>
	<link rel="icon" href="/img/ico.png">
    <!-- Scripts -->
    <script src="/js/jquery.js?v=<?php echo $versao;?>"></script>
    <script src="/js/default.js?v=<?php echo $versao;?>"></script>
	<!-- Estilos -->
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	body,td,th {
	font-family: "Open Sans", Helvetica, sans-serif;
}
    </style>
	<!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
</head>

<body class="forms">
    <?php include('header.php')?>
    <?php if($dados == null){?>
    <span class="frm_box_titulo">
        <img class="frm_logo" src="/img/ico_azul.png">
        <h1 class="tituloCLR">Saque</h1>
        <h2 class="tituloCLR">Saque de Afiliados</h2>
    </span>
    <form class="frmCLR" method="post" action="">
        <p style="color:#f44336;">⚠️️ Os dados bancarios devem ser o mesmo do cadastro.</p>
        
        <p class="aviso"></p>
        <span class="progressBox" style="display: block; border: 1px solid #999; margin: 0 0 20px 0; background-color: #303030;">
            <span class="progressBar" style="display: block; width: 20%; height: 18px; text-align: center; font-size: 0.8rem; color: #fff; background-color: #4368a0;">
                <span class="progressText" style="position: absolute; display: table; width: 273px; text-align: center;">-</span>
            </span>
        </span>
        
        <label for="saqNome">Nome Completo</label>
        <input type="text" name="saqNome" id="saqNome" required>
        
        <label for="saqCPF">CPF</label>
        <input type="text" name="saqCPF" id="saqCPF" required>
        
        <label for="pixoubanco">Como deseja receber?</label>
        <!--span style="display: inline-block; width: 45%; color: #fff; font-size: 14px; line-height: 23px; margin-left: 10px;">
            <input style="width: 20px; float: left;" type="radio" name="pixoubanco" id="pixoubanco" value="dadosPix" onClick="escolhePixConta(this.value)">PIX
        </span-->
        <span style="display: inline-block; width: 45%; color: #fff; font-size: 14px; line-height: 23px; margin-left: 10px;">
            <input style="width: 20px; float: left;" type="radio" name="pixoubanco" id="pixoubanco" value="dadosConta" onClick="escolhePixConta(this.value)" checked>Conta
        </span>
        
        <span id="dadosConta">
            <label for="saqBanco">Banco (código)</label>
            <input type="text" name="saqBanco" id="saqBanco">
            
            <label for="saqAgencia">Agência</label>
            <input type="text" name="saqAgencia" id="saqAgencia">
            
            <label for="saqTpConta">Tipo Conta</label>
            <select name="saqTpConta" id="saqTpConta">
                <option value="checking_account">Conta Corrente</option>
                <option value="saving_account ">Conta Poupança</option>
            </select>
            
            <label for="saqConta">Conta</label>
            <input type="text" name="saqConta" id="saqConta">
        </span>
        
        <span id="dadosPix" style="display:none;">
            <label for="saqPix">PIX</label>
            <input type="text" name="saqPix" id="saqPix">
        </span>
        
        <label for="saqValor">Valor</label>
        <input type="number" step="1" min="50" name="saqValor" id="saqValor">
        
        <input type="submit" value="Solicitar" class="frmBt">
        <p>*Os valores passam por um processo de validação e levam até 2 dias úteis</p>
        <p>*Valor mínimo para saque é de R$ 50,00</p>
    </form>   
    <script>frmCLRlabel();</script>
    <?php }?>
    
    <script>
    function escolhePixConta(tipo){
        if(tipo == 'dadosPix'){
            
            $('#dadosPix').css({'display':'block'});
              $('#saqPix').prop('required',true);
            
            $('#dadosConta').css({'display':'none'});
              $('#saqBanco').prop('required',false);
              $('#saqAgencia').prop('required',false);
              $('#saqTpConta').prop('required',false);
              $('#saqConta').prop('required',false);
            
        }else if(tipo == 'dadosConta'){
            
            $('#dadosPix').css({'display':'none'});
              $('#saqPix').prop('required',false);
            
            $('#dadosConta').css({'display':'block'});
              $('#saqBanco').prop('required',true);
              $('#saqAgencia').prop('required',true);
              $('#saqTpConta').prop('required',true);
              $('#saqConta').prop('required',true);
        }
    }
    
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    
    <script>  
    $.post("/transacoes/total_jogadas.php", function(data){
       var depApo = data.split("/");
       var dif = parseFloat(depApo[1]) - parseFloat(depApo[0]);
       var per = 90 - ((dif/parseFloat(depApo[1]))*100);
       
       $("span.progressText").html("R$"+parseFloat(depApo[0]).toFixed(2)+" de R$"+parseFloat(depApo[1]).toFixed(2));
       $("span.progressBar").css({'width':per+'%'});
       
       if(dif > 0){
           $('p.aviso').html("É preciso apostar pelo menos 1x o valor depositados para solicitar o saque!");
           $('input.frmBt').css({'display':'none'});
       }else{
           $('span.progressBox').css({'display':'none'});
       }
       
       console.log(per);
    });
    </script>
</body>
</html>