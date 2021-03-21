<?php

/**
 * Acci�n para eliminar un practicaordenpractica.
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

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            
            $manager = new PracticaordenpracticaManager();
            $manager->eliminarPracticaordenpractica($id);
            $forward = 'eliminar_practicaordenpractica_success';
            //commit de la transacci�n.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_practicaordenpractica_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
