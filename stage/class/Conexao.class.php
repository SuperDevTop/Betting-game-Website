<?php
class Conexao extends Dados{
	# Atributos	
	private $conexao = NULL;
	private $query = NULL;	
	# Método construtor	
	public function __construct(){		
		$this->conectar();		
	}	
	# Outros Metodos
	
	# Conectar
	private function conectar(){
		#~> Conexão com o servidor
		$this->conexao = mysqli_connect(parent::$h, parent::$u, parent::$s) or die("");
		#~> Conexao com o banco
		mysqli_select_db($this->conexao,parent::$b) or die("");
		#~> Setando UTF8
		mysqli_query($this->conexao, "SET NAMES 'utf8'");
		mysqli_query($this->conexao, 'SET character_set_connection=utf8');
		mysqli_query($this->conexao, 'SET character_set_client=utf8');
		mysqli_query($this->conexao, 'SET character_set_results=utf8');	
	}
	# Consultar
	public function consultar($query){
		#~> Envia SQL
		$this->query = mysqli_query($this->conexao, $query);
		return $this->query;
	}	
	# Escrever
	public function escrever($tipo="array"){
		if($tipo=="array"){
			return mysqli_fetch_array($this->query);
		}else if($tipo=="assoc"){
			return mysqli_fetch_assoc($this->query);
		}else if($tipo=="object"){
			return mysqli_fetch_object($this->query);
		}	
	}	
	# Ultimo ID
	public function ultimoId(){
		return mysqli_insert_id($this->conexao);
	}
	# Numero de resultados
	public function nResultados(){	
		return mysqli_num_rows($this->query);
	}
	# Listar array
	public function listarArray(){ var_dump($this->query); }
	# Fechar
	public function fechar(){ mysqli_close($this->conexao);	}
}
?>