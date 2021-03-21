<?php 

/**
 * Acción para inicializar el contexto para editar
 * un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarOrdenpracticaInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_ORDENPRACTICA );		
	}

	
	protected function getEntidad(){
		
		//se construye el ordenpractica a modificar.
		$oOrdenpractica = new Ordenpractica ( );
	
				
		$oOrdenpractica->setCd_ordenpractica ( FormatUtils::getParamPOST('cd_ordenpractica') );	
				
		$oOrdenpractica->setDt_carga ( FormatUtils::getParamPOST('dt_carga') );	
				
		$oOrdenpractica->setCd_turno ( FormatUtils::getParamPOST('cd_turno') );	
				
		$oOrdenpractica->setCd_paciente ( FormatUtils::getParamPOST('cd_paciente') );	
				
		$oOrdenpractica->setCd_profesional ( FormatUtils::getParamPOST('cd_profesional') );	
				
		$oOrdenpractica->setCd_empleado ( FormatUtils::getParamPOST('cd_empleado') );	
				
		$oOrdenpractica->setCd_obrasocialbono ( FormatUtils::getParamPOST('cd_obrasocialbono') );	
				
		$oOrdenpractica->setBl_bono ( FormatUtils::getParamPOST('bl_bono') );	
				
		$oOrdenpractica->setNu_importebono ( FormatUtils::getParamPOST('nu_importebono') );	
				
		$oOrdenpractica->setNu_reciboreintegro ( FormatUtils::getParamPOST('nu_reciboreintegro') );	
		
		
		return $oOrdenpractica;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oOrdenpractica = FormatUtils::ifEmpty($entidad, new Ordenpractica());

				
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
