<?php

/**
 * Acción para modificar un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ModificarTipoconceptoAction extends EditarTipoconceptoAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $tipoconceptoManager = new TipoconceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_tipoconcepto", $oEntidad->getDs_tipoconcepto(), "LIKE", new FormatValorString());
        $criterio->addFiltro("cd_tipoconcepto", $oEntidad->getCd_tipoconcepto(), "<>");
        $cant = $tipoconceptoManager->getCantTipoconceptos($criterio);
        //var_dump($cant);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe un tipo de concepto con la descripción ingresada.";
        }
        $id = $oEntidad->getCd_tipoconcepto();
        if ($id == CD_TIPO_CONCEPTO_PRACTICA || $id == CD_TIPO_CONCEPTO_BONO || $id == CD_TIPO_CONCEPTO_REINTEGRO) {
            $validar = false;
            $msg = "Error: No se puede modificar el tipo de concepto porque está protegido.";
        }

        if ($validar) {
            $manager = new TipoconceptoManager();
            $manager->modificarTipoconcepto($oEntidad);
            return 'modificar_tipoconcepto_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'modificar_tipoconcepto_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_tipoconcepto_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_tipoconcepto_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_tipoconcepto_init';
    }

}
