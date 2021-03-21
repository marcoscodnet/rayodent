<?php

/**
 * Acci�n para eliminar un movcaja.
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

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            
            $manager = new MovcajaManager();
            $manager->eliminarMovcaja($id);
            $forward = 'eliminar_movcaja_success';
            //commit de la transacci�n.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_movcaja_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
