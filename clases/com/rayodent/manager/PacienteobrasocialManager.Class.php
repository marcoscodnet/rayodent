<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011 
 */ 
class PacienteobrasocialManager implements IListar{ 

	public function agregarPacienteobrasocial(Pacienteobrasocial $oPacienteobrasocial) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		PacienteobrasocialDAO::insertarPacienteobrasocial($oPacienteobrasocial);
	}


	public function modificarPacienteobrasocial(Pacienteobrasocial $oPacienteobrasocial) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		PacienteobrasocialDAO::modificarPacienteobrasocial($oPacienteobrasocial);
	}


	public static function eliminarPacienteobrasocial($id) { 
		//TODO validaciones; 

		$oPacienteobrasocial = new Pacienteobrasocial();
		$oPacienteobrasocial->setCd_pacienteobrasocial($id);
		PacienteobrasocialDAO::eliminarPacienteobrasocial($oPacienteobrasocial);
	}


	public function getPacientesobrasociales(CriterioBusqueda $criterio) { 
		return PacienteobrasocialDAO::getPacientesobrasociales($criterio); 
	}


	public function getCantPacientesobrasociales(CriterioBusqueda $criterio) { 
		return PacienteobrasocialDAO::getCantPacientesobrasociales($criterio); 
	}


	public function getPacienteobrasocial(CriterioBusqueda $criterio) { 
		return PacienteobrasocialDAO::getPacienteobrasocial($criterio); 
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getPacientesobrasociales($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantPacientesobrasociales($criterio); 
	}


} 
?>
