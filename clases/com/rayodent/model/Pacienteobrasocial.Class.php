<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011
 */ 
class Pacienteobrasocial { 
	
	//variables de instancia.
	
	private $cd_pacienteobrasocial;
	
	private $oPaciente;
	
	private $oObrasocial;
	

	//Constructor.
	public function Pacienteobrasocial() { 
		//TODO inicializar variables.
		
		
		$this->cd_pacienteobrasocial = '';
		
		
		$this->oPaciente = new Paciente();
		
		$this->oObrasocial = new Obrasocial();
		
	}

	//Getters	
		
	public function getCd_pacienteobrasocial() { 
		return $this->cd_pacienteobrasocial;
	}
		
	public function getPaciente() { 
		return $this->oPaciente;
	}
		
	public function getObrasocial() { 
		return $this->oObrasocial;
	}
	
		
	public function getCd_paciente() { 
		return $this->oPaciente->getCd_paciente();
	}
		
	public function getCd_obrasocial() { 
		return $this->oObrasocial->getCd_obrasocial();
	}
	

	//Setters
	
	public function setCd_pacienteobrasocial( $value ) { 
		$this->cd_pacienteobrasocial = $value;
	}
	
	public function setPaciente( $value ) { 
		$this->oPaciente = $value;
	}
	
	public function setObrasocial( $value ) { 
		$this->oObrasocial = $value;
	}
	
	
	public function setCd_paciente( $value ) { 
		$this->oPaciente->setCd_paciente( $value );
	}
	
	public function setCd_obrasocial( $value ) { 
		$this->oObrasocial->setCd_obrasocial( $value );
	}
	
} 
?>