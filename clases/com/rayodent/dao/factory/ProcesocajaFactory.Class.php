<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */ 
class ProcesocajaFactory extends GenericFactory{ 

	public function build($next) { 
		$this->setClassName('Procesocaja');
		$oProcesocaja = parent::build($next);
		
		 //TODO foreign keys 
		 
		return $oProcesocaja;
	}
} 
?>