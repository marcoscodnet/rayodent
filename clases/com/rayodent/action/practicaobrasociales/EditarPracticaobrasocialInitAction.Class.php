<?php

/**
 * Acción para inicializar el contexto para editar
 * un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarPracticaobrasocialInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_PRACTICAOBRASOCIAL);
    }

    protected function getEntidad() {

        //se construye el practicaobrasocial a modificar.
        $oPracticaobrasocial = new Practicaobrasocial ( );


        $oPracticaobrasocial->setCd_practicaobrasocial(FormatUtils::getParamPOST('cd_practicaobrasocial'));

        $oPracticaobrasocial->setCd_practica(FormatUtils::getParamPOST('cd_practica'));

        $oPracticaobrasocial->setCd_obrasocial(FormatUtils::getParamPOST('cd_obrasocial'));

        $oPracticaobrasocial->setNu_practicaos(FormatUtils::getParamPOST('nu_practicaos'));

        $oPracticaobrasocial->setNu_importe(FormatUtils::getParamPOST('nu_importe'));

        $oPracticaobrasocial->setDt_vigencia(FormatUtils::getParamPOST('dt_vigencia'));


        return $oPracticaobrasocial;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oPracticaobrasocial = FormatUtils::ifEmpty($entidad, new Practicaobrasocial());


        $xtpl->assign('cd_practicaobrasocial', stripslashes($oPracticaobrasocial->getCd_practicaobrasocial()));
        $xtpl->assign('cd_practicaobrasocial_label', RYT_PRACTICAOBRASOCIAL_CD_PRACTICAOBRASOCIAL);

        $xtpl->assign('nu_practicaos', stripslashes($oPracticaobrasocial->getNu_practicaos()));
        $xtpl->assign('nu_practicaos_label', RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS);

        $xtpl->assign('nu_limiterepeticiones', stripslashes($oPracticaobrasocial->getNu_limiterepeticiones()));
        $xtpl->assign('nu_limiterepeticiones_label', RYT_PRACTICAOBRASOCIAL_NU_LIMITEREPETICIONES);

        $xtpl->assign('nu_importe', stripslashes($oPracticaobrasocial->getNu_importe()));
        $xtpl->assign('nu_importe_label', RYT_PRACTICAOBRASOCIAL_NU_IMPORTE);

        if ($oPracticaobrasocial->getDt_vigencia() == "") {
            $xtpl->assign('dt_vigencia', "");
        } else {
            $xtpl->assign('dt_vigencia', FuncionesComunes:: fechaMysqlaPHP(stripslashes($oPracticaobrasocial->getDt_vigencia())));
        }
        $xtpl->assign('dt_vigencia_label', RYT_PRACTICAOBRASOCIAL_DT_VIGENCIA);


        $xtpl->assign('cd_practica_label', RYT_PRACTICAOBRASOCIAL_CD_PRACTICA);
        $selected = $oPracticaobrasocial->getCd_practica();
        $this->parsePractica($selected, $xtpl);

        $xtpl->assign('cd_obrasocial_label', RYT_PRACTICAOBRASOCIAL_CD_OBRASOCIAL);
        $selected = $oPracticaobrasocial->getCd_obrasocial();
        $this->parseObrasocial($selected, $xtpl);
    }

    protected function parsePractica($selected, XTemplate $xtpl) {

        $manager = new PracticaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("bl_activa", 1, "=");
        $criterio->addOrden("ds_practica");
        $practicas = $manager->getPracticas($criterio);

        foreach ($practicas as $key => $oPractica) {

            $xtpl->assign('ds_practica', $oPractica->getDs_practica());
            $xtpl->assign('cd_practica', FormatUtils::selected($oPractica->getCd_practica(), $selected));

            $xtpl->parse('main.practicas_option');
        }
    }

    protected function parseObrasocial($selected, XTemplate $xtpl) {

        $manager = new ObrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("bl_activa", 1, "=");
        $criterio->addOrden("ds_obrasocial");
        $obrasociales = $manager->getObrasociales($criterio);

        foreach ($obrasociales as $key => $oObrasocial) {

            $xtpl->assign('ds_obrasocial', $oObrasocial->getDs_obrasocial());
            $xtpl->assign('cd_obrasocial', FormatUtils::selected($oObrasocial->getCd_obrasocial(), $selected));

            $xtpl->parse('main.obrasociales_option');
        }
    }

}
