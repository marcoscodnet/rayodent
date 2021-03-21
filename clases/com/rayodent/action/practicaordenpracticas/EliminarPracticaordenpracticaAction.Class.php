<?php

/**
 * Acción para eliminar un practicaordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class EliminarPracticaordenpracticaAction extends Action {

    /**
     * se elimina un practicaordenpractica.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new PracticaordenpracticaManager();
            $manager->eliminarPracticaordenpractica($id);
            $forward = 'eliminar_practicaordenpractica_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_practicaordenpractica_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
