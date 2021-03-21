<?php

/**
 * Acción para eliminar un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class EliminarPacienteobrasocialAction extends Action {

    /**
     * se elimina un pacienteobrasocial.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new PacienteobrasocialManager();
            $manager->eliminarPacienteobrasocial($id);
            $forward = 'eliminar_pacienteobrasocial_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_pacienteobrasocial_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
