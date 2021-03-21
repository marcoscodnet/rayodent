<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaPracticaInitAction extends EditarPracticaInitAction{

	
	protected function getEntidad(){
		
		if ( ( FormatUtils::getParamPOST('ds_practica') )) {
			$oPractica = parent::getEntidad();
			
		}else{
		
			$oPractica = new Practica ( );
	
				
			$oPractica->setBl_activa ( 1);	
		
		}
		return $oPractica ;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Practica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_practica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
