<?php 

/**
 * Acción para inicializar el contexto para editar
 * un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
abstract class EditarPacienteobrasocialInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_PACIENTEOBRASOCIAL );		
	}

	
	protected function getEntidad(){
		
		//se construye el pacienteobrasocial a modificar.
		$oPacienteobrasocial = new Pacienteobrasocial ( );
	
				
		$oPacienteobrasocial->setCd_pacienteobrasocial ( FormatUtils::getParamPOST('cd_pacienteobrasocial') );	
				
		$oPacienteobrasocial->setCd_paciente ( FormatUtils::getParamPOST('cd_paciente') );	
				
		$oPacienteobrasocial->setCd_obrasocial ( FormatUtils::getParamPOST('cd_obrasocial') );	
		
		
		return $oPacienteobrasocial;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oPacienteobrasocial = FormatUtils::ifEmpty($entidad, new Pacienteobrasocial());

				
		$xtpl->assign ( 'cd_pacienteobrasocial', stripslashes ( $oPacienteobrasocial->getCd_pacienteobrasocial () ) );
		$xtpl->assign ( 'cd_pacienteobrasocial_label', RYT_PACIENTEOBRASOCIAL_CD_PACIENTEOBRASOCIAL );
		
		
		
		$xtpl->assign ( 'cd_paciente_label', RYT_PACIENTEOBRASOCIAL_CD_PACIENTE );
		$selected =  $oPacienteobrasocial->getCd_paciente();
		$this->parsePaciente($selected, $xtpl );
		
		$xtpl->assign ( 'cd_obrasocial_label', RYT_PACIENTEOBRASOCIAL_CD_OBRASOCIAL );
		$selected =  $oPacienteobrasocial->getCd_obrasocial();
		$this->parseObrasocial($selected, $xtpl );
		
		

	}

	
	protected function parsePaciente($selected, XTemplate $xtpl ){
	
		$manager = new PacienteManager();
		$criterio = new CriterioBusqueda();
		$pacientes = $manager->getPacientes( $criterio );
		
		foreach($pacientes as $key => $oPaciente) {
		
			$xtpl->assign ( 'ds_paciente', $oPaciente->getCd_paciente() );
			$xtpl->assign ( 'cd_paciente', FormatUtils::selected($oPaciente->getCd_paciente(), $selected ) );
			
			$xtpl->parse ( 'main.pacientes_option' );
		}	
	}
	
	protected function parseObrasocial($selected, XTemplate $xtpl ){
	
		$manager = new ObrasocialManager();
		$criterio = new CriterioBusqueda();
		$obrasocials = $manager->getObrasocials( $criterio );
		
		foreach($obrasocials as $key => $oObrasocial) {
		
			$xtpl->assign ( 'ds_obrasocial', $oObrasocial->getCd_obrasocial() );
			$xtpl->assign ( 'cd_obrasocial', FormatUtils::selected($oObrasocial->getCd_obrasocial(), $selected ) );
			
			$xtpl->parse ( 'main.obrasocials_option' );
		}	
	}
	

}
