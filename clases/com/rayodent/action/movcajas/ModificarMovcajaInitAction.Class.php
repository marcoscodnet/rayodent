<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un movcaja.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarMovcajaInitAction extends EditarMovcajaInitAction{

	protected function getEntidad(){
		$oMovcaja = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_movcaja', $id, '=');
			
			$manager = new MovcajaManager();
			$oMovcaja = $manager->getMovcaja( $criterio );
			
		}else{
		
			$oMovcaja = parent::getEntidad();
		
		}
		return $oMovcaja ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Movcaja";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_movcaja";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
	
	
		
}
