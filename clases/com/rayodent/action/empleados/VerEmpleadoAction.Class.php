<?php 

/**
 * Acción para visualizar un empleado.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class VerEmpleadoAction extends OutputAction{

	/**
	 * consulta un empleado.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_empleado = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_empleado', $id, '=');
			
				$manager = new EmpleadoManager();
				$oEmpleado = $manager->getEmpleado( $criterio );
				
			}catch(GenericException $ex){
				$oEmpleado = new Empleado();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el empleado.
			$this->parseEntidad( $xtpl, $oEmpleado );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Empleado' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Empleado";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_EMPLEADO );
	}
	
	public function parseEntidad($xtpl, $oEmpleado){ 
				
		$xtpl->assign ( 'cd_empleado', stripslashes ( $oEmpleado->getCd_empleado () ) );
		$xtpl->assign ( 'cd_empleado_label', RYT_EMPLEADO_CD_EMPLEADO );
				
		$xtpl->assign ( 'ds_tipodocumento', stripslashes ( $oEmpleado->getTipoDocumento()->getDs_tipodocumento () ) );
		$xtpl->assign ( 'cd_tipodocumento_label', RYT_EMPLEADO_CD_TIPODOCUMENTO );
				
		$xtpl->assign ( 'nu_documento', stripslashes ( $oEmpleado->getNu_documento () ) );
		$xtpl->assign ( 'nu_documento_label', RYT_EMPLEADO_NU_DOCUMENTO );
				
		$xtpl->assign ( 'ds_nombre', stripslashes ( $oEmpleado->getDs_nombre () ) );
		$xtpl->assign ( 'ds_nombre_label', RYT_EMPLEADO_DS_NOMBRE );
				
		$xtpl->assign ( 'ds_tipopersonal', stripslashes ( $oEmpleado->getTipoPersonal()->getDs_tipopersonal () ) );
		$xtpl->assign ( 'cd_tipopersonal_label', RYT_EMPLEADO_CD_TIPOPERSONAL );
				
		$xtpl->assign ( 'ds_domicilio', stripslashes ( $oEmpleado->getDs_domicilio () ) );
		$xtpl->assign ( 'ds_domicilio_label', RYT_EMPLEADO_DS_DOMICILIO );
				
		$xtpl->assign ( 'ds_telefono', stripslashes ( $oEmpleado->getDs_telefono () ) );
		$xtpl->assign ( 'ds_telefono_label', RYT_EMPLEADO_DS_TELEFONO );
				
		$xtpl->assign ( 'ds_email', stripslashes ( $oEmpleado->getDs_email () ) );
		$xtpl->assign ( 'ds_email_label', RYT_EMPLEADO_DS_EMAIL );
		
		
	}
}
