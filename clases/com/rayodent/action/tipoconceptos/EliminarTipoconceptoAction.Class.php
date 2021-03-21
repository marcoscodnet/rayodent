<?php

/**
 * Acción para eliminar un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class EliminarTipoconceptoAction extends Action {

    /**
     * se elimina un tipoconcepto.
     */
    public function execute() {
        $validar = true;
        $id = FormatUtils::getParam('id');
        $conceptoManager = new ConceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("C.cd_tipoconcepto", $id, "=");
        $cant = $conceptoManager->getCantConceptos($criterio);
        if ($cant > 0 || $id == CD_TIPO_CONCEPTO_PRACTICA || $id == CD_TIPO_CONCEPTO_BONO || $id == CD_TIPO_CONCEPTO_REINTEGRO) {
            $validar = false;
            $msg = "Error: No se puede eliminar el tipo de concepto porque está relacionado a un concepto.";
        }

        if ($validar) {
            $manager = new TipoconceptoManager();
            $manager->eliminarTipoconcepto($id);
            return 'eliminar_tipoconcepto_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'eliminar_tipoconcepto_error';
        }
    }

}
