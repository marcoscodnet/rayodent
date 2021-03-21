<?php

/**
 * Acción para inicializar el contexto para editar
 * un concepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarConceptoInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_CONCEPTO);
    }

    protected function getEntidad() {

        //se construye el concepto a modificar.
        $oConcepto = new Concepto ( );


        $oConcepto->setCd_concepto(FormatUtils::getParamPOST('cd_concepto'));

        $oConcepto->setCd_tipoconcepto(FormatUtils::getParamPOST('cd_tipoconcepto'));

        $oConcepto->setCd_tipooperacion(FormatUtils::getParamPOST('cd_tipooperacion'));

        $oConcepto->setDs_concepto(FormatUtils::getParamPOST('ds_concepto'));


        return $oConcepto;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oConcepto = FormatUtils::ifEmpty($entidad, new Concepto());


        $xtpl->assign('cd_concepto', stripslashes($oConcepto->getCd_concepto()));
        $xtpl->assign('cd_concepto_label', RYT_CONCEPTO_CD_CONCEPTO);

        $xtpl->assign('ds_concepto', stripslashes($oConcepto->getDs_concepto()));
        $xtpl->assign('ds_concepto_label', RYT_CONCEPTO_DS_CONCEPTO);



        $xtpl->assign('cd_tipoconcepto_label', RYT_CONCEPTO_CD_TIPOCONCEPTO);
        $selected = $oConcepto->getCd_tipoconcepto();
        $xtpl->assign('cd_tipoconcepto_ok', stripslashes($oConcepto->getCd_tipoconcepto()));
        $this->parseTipoconcepto($selected, $xtpl);

        $xtpl->assign('cd_tipooperacion_label', RYT_CONCEPTO_CD_TIPOOPERACION);
        $selected = $oConcepto->getCd_tipooperacion();
        $xtpl->assign('cd_tipooperacion_ok', stripslashes($selected));
        $this->parseTipooperacion($selected, $xtpl);
    }

    protected function parseTipoconcepto($selected, XTemplate $xtpl) {

        $manager = new TipoconceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("bl_oculto", 0, "=");
        $tipoconceptos = $manager->getTipoconceptos($criterio);

        foreach ($tipoconceptos as $key => $oTipoconcepto) {

            $xtpl->assign('ds_tipoconcepto', $oTipoconcepto->getDs_tipoconcepto());
            $xtpl->assign('cd_tipoconcepto', FormatUtils::selected($oTipoconcepto->getCd_tipoconcepto(), $selected));

            $xtpl->parse('main.tipoconceptos_option');
        }
    }

    protected function parseTipooperacion($selected, XTemplate $xtpl) {

        $manager = new TipooperacionManager();
        $criterio = new CriterioBusqueda();
        $tipooperaciones = $manager->getTipooperaciones($criterio);

        foreach ($tipooperaciones as $key => $oTipooperacion) {

            $xtpl->assign('ds_tipooperacion', $oTipooperacion->getDs_tipooperacion());
            $xtpl->assign('cd_tipooperacion', FormatUtils::selected($oTipooperacion->getCd_tipooperacion(), $selected));

            $xtpl->parse('main.tipooperaciones_option');
        }
    }

}
