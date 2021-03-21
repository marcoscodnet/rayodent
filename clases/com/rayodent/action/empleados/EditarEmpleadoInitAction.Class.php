<?php 

/**
 * Acción para inicializar el contexto para editar
 * un empleado.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarEmpleadoInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_EMPLEADO );		
	}

	
	protected function getEntidad(){
		
		//se construye el empleado a modificar.
		$oEmpleado = new Empleado ( );
	
				
		$oEmpleado->setCd_empleado ( FormatUtils::getParamPOST('cd_empleado') );	
				
		$oEmpleado->setCd_tipodocumento ( FormatUtils::getParamPOST('cd_tipodocumento') );	
				
		$oEmpleado->setNu_documento ( FormatUtils::getParamPOST('nu_documento') );	
				
		$oEmpleado->setDs_nombre ( FormatUtils::getParamPOST('ds_nombre') );	
				
		$oEmpleado->setCd_tipopersonal ( FormatUtils::getParamPOST('cd_tipopersonal') );	
				
		$oEmpleado->setDs_domicilio ( FormatUtils::getParamPOST('ds_domicilio') );	
				
		$oEmpleado->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );	
				
		$oEmpleado->setDs_email ( FormatUtils::getParamPOST('ds_email') );	
		
		
		return $oEmpleado;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oEmpleado = FormatUtils::ifEmpty($entidad, new Empleado());

				
		$xtpl->assign ( 'cd_empleado', stripslashes ( $oEmpleado->getCd_empleado () ) );
		$xtpl->assign ( 'cd_empleado_label', RYT_EMPLEADO_CD_EMPLEADO );
				
		$xtpl->assign ( 'nu_documento', stripslashes ( $oEmpleado->getNu_documento () ) );
		$xtpl->assign ( 'nu_documento_label', RYT_EMPLEADO_NU_DOCUMENTO );
				
		$xtpl->assign ( 'ds_nombre', stripslashes ( $oEmpleado->getDs_nombre () ) );
		$xtpl->assign ( 'ds_nombre_label', RYT_EMPLEADO_DS_NOMBRE );
				
		$xtpl->assign ( 'ds_domicilio', stripslashes ( $oEmpleado->getDs_domicilio () ) );
		$xtpl->assign ( 'ds_domicilio_label', RYT_EMPLEADO_DS_DOMICILIO );
				
		$xtpl->assign ( 'ds_telefono', stripslashes ( $oEmpleado->getDs_telefono () ) );
		$xtpl->assign ( 'ds_telefono_label', RYT_EMPLEADO_DS_TELEFONO );
				
		$xtpl->assign ( 'ds_email', stripslashes ( $oEmpleado->getDs_email () ) );
		$xtpl->assign ( 'ds_email_label', RYT_EMPLEADO_DS_EMAIL );
		
		
		
		$xtpl->assign ( 'cd_tipodocumento_label', RYT_EMPLEADO_CD_TIPODOCUMENTO );
		$selected =  $oEmpleado->getCd_tipodocumento();
		$this->parseTipoDocumento($selected, $xtpl );
		
		$xtpl->assign ( 'cd_tipopersonal_label', RYT_EMPLEADO_CD_TIPOPERSONAL );
		$selected =  $oEmpleado->getCd_tipopersonal();
		$this->parseTipoPersonal($selected, $xtpl );
		
		

	}

	
	protected function parseTipoDocumento($selected, XTemplate $xtpl ){
	
		$manager = new TipoDocumentoManager();
		$criterio = new CriterioBusqueda();
		$tipodocumentos = $manager->getTipoDocumentos( $criterio );
		
		foreach($tipodocumentos as $key => $oTipoDocumento) {
		
			$xtpl->assign ( 'ds_tipoDocumento', $oTipoDocumento->getDs_tipodocumento() );
			$xtpl->assign ( 'cd_tipoDocumento', FormatUtils::selected($oTipoDocumento->getCd_tipodocumento(), $selected ) );
			
			$xtpl->parse ( 'main.tipodocumentos_option' );
		}	
	}
	
	protected function parseTipoPersonal($selected, XTemplate $xtpl ){
	
		$manager = new TipoPersonalManager();
		$criterio = new CriterioBusqueda();
		$tipopersonales = $manager->getTipoPersonales( $criterio );
		
		foreach($tipopersonales as $key => $oTipoPersonal) {
		
			$xtpl->assign ( 'ds_tipoPersonal', $oTipoPersonal->getDs_tipopersonal() );
			$xtpl->assign ( 'cd_tipoPersonal', FormatUtils::selected($oTipoPersonal->getCd_tipopersonal(), $selected ) );
			
			$xtpl->parse ( 'main.tipopersonales_option' );
		}	
	}
	

}
