<?php

/**
 * Acción para eliminar un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class EliminarPracticaAction extends Action {

    /**
     * se elimina un practica.
     */
    public function execute() {
        $id = FormatUtils::getParam('id');

        $validar = true;
        $practicaobrasocialManager = new PracticaobrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("PO.cd_practica", $id, "=");
        $cant = $practicaobrasocialManager->getCantPracticaobrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: No se puede eliminar la práctica porque está asociado a una obra social.";
        }

        if ($validar) {
            $manager = new PracticaManager();
            $manager->eliminarPractica($id);
            return 'eliminar_practica_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'eliminar_practica_error';
        }
    }

}
