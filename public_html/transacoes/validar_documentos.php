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
$up = new Upload();

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

if(isset($_FILES['selfie'])){
    $up = new Upload();
    $up->pasta("documentos/");
    $up->tamanho(3);// 3Mb
    $up->extensao("imagem");
    $up->arquivo($_FILES['selfie']);
    if($up->upload()){
        echo "Selfie";
    }
}

if(isset($_FILES['docFrente'])){
    $up = new Upload();
    $up->pasta("documentos/");
    $up->tamanho(3);// 3Mb
    $up->extensao("imagem");
    $up->arquivo($_FILES['docFrente']);
    if($up->upload()){
        echo "Frente";
    }
}

if(isset($_FILES['docVerso'])){
    $up = new Upload();
    $up->pasta("documentos/");
    $up->tamanho(3);// 3Mb
    $up->extensao("imagem");
    $up->arquivo($_FILES['docVerso']);
    if($up->upload()){
        echo "Verso";
    }
}


#-> Verifica se existe registro em documentos, caso não ele cria
$conn->consultar("SELECT * FROM users WHERE email = '$mr_u'");
$id_user = $conn->escrever();
$id_user = $id_user['id'];
$conn->consultar("SELECT * FROM users_documents WHERE id_user = $id_user");
if($conn->nResultados() == 0){
    $conn->consultar("INSERT INTO users_documents (id_user) VALUES ($id_user)");
}


$versao = md5(date("dmyHis"));
$_POST = array();
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Million Rocket - Validação de documentos</title>
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
    <span class="frm_box_titulo">
        <img class="frm_logo" src="/img/ico_azul.png">
        <h1 class="tituloCLR">Validação</h1>
        <h2 class="tituloCLR">Formulário de validação de documentos.</h2>
    </span>
    <div class="frmCLR" method="post" action="">
        <p style="color:#f44336;">⚠️️ Para efetuar saques precisamos validar seus dados cadastrais.</p>
        
        <form method="post" enctype="multipart/form-data">
            <label for="selfie" class="btValidarDoc">Tirar Selfie</label>
            <input type="file" name="selfie" id="selfie" value="Tirar Selfie" onChange="form.submit" required style="display: none">
        </form>
        
        <form method="post" enctype="multipart/form-data">
            <label for="docFrente" class="btValidarDoc">Enviar Documento (frente)</label>
            <input type="file" name="docFrente" id="docFrente" value="Enviar Documento" onChange="form.submit" required style="display: none">
        </form>
        
        <form method="post" enctype="multipart/form-data">
            <label for="docVerso" class="btValidarDoc">Enviar Documento (verso)</label>
            <input type="file" name="docVerso" id="docVerso" value="Enviar Documento" onChange="form.submit" required style="display: none">
        </form>
        
        <p>*Os documentos passam por um processo de validação e levam até 12 horas.</p>
        <p>*Usar documentos falsos é crime.</p>
    </div>
</body>
</html>