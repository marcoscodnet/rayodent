<?php

/**
 * Acción para eliminar un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class EliminarObrasocialAction extends Action {

    /**
     * se elimina un obrasocial.
     */
    public function execute() {

        $id = FormatUtils::getParam('id');

        $validar = true;
        $practicaobrasocialManager = new PracticaobrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("PO.cd_obrasocial", $id, "=");
        $cant = $practicaobrasocialManager->getCantPracticaobrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: No se puede eliminar la obra social porque está asociado a una práctica.";
        }

        $pacienteObrasocialManager = new PacienteobrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_obrasocial", $id, "=");
        $cant = $pacienteObrasocialManager->getCantPacientesobrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: No se puede eliminar la obra social porque estï¿½ asociado a un paciente.";
        }

        if ($validar) {
            $manager = new ObrasocialManager();
            $manager->eliminarObrasocial($id);
            return 'eliminar_obrasocial_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'eliminar_obrasocial_error';
        }
    }

}
