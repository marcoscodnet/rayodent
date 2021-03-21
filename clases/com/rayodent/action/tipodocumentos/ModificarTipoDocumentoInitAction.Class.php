<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipoDocumento.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ModificarTipoDocumentoInitAction extends EditarTipoDocumentoInitAction{

	protected function getEntidad(){
		$oTipoDocumento = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_tipodocumento', $id, '=');
			
			$manager = new TipoDocumentoManager();
			$oTipoDocumento = $manager->getTipoDocumento( $criterio );
			
		}else{
		
			$oTipoDocumento = parent::getEntidad();
		
		}
		return $oTipoDocumento ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Tipo de Documento";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tipodocumento";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
