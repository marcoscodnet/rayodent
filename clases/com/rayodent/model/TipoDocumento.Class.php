<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011
 */ 
class TipoDocumento { 
	
	//variables de instancia.
	
	private $cd_tipodocumento;
	
	private $ds_tipodocumento;
	

	//Constructor.
	public function TipoDocumento() { 
		//TODO inicializar variables.
		
		
		$this->cd_tipodocumento = '';
		
		$this->ds_tipodocumento = '';
		
		
	}

	//Getters	
		
	public function getCd_tipodocumento() { 
		return $this->cd_tipodocumento;
	}
		
	public function getDs_tipodocumento() { 
		return $this->ds_tipodocumento;
	}
	
	

	//Setters
	
	public function setCd_tipodocumento( $value ) { 
		$this->cd_tipodocumento = $value;
	}
	
	public function setDs_tipodocumento( $value ) { 
		$this->ds_tipodocumento = $value;
	}
	
	
} 
?>
