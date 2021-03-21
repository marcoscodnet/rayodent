<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipoPersonal.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ModificarTipoPersonalInitAction extends EditarTipoPersonalInitAction{

	protected function getEntidad(){
		$oTipoPersonal = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_tipopersonal', $id, '=');
			
			$manager = new TipoPersonalManager();
			$oTipoPersonal = $manager->getTipoPersonal( $criterio );
			
		}else{
		
			$oTipoPersonal = parent::getEntidad();
		
		}
		return $oTipoPersonal ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar tipo de personal";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tipopersonal";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
