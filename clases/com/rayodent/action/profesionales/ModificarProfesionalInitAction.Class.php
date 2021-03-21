<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un profesional.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ModificarProfesionalInitAction extends EditarProfesionalInitAction{

	protected function getEntidad(){
		$oProfesional = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_profesional', $id, '=');
			
			$manager = new ProfesionalManager();
			$oProfesional = $manager->getProfesional( $criterio );
			
		}else{
		
			$oProfesional = parent::getEntidad();
		
		}
		return $oProfesional ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Profesional";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_profesional";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
