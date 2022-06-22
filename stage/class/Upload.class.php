<?php
error_reporting(ALL);
ini_set('display_errors', 1);

class Upload{
	private $pasta;
	private $arquivo;
	private $original;
	private $extensao;
	private $tipoExt;
	private $tamanho = 1;// 1MB
	private $uploadOk = 1;
	#~> Método construtor
	public function __construct(){
		$this->extensao();		
	}	
	#~> Define a pasta do upload
	public function pasta($p){
		$this->pasta = $p;
	}
	#~> Define o arquivo
	public function arquivo($a, $r = 1){		
		$this->original = $a;
		$this->extensao = pathinfo($a["name"],PATHINFO_EXTENSION);
		$this->extensao = strtolower($this->extensao);
		#~> Renomear
		if($r == 1){
			$novoNome = date("dmY").microtime(true);
			$novoNome = str_replace(".","",$novoNome);			
		    $this->arquivo = $this->pasta.$novoNome.'.'.$this->extensao;			
		}else{
			$this->arquivo = $this->pasta.basename($a["name"]);
		}	
	}
	#~> Define o tamanho limite	
	public function tamanho($t){
		$this->tamanho = $t;
	}
	#~> Define extensões
	public function extensao($e = "imagem"){
		if($e == "imagem"){
			$this->tipoExt = array('jpg','jpeg','gif','png');
		}else if($e == "video"){
			$this->tipoExt = array("mp4","avi","mov");
		}else if($e == "arquivo"){
			$this->tipoExt = array("zip","rar","pdf");
        }else if($e == "documentos"){
			$this->tipoExt = array('jpg','jpeg','gif','png',"pdf");
		}else{
			$this->tipoExt = array($e);
		}
	}
	#~> Testa e Envia arquivo	
	public function upload(){
		#~> Verifica se arquivo existe
		if (file_exists($this->arquivo)) {
			echo "Arquivo já existe!";
			$this->uploadOk = 0;
		}
		#~> Verifica o tamanho do arquivo, limite 1Mb
		if ($this->original["size"] > $this->tamanho * (1024*1024)) {
			echo "Seu arquivo é maior que o permitido!";
			$this->uploadOk = 0;
		}
		#~> Verifica o formato do arquivo
		if(array_search($this->extensao,$this->tipoExt) === FALSE){
			echo "Extensão não permitida!";
			$this->uploadOk = 0;
		}
		
		#~> Verifica se aconteceu algum erro
		if ($this->uploadOk == 0) {
			echo "Seu arquivo não pode ser enviado!";
		#~> Envia o arquivo
		} else {
			if (move_uploaded_file($this->original["tmp_name"], $this->arquivo)) {
				echo "O arquivo: ".basename($this->original["name"])." foi enviado!";
			} else {
				echo "Ocorreu um erro ao enviar o arquivo";
			}
		}
	}
}
?>