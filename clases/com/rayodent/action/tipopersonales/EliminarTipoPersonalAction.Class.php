<?php

/**
 * Acci�n para eliminar un tipoPersonal.
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

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            
            $manager = new TipoPersonalManager();
            $manager->eliminarTipoPersonal($id);
            $forward = 'eliminar_tipopersonal_success';
            //commit de la transacci�n.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_tipopersonal_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
