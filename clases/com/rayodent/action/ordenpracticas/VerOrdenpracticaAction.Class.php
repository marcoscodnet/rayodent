<?php 

/**
 * Acción para visualizar un ordenpractica.
 *  
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class VerOrdenpracticaAction extends OutputAction{

	/**
	 * consulta un ordenpractica.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_ordenpractica = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_ordenpractica', $id, '=');
			
				$manager = new OrdenpracticaManager();
				$oOrdenpractica = $manager->getOrdenpractica( $criterio );
				
			}catch(GenericException $ex){
				$oOrdenpractica = new Ordenpractica();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el ordenpractica.
			$this->parseEntidad( $xtpl, $oOrdenpractica );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Ordenpractica' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Ordenpractica";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_ORDENPRACTICA );
	}
	
	public function parseEntidad($xtpl, $oOrdenpractica){ 

				
		$xtpl->assign ( 'cd_ordenpractica', stripslashes ( $oOrdenpractica->getCd_ordenpractica () ) );
		$xtpl->assign ( 'cd_ordenpractica_label', RYT_ORDENPRACTICA_CD_ORDENPRACTICA );
				
		$xtpl->assign ( 'dt_carga', stripslashes ( $oOrdenpractica->getDt_carga () ) );
		$xtpl->assign ( 'dt_carga_label', RYT_ORDENPRACTICA_DT_CARGA );
				
		$xtpl->assign ( 'cd_turno', stripslashes ( $oOrdenpractica->getCd_turno () ) );
		$xtpl->assign ( 'cd_turno_label', RYT_ORDENPRACTICA_CD_TURNO );
				
		$xtpl->assign ( 'cd_paciente', stripslashes ( $oOrdenpractica->getCd_paciente () ) );
		$xtpl->assign ( 'cd_paciente_label', RYT_ORDENPRACTICA_CD_PACIENTE );
				
		$xtpl->assign ( 'cd_profesional', stripslashes ( $oOrdenpractica->getCd_profesional () ) );
		$xtpl->assign ( 'cd_profesional_label', RYT_ORDENPRACTICA_CD_PROFESIONAL );
				
		$xtpl->assign ( 'cd_empleado', stripslashes ( $oOrdenpractica->getCd_empleado () ) );
		$xtpl->assign ( 'cd_empleado_label', RYT_ORDENPRACTICA_CD_EMPLEADO );
				
		$xtpl->assign ( 'cd_obrasocialbono', stripslashes ( $oOrdenpractica->getCd_obrasocialbono () ) );
		$xtpl->assign ( 'cd_obrasocialbono_label', RYT_ORDENPRACTICA_CD_OBRASOCIALBONO );
				
		$xtpl->assign ( 'bl_bono', stripslashes ( $oOrdenpractica->getBl_bono () ) );
		$xtpl->assign ( 'bl_bono_label', RYT_ORDENPRACTICA_BL_BONO );
				
		$xtpl->assign ( 'nu_importebono', stripslashes ( $oOrdenpractica->getNu_importebono () ) );
		$xtpl->assign ( 'nu_importebono_label', RYT_ORDENPRACTICA_NU_IMPORTEBONO );
				
		$xtpl->assign ( 'nu_reciboreintegro', stripslashes ( $oOrdenpractica->getNu_reciboreintegro () ) );
		$xtpl->assign ( 'nu_reciboreintegro_label', RYT_ORDENPRACTICA_NU_RECIBOREINTEGRO );
		
		
	}
}
