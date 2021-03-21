<?php

/**
 * Acción para eliminar un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class EliminarOrdenpracticaAction extends Action {

    /**
     * se elimina un ordenpractica.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new OrdenpracticaManager();
            $manager->eliminarOrdenpractica($id);
            $forward = 'eliminar_ordenpractica_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_ordenpractica_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
