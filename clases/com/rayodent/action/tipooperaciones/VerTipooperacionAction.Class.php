<?php 

/**
 * Acción para visualizar un tipooperacion.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class VerTipooperacionAction extends OutputAction{

	/**
	 * consulta un tipooperacion.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_tipooperacion = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_tipooperacion', $id, '=');
			
				$manager = new TipooperacionManager();
				$oTipooperacion = $manager->getTipooperacion( $criterio );
				
			}catch(GenericException $ex){
				$oTipooperacion = new Tipooperacion();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el tipooperacion.
			$this->parseEntidad( $xtpl, $oTipooperacion );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Tipo de operacion' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Tipo de operacion";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_TIPOOPERACION );
	}
	
	public function parseEntidad($xtpl, $oTipooperacion){ 

				
		$xtpl->assign ( 'cd_tipooperacion', stripslashes ( $oTipooperacion->getCd_tipooperacion () ) );
		$xtpl->assign ( 'cd_tipooperacion_label', RYT_TIPOOPERACION_CD_TIPOOPERACION );
				
		$xtpl->assign ( 'ds_tipooperacion', stripslashes ( $oTipooperacion->getDs_tipooperacion () ) );
		$xtpl->assign ( 'ds_tipooperacion_label', RYT_TIPOOPERACION_DS_TIPOOPERACION );
		
		
	}
}
