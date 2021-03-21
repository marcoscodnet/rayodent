<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un practicaordenpractica.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarPracticaordenpracticaInitAction extends EditarPracticaordenpracticaInitAction{

	protected function getEntidad(){
		$oPracticaordenpractica = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_practicaordenpractica', $id, '=');
			
			$manager = new PracticaordenpracticaManager();
			$oPracticaordenpractica = $manager->getPracticaordenpractica( $criterio );
			
		}else{
		
			$oPracticaordenpractica = parent::getEntidad();
		
		}
		return $oPracticaordenpractica ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Cargar repeticiones e informe";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_practicaordenpractica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
