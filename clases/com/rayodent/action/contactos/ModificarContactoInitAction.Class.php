<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un contacto.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ModificarContactoInitAction extends EditarContactoInitAction{

	protected function getEntidad(){
		$oContacto = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_contacto', $id, '=');
			
			$manager = new ContactoManager();
			$oContacto = $manager->getContacto( $criterio );
			
		}else{
		
			$oContacto = parent::getEntidad();
		
		}
		return $oContacto ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Contacto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_contacto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
