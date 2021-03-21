<?php 

/**
 * Acción para visualizar un pacienteobrasocial.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class VerPacienteobrasocialAction extends OutputAction{

	/**
	 * consulta un pacienteobrasocial.
	 */
	protected function getContenido(){
			
		$xtpl = $this->getXTemplate ();
		
		if (isset ( $_GET ['id'] )) {
			$cd_pacienteobrasocial = FormatUtils::getParam('id');
			
			
			try{
				$id = FormatUtils::getParam('id');			
			
				$criterio = new CriterioBusqueda();
				$criterio->addFiltro('cd_pacienteobrasocial', $id, '=');
			
				$manager = new PacienteobrasocialManager();
				$oPacienteobrasocial = $manager->getPacienteobrasocial( $criterio );
				
			}catch(GenericException $ex){
				$oPacienteobrasocial = new Pacienteobrasocial();
				//TODO ver si se muestra un mensaje de error.
			}			

			//se muestra el pacienteobrasocial.
			$this->parseEntidad( $xtpl, $oPacienteobrasocial );
			
			
		}
		
		$xtpl->assign ( 'titulo', 'Detalle de Pacienteobrasocial' );
		$xtpl->parse ( 'main' );
		return $xtpl->text ( 'main' );
	}

	protected function getTitulo(){
		return "Ver Pacienteobrasocial";
	}

	public function getXTemplate(){ 
		return new XTemplate ( RYT_TEMPLATE_VER_PACIENTEOBRASOCIAL );
	}
	
	public function parseEntidad($xtpl, $oPacienteobrasocial){ 

				
		$xtpl->assign ( 'cd_pacienteobrasocial', stripslashes ( $oPacienteobrasocial->getCd_pacienteobrasocial () ) );
		$xtpl->assign ( 'cd_pacienteobrasocial_label', RYT_PACIENTEOBRASOCIAL_CD_PACIENTEOBRASOCIAL );
				
		$xtpl->assign ( 'cd_paciente', stripslashes ( $oPacienteobrasocial->getCd_paciente () ) );
		$xtpl->assign ( 'cd_paciente_label', RYT_PACIENTEOBRASOCIAL_CD_PACIENTE );
				
		$xtpl->assign ( 'cd_obrasocial', stripslashes ( $oPacienteobrasocial->getCd_obrasocial () ) );
		$xtpl->assign ( 'cd_obrasocial_label', RYT_PACIENTEOBRASOCIAL_CD_OBRASOCIAL );
		
		
	}
}
