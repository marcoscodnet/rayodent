<?php

/**
 * Acción para visualizar un concepto.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class VerConceptoAction extends OutputAction {

    /**
     * consulta un concepto.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_concepto = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_concepto', $id, '=');

                $manager = new ConceptoManager();
                $oConcepto = $manager->getConcepto($criterio);
            } catch (GenericException $ex) {
                $oConcepto = new Concepto();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el concepto.
            $this->parseEntidad($xtpl, $oConcepto);
        }

        $xtpl->assign('titulo', 'Detalle de Concepto');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Concepto";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_CONCEPTO);
    }

    public function parseEntidad($xtpl, $oConcepto) {

        $xtpl->assign('cd_concepto', stripslashes($oConcepto->getCd_concepto()));
        $xtpl->assign('cd_concepto_label', RYT_CONCEPTO_CD_CONCEPTO);

        $xtpl->assign('ds_tipoconcepto', stripslashes($oConcepto->getTipoconcepto()->getDs_tipoconcepto()));
        $xtpl->assign('cd_tipoconcepto_label', RYT_CONCEPTO_CD_TIPOCONCEPTO);

        $xtpl->assign('ds_tipooperacion', stripslashes($oConcepto->getTipooperacion()->getDs_tipooperacion()));
        $xtpl->assign('cd_tipooperacion_label', RYT_CONCEPTO_CD_TIPOOPERACION);

        $xtpl->assign('ds_concepto', stripslashes($oConcepto->getDs_concepto()));
        $xtpl->assign('ds_concepto_label', RYT_CONCEPTO_DS_CONCEPTO);
    }

}
