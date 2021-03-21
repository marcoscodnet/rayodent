<?php

/**
 * Acción para dar de alta un tipooperacion.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class AltaTipooperacionAction extends EditarTipooperacionAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $tipooperacionManager = new TipooperacionManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_tipooperacion", $oEntidad->getDs_tipooperacion(), "LIKE", new FormatValorString());
        $cant = $tipooperacionManager->getCantTipooperaciones($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe un tipo de operación con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new TipooperacionManager();
            $manager->agregarTipooperacion($oEntidad);
            return 'alta_tipooperacion_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_tipooperacion_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_tipooperacion_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_tipooperacion_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_tipooperacion_init';
    }

}
