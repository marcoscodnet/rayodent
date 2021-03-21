<?php

/**
 * Acción para eliminar un paciente.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class EliminarPacienteAction extends Action {

    /**
     * se elimina un paciente.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            //Primero elimino las obras sociales del paciente
            $pacienteObrasocialManager = new PacienteobrasocialManager();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("cd_paciente", $id, "=");
            $pacientesobrassociales = $pacienteObrasocialManager->getPacientesobrasociales($criterio);
            foreach ($pacientesobrassociales as $key => $oPacienteObrasocial) {
                $pacienteObrasocialManager->eliminarPacienteobrasocial($oPacienteObrasocial->getCd_pacienteobrasocial());
            }

            //Luego, elimino el paciente
            $manager = new PacienteManager();
            $manager->eliminarPaciente($id);


            $forward = 'eliminar_paciente_success';
            //commit de la transacción.
            DbManager::save();
        } catch (GenericException $ex) {
            $forward = 'eliminar_paciente_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
