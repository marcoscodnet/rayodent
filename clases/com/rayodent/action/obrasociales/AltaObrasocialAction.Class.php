<?php

/**
 * Acción para dar de alta un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaObrasocialAction extends EditarObrasocialAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $obrasocialManager = new ObrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_obrasocial", urldecode($oEntidad->getDs_obrasocial()), "LIKE", new FormatValorString());
        $cant = $obrasocialManager->getCantObrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe una obra social con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new ObrasocialManager();
            $manager->agregarObrasocial($oEntidad);
            return 'alta_obrasocial_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_obrasocial_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_obrasocial_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_obrasocial_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_obrasocial_init';
    }

}
