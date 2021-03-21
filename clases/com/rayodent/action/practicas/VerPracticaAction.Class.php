<?php 

/**
 * Acción para visualizar un practica.
 *  
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class VerPracticaAction extends OutputAction{

	/**
	 * consulta un practica.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_practica = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_practica', $id, '=');
			
				$manager = new PracticaManager();
				$oPractica = $manager->getPractica( $criterio );
				
			}catch(GenericException $ex){
				$oPractica = new Practica();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el practica.
			$this->parseEntidad( $xtpl, $oPractica );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Pr&aacute;ctica' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Practica";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_PRACTICA );
	}
	
	public function parseEntidad($xtpl, $oPractica){ 

				
		$xtpl->assign ( 'cd_practica', stripslashes ( $oPractica->getCd_practica () ) );
		$xtpl->assign ( 'cd_practica_label', RYT_PRACTICA_CD_PRACTICA );
				
		$xtpl->assign ( 'ds_practica', stripslashes ( $oPractica->getDs_practica () ) );
		$xtpl->assign ( 'ds_practica_label', RYT_PRACTICA_DS_PRACTICA );
		
		
	}
}
