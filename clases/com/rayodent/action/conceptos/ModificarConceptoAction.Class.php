<?php

/**
 * Acción para modificar un concepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ModificarConceptoAction extends EditarConceptoAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("C.ds_concepto", $oEntidad->getDs_concepto(), "LIKE", new FormatValorString());
        $criterio->addFiltro("C.cd_concepto", $oEntidad->getCd_concepto(), "<>");
        $conceptoManager = new ConceptoManager();
        $cant = $conceptoManager->getCantConceptos($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe un concepto con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new ConceptoManager();
            $manager->modificarConcepto($oEntidad);
            return 'modificar_concepto_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'modificar_concepto_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_concepto_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_concepto_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_concepto_init';
    }

}
