<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipoconcepto.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ModificarTipoconceptoInitAction extends EditarTipoconceptoInitAction{

	protected function getEntidad(){
		$oTipoconcepto = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_tipoconcepto', $id, '=');
			
			$manager = new TipoconceptoManager();
			$oTipoconcepto = $manager->getTipoconcepto( $criterio );
			
		}else{
		
			$oTipoconcepto = parent::getEntidad();
		
		}
		return $oTipoconcepto ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Tipo de concepto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tipoconcepto";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
