<?php

/**
 * Acción para eliminar un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class EliminarPracticaobrasocialAction extends Action {

    /**
     * se elimina un practicaobrasocial.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new PracticaobrasocialManager();
            $manager->eliminarPracticaobrasocial($id);
            $forward = 'eliminar_practicaobrasocial_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_practicaobrasocial_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
