<?php

/**
 * Acci�n para eliminar un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class EliminarMedioAction extends Action {

    /**
     * se elimina un medio.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {

            $manager = new MedioManager();
            $manager->eliminarMedio($id);
            $forward = 'eliminar_medio_success';
            //commit de la transacci�n.
            DbManager::save();

        } catch (GenericException $ex) {
            $forward = 'eliminar_medio_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
