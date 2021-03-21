<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaObrasocialInitAction extends EditarObrasocialInitAction{

	
	protected function getEntidad(){
		
		if ( ( FormatUtils::getParamPOST('ds_obrasocial') )) {
			$oObrasocial = parent::getEntidad();
			
		}else{
		
			$oObrasocial = new Obrasocial ( );
	
				
			$oObrasocial->setBl_activa ( 1);	
		
		}
		return $oObrasocial ;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Obra Social";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_obrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
