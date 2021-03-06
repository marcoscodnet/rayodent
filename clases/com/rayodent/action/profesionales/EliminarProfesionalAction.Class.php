<?php

/**
 * Acción para eliminar un profesional.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class EliminarProfesionalAction extends Action {

    /**
     * se elimina un profesional.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new ProfesionalManager();
            $manager->eliminarProfesional($id);
            $forward = 'eliminar_profesional_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_profesional_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
