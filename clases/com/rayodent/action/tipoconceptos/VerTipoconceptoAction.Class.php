<?php 

/**
 * Acción para visualizar un tipoconcepto.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class VerTipoconceptoAction extends OutputAction{

	/**
	 * consulta un tipoconcepto.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_tipoconcepto = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_tipoconcepto', $id, '=');
			
				$manager = new TipoconceptoManager();
				$oTipoconcepto = $manager->getTipoconcepto( $criterio );
				
			}catch(GenericException $ex){
				$oTipoconcepto = new Tipoconcepto();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el tipoconcepto.
			$this->parseEntidad( $xtpl, $oTipoconcepto );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle Tipo de concepto' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Tipo de concepto";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_TIPOCONCEPTO );
	}
	
	public function parseEntidad($xtpl, $oTipoconcepto){ 

				
		$xtpl->assign ( 'cd_tipoconcepto', stripslashes ( $oTipoconcepto->getCd_tipoconcepto () ) );
		$xtpl->assign ( 'cd_tipoconcepto_label', RYT_TIPOCONCEPTO_CD_TIPOCONCEPTO );
				
		$xtpl->assign ( 'ds_tipoconcepto', stripslashes ( $oTipoconcepto->getDs_tipoconcepto () ) );
		$xtpl->assign ( 'ds_tipoconcepto_label', RYT_TIPOCONCEPTO_DS_TIPOCONCEPTO );
		
		
	}
}
