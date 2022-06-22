<?php 
class Email {

	public $de ="";
	public $para ="";
	public $resposta ="";
	public $assunto ="";
	public $mensagem ="";
	public $cabecalho ="";
	public $envio = "";
	public $status = "";

	public function __construct() {

	}

	public function setDe($x) {
	  $this->de = $x;
	}
	public function setPara($x) {
	  $this->para = $x;
	}
	public function setResposta($x) {
	  $this->resposta = $x;
	}
	public function setAssunto($x) {
	  $this->assunto = $x;
	}
	public function setMensagem($x) {
	  $this->mensagem = $x;
	}

	public function cabecalho() {
	  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		  $this->cabecalho = "MIME-Version: 1.1\r\n";
		  $this->cabecalho.= "Content-type: text/html; charset=utf-8\r\n";
		  $this->cabecalho.= "From: ". $this->de ."\r\n";
		  $this->cabecalho.= "Return-Path: ". $this->resposta ."\r\n";
	  } else {
		  $this->cabecalho = "MIME-Version: 1.1\n";
		  $this->cabecalho.= "Content-type: text/html; charset=utf-8\n";
		  $this->cabecalho.= "From: ". $this->de ."\n";
		  $this->cabecalho.= "Return-Path: ". $this->resposta ."\n";
	  }

	}
	public function enviar() {
	  $this->cabecalho();
	  $this->envio = mail($this->para, $this->assunto, $this->mensagem, $this->cabecalho);
	  if($this->envio){
		$this->status = "Enviado!";
		return true;
	  }else{
		$this->status = "Erro ao Enviar!";
		return false;
	  }
	}
}
?>				