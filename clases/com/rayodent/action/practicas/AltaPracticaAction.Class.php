<?php

/**
 * Acción para dar de alta un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaPracticaAction extends EditarPracticaAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $practicaManager = new PracticaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("ds_practica", urldecode($oEntidad->getDs_practica()), "LIKE", new FormatValorString());
        $cant = $practicaManager->getCantPracticas($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe una práctica con la descripción ingresada.";
        }

        if ($validar) {
            $manager = new PracticaManager();
            $manager->agregarPractica($oEntidad);
            return 'alta_practica_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_practica_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_practica_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_practica_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_practica_init';
    }

}
