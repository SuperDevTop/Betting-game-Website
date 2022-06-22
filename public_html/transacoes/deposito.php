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
$conn2 = new Conexao();

#-> Verifica se esta logado
$mr_u = null;
if(isset($_SESSION['mr_usuario'])){
   if($_SESSION['mr_usuario'] != ""){
       $mr_u = $_SESSION['mr_usuario'];
   } 
}

if($mr_u == null){
    header("location:/stage/login");
}

#-> Deposito
$dados = null;
$chavePix = null;
$erro = 0;

if(isset($_POST['depNome'])){
    
    if($_POST['depValor'] < 20){
        echo '<h3>Valor menor do que R$20,00!</h3>';
        $erro = 1;
    }

    //Consulta dados do usuário
    $sql = "SELECT * FROM users WHERE email = '$mr_u'";
    $conn->consultar($sql);
    $idUser = $conn->escrever();
    $idUser = $idUser['id'];
    
    //Coleta CPF
    $cpf = $_POST['depCPF'];
    $cpf = str_replace('.','',$cpf);
    $cpf = str_replace('-','',$cpf);
    
    //Verifica CPF em outra conta
    $sql = "SELECT * FROM users WHERE cpf = '$cpf' AND email != '$mr_u'";
    $conn->consultar($sql);
    if($conn->nResultados() >= 1){
        echo "<h3>CPF em uso por outra conta!</h3>";
        $erro = 1;
    }
    
    //Verifica se conta tem outro CPF
    if($erro == 0){
        $sql = "SELECT * FROM users WHERE email = '$mr_u'";
        $conn->consultar($sql);
        $verificaCPF = $conn->escrever();
        $verificaCPF = $verificaCPF['cpf'];

        if($verificaCPF == ""){
            $sql = "UPDATE users SET cpf = '$cpf' WHERE email = '$mr_u'";
            $conn->consultar($sql);
        }else if($verificaCPF != $cpf){
            echo "<h3>CPF diferente do utilizado nesta conta!</h3>";
            $erro = 1;
        }
    }
    
    if($erro == 0){
        $amount = $_POST['depValor'];

        $sql = "SELECT transactions.created_at, transactions.amount, transactions.transaction_id FROM transactions INNER JOIN users ON users.id = transactions.to WHERE transactions.type = 'deposit' AND transactions.status = 'pending' AND transactions.amount = '$amount' AND users.email = '$mr_u' ORDER BY transactions.id DESC LIMIT 1";

        $conn->consultar($sql);

        if($conn->nResultados() >= 1){
            //echo 'depOLD';
            $oldPixChave = $conn->escrever();
            $oldPixChave = $oldPixChave['transaction_id'];
            $dados = verPix($oldPixChave);
        }else{
            //echo 'depNEW';
            $nome = $_POST['depNome'];
            $email = $mr_u;
            $data = date("Y-m-d H:i:s");
            $vencimento = date("Y-m-d");
            $valor = $_POST['depValor']."00";
            $amount = $_POST['depValor'];
            $chave = "dep-".$idUser;
            
            $sql = "INSERT INTO transactions (type,transactions.from,transactions.to,amount,transaction_id,transactions.status,created_at,updated_at) VALUES ";
            $sql.= "('deposit','iugo',$idUser,'$amount','$chave','pending','$data','$data')";

            if($conn->consultar($sql)){

                $conn->consultar("SELECT * FROM transactions WHERE transaction_id = '$chave'");
                $codDep = $conn->escrever();
                $codDep = $codDep['id'];

                #-> IUGU CURL
                $curl = curl_init();

                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://api.iugu.com/v1/invoices?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => "{\"ensure_workday_due_date\":false,\"items\":[{\"description\":\"Deposito\",\"quantity\":1,\"price_cents\":$valor}],\"payable_with\":[\"pix\"],\"payer\":{\"cpf_cnpj\":\"$cpf\",\"name\":\"$nome\"},\"email\":\"$email\",\"due_date\":\"$vencimento\",\"return_url\":\"https://millionrocket.com/deposito/sucesso\",\"notification_url\":\"https://millionrocket.com/deposito/processo\",\"order_id\":\"$codDep\"}",
                  CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Content-Type: application/json"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if($err){
                    //echo "cURL Error #:" . $err;
                    header("location:/transacoes/deposito?erro=conexao");
                }else{  
                    $dados = json_decode($response,true);
                    if($dados != null){
                        $chave = $dados['id'];
                        if($chave != ""){
                            $chavePix = $chave;
                            $sql = "UPDATE transactions SET transaction_id = '$chave'  WHERE id = $codDep";
                            $conn->consultar($sql);
                        }else{
                            header("location:/transacoes/deposito?erro=banco");
                        }
                    }else{
                        $sql = "DELETE FROM transactions WHERE id = $codDep";
                        $conn->consultar($sql);
                        header("location:/transacoes/deposito?erro=codigo");
                    }
                }
            }
        }
    }
}

