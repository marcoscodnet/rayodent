<?php

/**
 * Acción para eliminar un tipooperacion.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class EliminarTipooperacionAction extends Action {

    /**
     * se elimina un tipooperacion.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        $validar = true;
        $conceptoManager = new ConceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("C.cd_tipooperacion", $id, "=");
        $cant = $conceptoManager->getCantConceptos($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: No se puede eliminar el tipo de operación porque está relacionado a un concepto.";
        }

        if ($validar) {
            $manager = new TipooperacionManager();
            $manager->eliminarTipooperacion($id);
            return 'eliminar_tipooperacion_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'eliminar_tipooperacion_error';
        }
    }

}
