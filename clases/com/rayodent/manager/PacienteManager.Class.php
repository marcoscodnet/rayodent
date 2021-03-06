<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011 
 */
class PacienteManager implements IListar {

    public function agregarPaciente(Paciente $oPaciente) {
        //TODO validaciones;
        $this->ValidateOnInsert($oPaciente);
        //persistir en la bbdd.
        PacienteDAO::insertarPaciente($oPaciente);
        //inserta pacientesobrassociales
        $managerPacienteObrasocial = new PacienteobrasocialManager();
        if (isset($_SESSION['pacientesobrasociales_session'])) {
            foreach ($_SESSION['pacientesobrasociales_session'] as $cd_obrasocial) {
                $oPacienteobrasocial = new Pacienteobrasocial();
                $oPacienteobrasocial->setCd_obrasocial($cd_obrasocial);
                $oPacienteobrasocial->setCd_paciente($oPaciente->getCd_paciente());
                $managerPacienteObrasocial->agregarPacienteobrasocial($oPacienteobrasocial);
            }
            unset($_SESSION['pacientesobrasociales_session']);
        }
    }

    protected function ValidateOnInsert(Paciente $oPaciente) {
        if ($oPaciente->getDs_apynom() == "") {
            throw new GenericException("El campo apellido y nombre es obligatorio.");
        }
        if ($oPaciente->getNu_doc() == "" || $oPaciente->getNu_doc() == 0 || $oPaciente->getNu_doc() == '0') {
            throw new GenericException("El Nro de documento es obligatorio y no puede ser 0.");
        }
        if ($oPaciente->getCd_tipodoc() == "" || $oPaciente->getCd_tipodoc() == 0) {
            throw new GenericException("El campo tipo de documento es obligatorio.");
        }

        //Valido que no haya otr paciente con el mismo dni
        $nu_doc = $oPaciente->getNu_doc();
        $cd_tipodoc = $oPaciente->getCd_tipodoc();
        $cd_paciente = $oPaciente->getCd_paciente();
        $oCriterio = new CriterioBusqueda();
        $oCriterio->addFiltro("P.cd_tipodoc", $cd_tipodoc, "=");
        $oCriterio->addFiltro("P.nu_doc", $nu_doc, "=");
        if (isset($cd_paciente) && ($cd_paciente != "")) {
            $oCriterio->addFiltro("P.cd_paciente", $cd_paciente, "<>");
        }
        $cant = $this->getCantidadEntidades($oCriterio);
        if ($cant > 0) {
            throw new GenericException("El tipo y Nro de documento ya existe para otro paciente");
        }
    }

    public function modificarPaciente(Paciente $oPaciente) {
        //TODO validaciones;
        $this->ValidateOnInsert($oPaciente);
        //persistir en la bbdd.
        PacienteDAO::modificarPaciente($oPaciente);

        //Recupero las obras sociales anteriores
        $manager = new PacienteobrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_paciente", $oPaciente->getCd_paciente(), "=");
        $pacientesobrassociales_old = $manager->getPacientesobrasociales($criterio);

        $managerPacienteObrasocial = new PacienteobrasocialManager();
        if (isset($_SESSION['pacientesobrasociales_session'])) {
            foreach ($_SESSION['pacientesobrasociales_session'] as $cd_obrasocial) {
                if (!$this->yaexistePacienteObrasocial($pacientesobrassociales_old, $cd_obrasocial)) {
                    $oPacienteobrasocial = new Pacienteobrasocial();
                    $oPacienteobrasocial->setCd_obrasocial($cd_obrasocial);
                    $oPacienteobrasocial->setCd_paciente($oPaciente->getCd_paciente());
                    $managerPacienteObrasocial->agregarPacienteobrasocial($oPacienteobrasocial);
                }
            }
        }

        //Elimino los que estaban en la BD, pero no es?n en sesi?n.
        $pacienteObrasocialManager = new PacienteobrasocialManager();
        foreach ($pacientesobrassociales_old as $key => $oPacienteObrasocial) {
            $pacienteObrasocialManager->eliminarPacienteobrasocial($oPacienteObrasocial->getCd_pacienteobrasocial());
        }
    }

    private function yaexistePacienteObrasocial($coleccion, $cd_obrasocial) {
        foreach ($coleccion as $key => $oPacienteObrasocial) {
            if ($oPacienteObrasocial->getCd_obrasocial() == $cd_obrasocial) {
                $coleccion->removeItemByKey($key);
                return true;
            }
        }
        return false;
    }

    public static function eliminarPaciente($id) {
        //TODO validaciones;

        $oPaciente = new Paciente();
        $oPaciente->setCd_paciente($id);
        PacienteDAO::eliminarPaciente($oPaciente);
    }

    public function getPacientes(CriterioBusqueda $criterio) {
        return PacienteDAO::getPacientes($criterio);
    }

    public function getCantPacientes(CriterioBusqueda $criterio) {
        return PacienteDAO::getCantPacientes($criterio);
    }

    public function getPaciente(CriterioBusqueda $criterio) {
        return PacienteDAO::getPaciente($criterio);
    }

    //	interface IListar
    public function getEntidades(CriterioBusqueda $criterio) {
        return $this->getPacientes($criterio);
    }

    public function getCantidadEntidades(CriterioBusqueda $criterio) {
        return $this->getCantPacientes($criterio);
    }

}
?>
