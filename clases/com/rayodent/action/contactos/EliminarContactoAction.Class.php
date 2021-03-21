<?php

/**
 * Acci�n para eliminar un contacto.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class EliminarContactoAction extends Action {

    /**
     * se elimina un contacto.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            

            //Luego, elimino el contacto
            $manager = new ContactoManager();
            $manager->eliminarContacto($id);


            $forward = 'eliminar_contacto_success';
            //commit de la transacci�n.
            DbManager::save();
        } catch (GenericException $ex) {
            $forward = 'eliminar_contacto_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
