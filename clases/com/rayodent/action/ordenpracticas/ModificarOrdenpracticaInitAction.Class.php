<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un ordenpractica.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarOrdenpracticaInitAction extends EditarOrdenpracticaInitAction{

	protected function getEntidad(){
		$oOrdenpractica = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_ordenpractica', $id, '=');
			
			$manager = new OrdenpracticaManager();
			$oOrdenpractica = $manager->getOrdenpractica( $criterio );
			
		}else{
		
			$oOrdenpractica = parent::getEntidad();
		
		}
		return $oOrdenpractica ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Ordenpractica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_ordenpractica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
