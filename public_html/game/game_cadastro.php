<?php
session_start();
ini_set('session.save_path','SOME WRITABLE PATH');
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=utf-8');

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

if($mr_u != null){
    header("location:/game");
}

#-> Cadatro
if(isset($_POST['cadNome'])){
    $cn = $_POST['cadNome'];
    $ce = $_POST['cadEmail'];
    $cd = $_POST['cadDtNasc'];
    $cs = md5("mirollickonet".$_POST['cadSenha']);
    $cp = $_POST['cadCodPromo'];
    $dt = date("Y-m-d H:i:s",time());
    
    $at = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    
    $sql = "INSERT INTO usuarios (nome,email,senha,dtNasc,codPromo,status,dtCadastro) VALUES ";
    $sql.= "('$cn','$ce','$cs','$cd','$cp','Novo-$at','$dt')";
    
    if($conn->consultar($sql)){
        $conn2->consultar("SELECT * FROM usuarios WHERE status = 'Novo-$at'");
        $dados = $conn2->escrever();
        $_SESSION['mr_cod'] = $dados['cod'];
        $_SESSION['mr_usuario'] = $dados['email'];
        $_SESSION['mr_nome'] = $dados['nome'];
        
        $cb = "MIME-Version: 1.1\n";
        $cb.= "Content-type: text/html; charset=utf-8\n";
        $cb.= "From: millionrocket@millionrocket.com\n";
        $cb.= "Return-Path: no-reply@millionrocket.com\n";
        
        $cl = 'https://millionrocket.com/ativar/'.$at.'-'.$conn->ultimoId().'';
        
        $msg = file_get_contents('emails/bemvindo.php');
        $msg = str_replace("#NOME", $cn, $msg);
        $msg = str_replace("#EMAIL", $ce, $msg);
        $msg = str_replace("#LINK", $cl, $msg);
        
        $envio = mail($ce, "Seja bem vindo(a) à Million Rocket!", $msg, $cb);
        if($envio){
            header("location:/cadastro/sucesso");
        }else{
            header("location:/cadastro/erro/envio");
        }
        header("location:/cadastro/sucesso");
    }else{
        header("location:/cadastro/erro");
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Cadastro</title>
	<link rel="icon" href="/img/ico.png">
   
    <script src="/js/jquery.js"></script>
    <script src="/js/default.js"></script>
	
	<link href="/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/css/default.css" rel="stylesheet" type="text/css">
	
    <script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>
</head>

<body class="forms">
    <?php if(isset($_GET['sucesso'])){?>
        <h1 class="tituloCLR">Sucesso</h1>
        <p class="textoCLR">Seu cadastro foi efetuado com sucesso!</p>
        <p class="textoCLR">Para ativar sua conta enviamos em seu email de cadastro um link de ativação</p>
        <p class="textoCLR">Caso não encontre, verifique também em <i>span</i></p>
        <script>setTimeout(function(){location.href = "/rocket";},5000);</script>
    <?php }else if(isset($_GET['erro'])){?>
        <h1 class="tituloCLR">Erro ao Cadastrar</h1>
        <p class="textoCLR">Infelizmente não conseguimos efetuar seu cadastro</p>
        <p class="textoCLR">Tente novamente, verifique se já utilizou este email e se seus dados estão corretos</p>
        <p class="textoCLR">Se o erro perssistir entre em contato com nossa equipe</p>
        <script>setTimeout(function(){location.href = "/cadastro";},7000);</script>
    <?php }else if(isset($_GET['ativar'])){
        $at = $_GET['ativar'];
        $br = strpos($at, '-');
        $cod = substr($at,$br+1,strlen($at));
        $at = substr($at,0,$br);

        $conn->consultar("SELECT * FROM usuarios WHERE cod = $cod AND status = 'Novo-$at'");

        if($conn->nResultados()==1){
            $dados = $conn->escrever();
            $conn->consultar("UPDATE usuarios SET status = 'Ativo' WHERE cod = $cod");
            
            $_SESSION['mr_cod'] = $dados['cod'];
            $_SESSION['mr_usuario'] = $dados['email'];
            $_SESSION['mr_nome'] = $dados['nome'];

            echo '<h1 class="tituloCLR">Bem vindo(a)</h1>';
            echo '<p class="textoCLR">'.$dados['nome'].' obrigado por fazer parte do time <b>MILLION ROCKET</b></p>';
            echo '<p class="textoCLR">Sua conta foi ativada com sucesso!</p>';
            echo '<p class="textoCLR">Você será redirecionado(a).</p>';
            echo '<script>setTimeout(function(){location.href = "/game";},5000);</script>';
        }else{
            echo '<h1 class="tituloCLR">Código invalido!</h1>';
            echo '<p class="textoCLR">Seu código está incorret ou ou ja expirou.</p>';
            echo '<p class="textoCLR">Você será redirecionado(a).</p>';
            echo '<script>setTimeout(function(){location.href = "/";},5000);</script>';
        }
    }else{?>
        <span class="frm_box_titulo">
            <img class="frm_logo" src="/img/ico_azul.png">
            <h1 class="tituloCLR">Cadastro</h1>
        </span>
        <form class="frmCLR" method="post" action="">
            <label for="cadNome">Nome de Exibição</label>
            <input type="text" name="cadNome" id="cadNome" required>
            <label for="cadEmail">E-mail</label>
            <input type="email" name="cadEmail" id="cadEmail" equired>
            <label for="cadDtNasc">Data de Nascimento</label>
            <input type="date" name="cadDtNasc" id="cadDtNasc" required>
            <label for="cadSenha">Senha</label>
            <input type="password" name="cadSenha" id="cadSenha" required>
            <?php if(isset($_GET['promo'])){?>
                <label style="top:0; background: transparent; color:#fff;">Código Promocional</label>
                <input type="text" name="cadCodPromo" onChange="this.value='<?php echo $_GET['promo'];?>'" value="<?php echo $_GET['promo'];?>">
            <?php }else{?>
                <label for="cadCodPromo">Código Promocional (opcional)</label>
                <input type="text" name="cadCodPromo" id="cadCodPromo">
            <?php }?>
            <input type="submit" value="Cadastrar" class="frmBt">
            <span class="center">
                <a class="btCadastrese" href="/login">Já tenho cadastro</a>
            </span>
        </form>
        <script>frmCLRlabel();</script>
    <?php }?>
</body>
</html>