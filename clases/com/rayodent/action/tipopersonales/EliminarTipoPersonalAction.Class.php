<?php

/**
 * Acción para eliminar un tipoPersonal.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class EliminarTipoPersonalAction extends Action {

    /**
     * se elimina un tipoPersonal.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new TipoPersonalManager();
            $manager->eliminarTipoPersonal($id);
            $forward = 'eliminar_tipopersonal_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_tipopersonal_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
