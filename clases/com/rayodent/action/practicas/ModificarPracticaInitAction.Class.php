<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un practica.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarPracticaInitAction extends EditarPracticaInitAction{

	protected function getEntidad(){
		$oPractica = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_practica', $id, '=');
			
			$manager = new PracticaManager();
			$oPractica = $manager->getPractica( $criterio );
			
		}else{
		
			$oPractica = parent::getEntidad();
		
		}
		return $oPractica ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Practica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_practica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
