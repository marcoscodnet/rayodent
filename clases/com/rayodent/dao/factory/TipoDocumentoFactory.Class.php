<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011
 */ 
class TipoDocumentoFactory extends GenericFactory{ 

	public function build($next) { 
		$this->setClassName('TipoDocumento');
		$oTipoDocumento = parent::build($next);
		
		 //TODO foreign keys 
		 
		return $oTipoDocumento;
	}
} 
?>
