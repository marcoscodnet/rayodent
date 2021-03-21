<?php 

/**
 * Acción para visualizar un obrasocial.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class VerObrasocialAction extends OutputAction{

	/**
	 * consulta un obrasocial.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_obrasocial = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_obrasocial', $id, '=');
			
				$manager = new ObrasocialManager();
				$oObrasocial = $manager->getObrasocial( $criterio );
				
			}catch(GenericException $ex){
				$oObrasocial = new Obrasocial();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el obrasocial.
			$this->parseEntidad( $xtpl, $oObrasocial );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Obra social' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Obra social";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_OBRASOCIAL );
	}
	
	public function parseEntidad($xtpl, $oObrasocial){ 

				
		$xtpl->assign ( 'cd_obrasocial', stripslashes ( $oObrasocial->getCd_obrasocial () ) );
		$xtpl->assign ( 'cd_obrasocial_label', RYT_OBRASOCIAL_CD_OBRASOCIAL );
				
		$xtpl->assign ( 'ds_obrasocial', stripslashes ( $oObrasocial->getDs_obrasocial () ) );
		$xtpl->assign ( 'ds_obrasocial_label', RYT_OBRASOCIAL_DS_OBRASOCIAL );
		
		
	}
}
