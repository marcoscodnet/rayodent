<?php

/**
 * Acción para modificar un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarPracticaAction extends EditarPracticaAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $practicaManager = new PracticaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_practica", urldecode($oEntidad->getDs_practica()), "LIKE", new FormatValorString());
        $criterio->addFiltro("cd_practica", $oEntidad->getCd_practica(), "<>");
        $cant = $practicaManager->getCantPracticas($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe una práctica con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new PracticaManager();
            $manager->modificarPractica($oEntidad);
            return 'modificar_practica_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'modificar_practica_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_practica_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_practica_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_practica_init';
    }

}
