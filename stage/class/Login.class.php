<?php
error_reporting(-1);
class Login extends Conexao{
	# Atributos	
	private $u = NULL;
	private $s = NULL;
	private $a = NULL;
    
	# Método construtor	
	public function __construct($u,$s,$a){		
        if($u == "" || $s == "" || $a==""){
            return false;
        }else{
            $this->u = $u;
            $this->s = $s;
            $this->a = $a;
            
            return login();
        }
	}
	
	# Login
	private function login(){
		parent::consultar("SELECT * FROM usuario WHERE usuario = '".$this->u."' AND senha = '".$this->s."' AND app = '".$this->a."'");
        
        if(parent::nResultados() == 1){
            $_SESSION['usuario'] = $this->u;
            return true;
        }else{
            return false;
        }
	}
}
?>






