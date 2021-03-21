<?php

/**
 * Acción para modificar un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarObrasocialAction extends EditarObrasocialAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $obrasocialManager = new ObrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_obrasocial", urldecode($oEntidad->getDs_obrasocial()), "LIKE", new FormatValorString());
        $criterio->addFiltro("cd_obrasocial", $oEntidad->getCd_obrasocial(), "<>");
        $cant = $obrasocialManager->getCantObrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe una obra social con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new ObrasocialManager();
            $manager->modificarObrasocial($oEntidad);
            return 'modificar_obrasocial_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'modificar_obrasocial_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_obrasocial_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_obrasocial_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_obrasocial_init';
    }

}
