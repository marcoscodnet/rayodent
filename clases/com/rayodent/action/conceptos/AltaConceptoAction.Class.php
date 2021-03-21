<?php

/**
 * Acción para dar de alta un concepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class AltaConceptoAction extends EditarConceptoAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        //primero valido que no se haya dado de alta ya, una tupla para ese Tipo concepto y Tipo operaciï¿½n
        $conceptoManager = new ConceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("C.ds_concepto", $oEntidad->getDs_concepto(), "LIKE", new FormatValorString());
        $cant = $conceptoManager->getCantConceptos($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe un concepto con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new ConceptoManager();
            $manager->agregarConcepto($oEntidad);
            return 'alta_concepto_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_concepto_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_concepto_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_concepto_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_concepto_init';
    }

}
