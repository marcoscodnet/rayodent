<?php

/**
 * Acción para eliminar un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class EliminarMovcajaAction extends Action {

    /**
     * se elimina un movcaja.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new MovcajaManager();
            $manager->eliminarMovcaja($id);
            $forward = 'eliminar_movcaja_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_movcaja_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
