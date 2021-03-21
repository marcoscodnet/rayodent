<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un obrasocial.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarObrasocialInitAction extends EditarObrasocialInitAction{

	protected function getEntidad(){
		$oObrasocial = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_obrasocial', $id, '=');
			
			$manager = new ObrasocialManager();
			$oObrasocial = $manager->getObrasocial( $criterio );
			
		}else{
		
			$oObrasocial = parent::getEntidad();
		
		}
		return $oObrasocial ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Obra social";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_obrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
