<?php

/**
 * Acci�n para eliminar un empleado.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class EliminarEmpleadoAction extends Action {

    /**
     * se elimina un empleado.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            
            $manager = new EmpleadoManager();
            $manager->eliminarEmpleado($id);
            $forward = 'eliminar_empleado_success';
            //commit de la transacci�n.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_empleado_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
