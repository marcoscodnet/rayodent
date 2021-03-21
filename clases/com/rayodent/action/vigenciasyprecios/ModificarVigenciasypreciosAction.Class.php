<?php

/**
 * Acción para modificar un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarVigenciasypreciosAction extends EditarVigenciasypreciosAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $validar = true;
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("PO.cd_practica", $oEntidad->getCd_practica(), "=");
        $criterio->addFiltro("PO.cd_obrasocial", $oEntidad->getCd_obrasocial(), "=");
        $criterio->addFiltro('dt_vigencia', "(SELECT MAX(dt_vigencia) FROM practicaobrasocial POS WHERE POS.cd_practica = PO.cd_practica AND POS.cd_obrasocial = PO.cd_obrasocial)", ">=");

//        $criterio->addFiltro("PO.dt_vigencia", $oEntidad->getDt_vigencia(), "<=", new FormatValorString());
        $practicaobrasocialManager = new PracticaobrasocialManager();
        $oPracticaTemp = $practicaobrasocialManager->getPracticaobrasocial($criterio);
        if (!empty($oPracticaTemp) && ($oPracticaTemp->getDt_vigencia() >= $oEntidad->getDt_vigencia())) {
            $validar = false;
            $msg = "No se almacenaron los datos porque la fecha de vigencia debe ser mayor a la Última fecha ingresada.";
        }

        if ($validar) {
            $manager = new PracticaobrasocialManager();
            $manager->agregarPracticaobrasocial($oEntidad);

            //recupero todas las ï¿½rdenes de practicas mayores o iguales a la nueva fecha de vigencia
            //FIXME sólo hay que tomar aquellas prácticas que coinciden con la que se está modificando (practica + obra social).
            $criterio_movcaja = new CriterioBusqueda();
            $criterio_movcaja->addFiltro("dt_carga", $oEntidad->getDt_vigencia(), ">");
            //descarto las anuladas
         
            $practicaordenpManager = new PracticaordenpracticaManager();
            
            /*
            $practicasOrdenesPracticas = $practicaordenpManager->getPracticaordenpracticas($criterio_movcaja);
            foreach ($practicasOrdenesPracticas as $oPracticaOrdenPractica) {
                //actualizo el cd_practica obrasocial
                $oPracticaOrdenPractica->setCd_practicaobrasocial($oEntidad->getCd_practicaobrasocial());
                $practicaordenpManager->modificarPracticaordenpractica($oPracticaOrdenPractica);
            }
            */
            
            $practicaordenpManager->modificarPrecioPracticasObraSocial( $oEntidad );
            
            
            return 'modificar_vigenciasyprecios_success';
        } else {
            $this->setDs_forward_params("er=1&msg=$msg");
            return 'modificar_vigenciasyprecios_error';
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_vigenciasyprecios_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_vigenciasyprecios_error';
    }

    public function getIdEntidad() {
        return FormatUtils::getParamPOST('id');
    }

    protected function getActionForwardFailure() {
        return 'modificar_vigenciasyprecios_init';
    }

}
