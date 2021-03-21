<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un practicaobrasocial.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarVigenciasypreciosInitAction extends EditarVigenciasypreciosInitAction{

	protected function getEntidad(){
		$oPracticaobrasocial = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_practicaobrasocial', $id, '=');
			
			$manager = new PracticaobrasocialManager();
			$oPracticaobrasocial = $manager->getPracticaobrasocial( $criterio );
			
		}else{
		
			$oPracticaobrasocial = parent::getEntidad();
		
		}
		return $oPracticaobrasocial ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Vigencias y precios";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_vigenciasyprecios";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
