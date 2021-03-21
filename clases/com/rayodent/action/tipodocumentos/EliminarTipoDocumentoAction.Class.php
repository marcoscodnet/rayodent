<?php

/**
 * Acción para eliminar un tipoDocumento.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class EliminarTipoDocumentoAction extends Action {

    /**
     * se elimina un tipoDocumento.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacción.
        DbManager::begin_tran();

        try {
            
            $manager = new TipoDocumentoManager();
            $manager->eliminarTipoDocumento($id);
            $forward = 'eliminar_tipodocumento_success';
            //commit de la transacción.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_tipodocumento_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacción.
            DbManager::undo();
        }

        return $forward;
    }

}
