<?php

/**
 * Acción para dar de alta un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class AltaTipoconceptoAction extends EditarTipoconceptoAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $tipoconceptoManager = new TipoconceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_tipoconcepto", $oEntidad->getDs_tipoconcepto(), "LIKE", new FormatValorString());
        $cant = $tipoconceptoManager->getCantTipoconceptos($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe un tipo de concepto con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new TipoconceptoManager();
            $manager->agregarTipoconcepto($oEntidad);
            return 'alta_tipoconcepto_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_tipoconcepto_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_tipoconcepto_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_tipoconcepto_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_tipoconcepto_init';
    }

}
