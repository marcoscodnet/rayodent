<?php 

/**
 * Acción para visualizar un tipoDocumento.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class VerTipoDocumentoAction extends OutputAction{

	/**
	 * consulta un tipoDocumento.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_tipoDocumento = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_tipodocumento', $id, '=');
			
				$manager = new TipoDocumentoManager();
				$oTipoDocumento = $manager->getTipoDocumento( $criterio );
				
			}catch(GenericException $ex){
				$oTipoDocumento = new TipoDocumento();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el tipoDocumento.
			$this->parseEntidad( $xtpl, $oTipoDocumento );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Tipo de Documento' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Tipo de Documento";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_TIPODOCUMENTO );
	}
	
	public function parseEntidad($xtpl, $oTipoDocumento){ 

				
		$xtpl->assign ( 'cd_tipodocumento', stripslashes ( $oTipoDocumento->getCd_tipodocumento () ) );
		$xtpl->assign ( 'cd_tipodocumento_label', RYT_TIPODOCUMENTO_CD_TIPODOCUMENTO );
				
		$xtpl->assign ( 'ds_tipodocumento', stripslashes ( $oTipoDocumento->getDs_tipodocumento () ) );
		$xtpl->assign ( 'ds_tipodocumento_label', RYT_TIPODOCUMENTO_DS_TIPODOCUMENTO );
		
		
	}
}
