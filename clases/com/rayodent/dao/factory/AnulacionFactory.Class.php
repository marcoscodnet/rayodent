<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */ 
class AnulacionFactory extends GenericFactory{ 

	public function build($next) { 
		$this->setClassName('Anulacion');
		$oAnulacion = parent::build($next);
		
		 //TODO foreign keys 
		 
		return $oAnulacion;
	}
} 
?>