#-> Deposito VER por URL
if(isset($_GET['ver'])){
    //echo 'depVER';
    $dados = verPix($_GET['ver']);
}

#-> Deposito VER
function verPix($c){
    $chave = $c;
    
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.iugu.com/v1/invoices/$chave?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "Accept: application/json"
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      //echo "cURL Error #:" . $err;
        return null;
    } else {
        return json_decode($response,true);
    }
}

echo '<!--';
    var_dump($dados);
echo '-->';

$versao = md5(date("dmyHis"));
$_POST = array();
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket</title>
	<link rel="icon" href="/img/ico.png">

    <script src="/js/jquery.js"></script>
    <script src="/js/default.js?v=<?php echo $versao;?>"></script>

	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default.css?v=<?php echo $versao;?>" rel="stylesheet" type="text/css">
	<style type="text/css">
	body,td,th {
	font-family: "Open Sans", Helvetica, sans-serif;
}
    </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="forms">
    <?php #include_once("header.php")?>
    <?php if($dados == null){?>
    <span class="frm_box_titulo">
        <img class="frm_logo" src="/img/ico_azul.png">
        <h1 class="tituloCLR">Depósito</h1>
    </span>
    <form class="frmCLR" method="post" action="">
        <?php
        $conn->consultar("SELECT * FROM users WHERE email = '$mr_u'");
        $dados = $conn->escrever();
        $cpf = $dados['cpf'];
		$nome = $dados['full_name'];
        ?>
        
        <a class="btFechar" href="/stage/transaction_history">fechar <i class="fa fa-close"></i></a>
        <label for="depNome">Nome Completo</label>

        <input type="hidden" name="depNome" id="depNome" value="<?php echo $nome;?>">
        <input type="text" value="<?php echo $nome;?>" disabled required>
        
		<label for="depCPF">CPF Apenas números</label>
        <?php if($cpf == ""){?>
            <input type="text" name="depCPF" id="depCPF" required>
        <?php }else{?>
            <input type="hidden" name="depCPF" id="depCPF" value="<?php echo $cpf;?>">
            <input type="text" value="<?php echo $cpf;?>" disabled required>
        <?php }?>
        <label for="depValor" class="val">Valor</label>
        <input type="number" step="1" min="20" name="depValor" id="depValor" required>
        <span class="preValor">
            <a href="javascript:$('#depValor').val(30);$('label.val').addClass('ativo');">R$ 30,00</a>
            <a href="javascript:$('#depValor').val(60);$('label.val').addClass('ativo');">R$ 60,00</a> 
            <a href="javascript:$('#depValor').val(90);$('label.val').addClass('ativo');">R$ 90,00</a> 
            <a href="javascript:$('#depValor').val(120);$('label.val').addClass('ativo');">R$ 120,00</a> 
        </span>
        
        <input type="submit" value="Depositar" class="frmBt">
        
        <h2 class="depositosLista">Depositos em aberto*</h2>
        <table class="depositosLista">
            <tr>
                <td>Valor</td><td colspan="2">Data</td>
            </tr>
            <?php
            $sql = "SELECT transactions.created_at, transactions.amount, transactions.transaction_id FROM transactions INNER JOIN users ON users.id = transactions.to WHERE transactions.type = 'deposit' AND transactions.status = 'pending' AND users.email = '$mr_u' ORDER BY transactions.id DESC ";
            $conn->consultar($sql);

            while($dados = $conn->escrever()){
                if(strpos($dados['transaction_id'], 'dep-') === false){
                    echo '<tr>';
                    echo '<td width="30%">R$ '.number_format($dados['amount'],2,',','.').'</td>';
                    echo '<td width="50%">'.$dados['created_at'].'</td>';
                    echo '<td width="20%"><a href="/transacoes/deposito/'.$dados['transaction_id'].'">Ver</a></td>';
                    echo '</tr>';
                }else{
                    $sql = "DELETE FROM transactions WHERE transaction_id = '".$dados['transaction_id']."'";
                    $conn2->consultar($sql);
                }
            }
            ?>
        </table>
        <i class="depositosLista">Após alguns dias estes links pix não apareceram mais</i>
    </form>   
    <script>frmCLRlabel();</script>
    <?php }else{?>
    <span class="frm_box_titulo">
        <img class="frm_logo" src="/img/ico_azul.png">
        <h1 class="tituloCLR">Depósito</h1>
    </span>
    <form class="frmCLR">
        <a class="btVoltar" href="/transacoes/deposito"><i class="fa fa-arrow-left"></i> voltar</a>
        <img class="logoPix" src="/img/pix.png" width="120px">
        <b class="depValor"><?php echo "R$ ".($dados['total_cents']/100).",00";?></b>
        <img class="depQrcode" src="<?php echo $dados['pix']['qrcode'];?>" width="220px">
        <p class="depText">Leia o código QR abaixo no aplicativo Pix</p>
        <p class="depText">Conclua o depósito com seu banco</p>
        <i style="display: block; font-size: 0.5rem; overflow: hidden; width: 270px;"><?php echo $dados['pix']['qrcode_text'];?></i>
        <a class="depCopiaCodigo" id="depCopiaCodigo" href="javascript:void(0);" onclick="copyToClipboard(this,'<?php echo $dados['pix']['qrcode_text'];?>')">Copiar Código</a>
    </form>
    <span style="display: block;width: 260px;margin: 0 auto;text-align: center;color: #fff; margin-top: 20px;padding: 9px; background-color: #333; border-radius: 3px; box-shadow: 0 0 6px 0 #333;">Aguardando Pagamento <i class="fa fa-spinner" style="margin: 0 0 0 15px;transform: rotate(0deg);animation: moveSpinner 1s infinite;"></i></span>
    <style>
        @keyframes moveSpinner {
      from {transform: rotate(0deg);}
      to {transform: rotate(359deg);}
    }
    </style>
    
    <script>
    function analise(){
        $.post("/transacoes/deposito_status.php",{chave:'<?php echo $dados['id']?>',valor:'<?php echo (float)$dados['items_total_cents']/100?>'}, function(data){
            let status = data;
            if(status == 'paid'){
                location.href = "/stage/transaction_history"
            }else{
                setTimeout('analise()',3000);
            }
        });
    }
    analise();
    </script>
    <?php }?>
    
    <script>
    
    //UPDATE PAGE ON FOCUS
    var blurred = false;
    window.onblur = function() { blurred = true; };
    window.onfocus = function() { blurred && (analise()); };    
        
    function copyURI(evt) {
        evt.preventDefault();
        navigator.clipboard.writeText(evt.target.getAttribute('href')).then(() => {
          /* clipboard successfully set */
        }, () => {
          /* clipboard write failed */
        });
    }
        
    function copyToClipboard(bt,text) {
       const elem = document.createElement('textarea');
       elem.value = text;
       document.body.appendChild(elem);
       elem.select();
       document.execCommand('copy');
       document.body.removeChild(elem);
       document.getElementById('depCopiaCodigo').innerHTML = "Código Copiado";    
    }
        
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</body>
</html>