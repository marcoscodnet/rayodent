<?php 

/**
 * Acción para visualizar un tipoPersonal.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class VerTipoPersonalAction extends OutputAction{

	/**
	 * consulta un tipoPersonal.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_tipoPersonal = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_tipopersonal', $id, '=');
			
				$manager = new TipoPersonalManager();
				$oTipoPersonal = $manager->getTipoPersonal( $criterio );
				
			}catch(GenericException $ex){
				$oTipoPersonal = new TipoPersonal();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el tipoPersonal.
			$this->parseEntidad( $xtpl, $oTipoPersonal );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de TipoPersonal' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Tipo de personal";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_TIPOPERSONAL );
	}
	
	public function parseEntidad($xtpl, $oTipoPersonal){ 

				
		$xtpl->assign ( 'cd_tipopersonal', stripslashes ( $oTipoPersonal->getCd_tipopersonal () ) );
		$xtpl->assign ( 'cd_tipopersonal_label', RYT_TIPOPERSONAL_CD_TIPOPERSONAL );
				
		$xtpl->assign ( 'ds_tipopersonal', stripslashes ( $oTipoPersonal->getDs_tipopersonal () ) );
		$xtpl->assign ( 'ds_tipopersonal_label', RYT_TIPOPERSONAL_DS_TIPOPERSONAL );
		
		
	}
}
