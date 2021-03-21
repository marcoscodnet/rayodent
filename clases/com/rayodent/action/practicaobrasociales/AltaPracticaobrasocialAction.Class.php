<?php

/**
 * Acción para dar de alta un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaPracticaobrasocialAction extends EditarPracticaobrasocialAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;

        //primero valido que no se haya dado de alta ya, una tupla para esa práctica y esa obra social
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("PO.cd_practica", $oEntidad->getCd_practica(), "=");
        $criterio->addFiltro("PO.cd_obrasocial", $oEntidad->getCd_obrasocial(), "=");
        $practicaobrasocialManager = new PracticaobrasocialManager();
        $cant = $practicaobrasocialManager->getCantPracticaobrasociales($criterio);
        if ($cant > 0) {
            $validar = false;
            $msg = "Error: Ya existe nomenclador para la práctica y la obra social elegida. Puede cambiar la cotizacion desde la opción vigencias y precios.";
        }

        if ($validar) {
            $manager = new PracticaobrasocialManager();
            $manager->agregarPracticaobrasocial($oEntidad);

            /*
            //recupero todas las ï¿½rdenes de practicas mayores o iguales a la nueva fecha de vigencia
            $criterio_movcaja = new CriterioBusqueda();
            $criterio_movcaja->addFiltro("dt_carga", $oEntidad->getDt_vigencia(), ">");
            //descarto las anuladas
            $criterio_movcaja->addFiltro("bl_anulacion", "0", "=");
            $practicaordenpManager = new PracticaordenpracticaManager();
            $practicasOrdenesPracticas = $practicaordenpManager->getPracticaordenpracticas($criterio_movcaja);
            foreach ($practicasOrdenesPracticas as $oPracticaOrdenPractica) {
                //actualizo el cd_practica obrasocial
                $oPracticaOrdenPractica->setCd_practicaobrasocial($oEntidad->getCd_practicaobrasocial());
                $practicaordenpManager->modificarPracticaordenpractica($oPracticaOrdenPractica);
            }*/
            return 'alta_practicaobrasocial_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'alta_practicaobrasocial_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_practicaobrasocial_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_practicaobrasocial_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_practicaobrasocial_init';
    }

}
