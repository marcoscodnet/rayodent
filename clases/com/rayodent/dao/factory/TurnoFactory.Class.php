<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */ 
class TurnoFactory extends GenericFactory{ 

	public function build($next) { 
		$this->setClassName('Turno');
		$oTurno = parent::build($next);
		
		 //TODO foreign keys 
		 
		return $oTurno;
	}
} 
?>
