<?php 

/**
 * Acción para visualizar un practicaordenpractica.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class VerPracticaordenpracticaAction extends OutputAction{

	/**
	 * consulta un practicaordenpractica.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_practicaordenpractica = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_practicaordenpractica', $id, '=');
			
				$manager = new PracticaordenpracticaManager();
				$oPracticaordenpractica = $manager->getPracticaordenpractica( $criterio );
				
			}catch(GenericException $ex){
				$oPracticaordenpractica = new Practicaordenpractica();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el practicaordenpractica.
			$this->parseEntidad( $xtpl, $oPracticaordenpractica );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Practicaordenpractica' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Practicaordenpractica";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_PRACTICAORDENPRACTICA );
	}
	
	public function parseEntidad($xtpl, $oPracticaordenpractica){ 

				
		$xtpl->assign ( 'cd_practicaordenpractica', stripslashes ( $oPracticaordenpractica->getCd_practicaordenpractica () ) );
		$xtpl->assign ( 'cd_practicaordenpractica_label', RYT_PRACTICAORDENPRACTICA_CD_PRACTICAORDENPRACTICA );
				
		$xtpl->assign ( 'cd_practicaobrasocial', stripslashes ( $oPracticaordenpractica->getCd_practicaobrasocial () ) );
		$xtpl->assign ( 'cd_practicaobrasocial_label', RYT_PRACTICAORDENPRACTICA_CD_PRACTICAOBRASOCIAL );
				
		$xtpl->assign ( 'cd_ordenpractica', stripslashes ( $oPracticaordenpractica->getCd_ordenpractica () ) );
		$xtpl->assign ( 'cd_ordenpractica_label', RYT_PRACTICAORDENPRACTICA_CD_ORDENPRACTICA );
				
		$xtpl->assign ( 'nu_cantplacas', stripslashes ( $oPracticaordenpractica->getNu_cantplacas () ) );
		$xtpl->assign ( 'nu_cantplacas_label', RYT_PRACTICAORDENPRACTICA_NU_CANTPLACAS );
				
		$xtpl->assign ( 'nu_repeticiones', stripslashes ( $oPracticaordenpractica->getNu_repeticiones () ) );
		$xtpl->assign ( 'nu_repeticiones_label', RYT_PRACTICAORDENPRACTICA_NU_REPETICIONES );
				
		$xtpl->assign ( 'cd_informe', stripslashes ( $oPracticaordenpractica->getCd_informe () ) );
		$xtpl->assign ( 'cd_informe_label', RYT_PRACTICAORDENPRACTICA_CD_INFORME );
				
		$xtpl->assign ( 'cd_movcajaconcepto', stripslashes ( $oPracticaordenpractica->getCd_movcajaconcepto () ) );
		$xtpl->assign ( 'cd_movcajaconcepto_label', RYT_PRACTICAORDENPRACTICA_CD_MOVCAJACONCEPTO );
		
		
	}
}
