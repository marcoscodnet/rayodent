<?php

/**
 * Acci�n para eliminar un concepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class EliminarConceptoAction extends Action {

    /**
     * se elimina un concepto.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            
            $manager = new ConceptoManager();
            $manager->eliminarConcepto($id);
            $forward = 'eliminar_concepto_success';
            //commit de la transacci�n.
            DbManager::save();
            
        } catch (GenericException $ex) {
            $forward = 'eliminar_concepto_error';
            $this->setDs_forward_params('er=1' . '&msg=' . $ex->getMessage() . '&code=' . $ex->getCode());
            //rollback de la transacci�n.
            DbManager::undo();
        }

        return $forward;
    }

}
