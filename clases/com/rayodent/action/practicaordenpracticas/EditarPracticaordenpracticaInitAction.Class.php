<?php

/**
 * Acción para inicializar el contexto para editar
 * un practicaordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarPracticaordenpracticaInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_PRACTICAORDENPRACTICA);
    }

    protected function getEntidad() {

        //se construye el practicaordenpractica a modificar.
        $oPracticaordenpractica = new Practicaordenpractica ( );


        $oPracticaordenpractica->setCd_practicaordenpractica(FormatUtils::getParamPOST('cd_practicaordenpractica'));

        $oPracticaordenpractica->setCd_practicaobrasocial(FormatUtils::getParamPOST('cd_practicaobrasocial'));

        $oPracticaordenpractica->setCd_ordenpractica(FormatUtils::getParamPOST('cd_ordenpractica'));

        $oPracticaordenpractica->setNu_cantplacas(FormatUtils::getParamPOST('nu_cantplacas'));

        $oPracticaordenpractica->setNu_repeticiones(FormatUtils::getParamPOST('nu_repeticiones'));

        $oPracticaordenpractica->setCd_informe(FormatUtils::getParamPOST('cd_informe'));

        $oPracticaordenpractica->setCd_movcajaconcepto(FormatUtils::getParamPOST('cd_movcajaconcepto'));


        return $oPracticaordenpractica;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oPracticaordenpractica = FormatUtils::ifEmpty($entidad, new Practicaordenpractica());


        $xtpl->assign('cd_practicaordenpractica', stripslashes($oPracticaordenpractica->getCd_practicaordenpractica()));

        $xtpl->assign('cd_practica_label', RYT_PRACTICAORDENPRACTICA_CD_PRACTICA);
        $xtpl->assign('ds_practica', $entidad->getPracticaobrasocial()->getPractica()->getDs_practica());
        $xtpl->assign('ds_obrasocial', $entidad->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial());
        $xtpl->assign('cd_obrasocial_label', RYT_PRACTICAORDENPRACTICA_CD_OBRASOCIAL);

        $xtpl->assign('cd_practicaobrasocial', stripslashes($oPracticaordenpractica->getCd_practicaobrasocial()));
        $xtpl->assign('cd_practicaobrasocial_label', RYT_PRACTICAORDENPRACTICA_CD_PRACTICAOBRASOCIAL);

        $xtpl->assign('cd_ordenpractica', stripslashes($oPracticaordenpractica->getCd_ordenpractica()));
        $xtpl->assign('cd_ordenpractica_label', RYT_PRACTICAORDENPRACTICA_CD_ORDENPRACTICA);
        $xtpl->assign('nu_cantplacas', stripslashes($oPracticaordenpractica->getNu_cantplacas()));
        $xtpl->assign('nu_cantplacas_label', RYT_PRACTICAORDENPRACTICA_NU_CANTPLACAS);
        $xtpl->assign('nu_repeticiones', stripslashes($oPracticaordenpractica->getNu_repeticiones()));
        $xtpl->assign('nu_repeticiones_label', RYT_PRACTICAORDENPRACTICA_NU_REPETICIONES);
        $xtpl->assign('cd_informe', stripslashes($oPracticaordenpractica->getCd_informe()));
        $xtpl->assign('cd_informe_label', RYT_PRACTICAORDENPRACTICA_CD_INFORME);
        $xtpl->assign('cd_movcajaconcepto', stripslashes($oPracticaordenpractica->getCd_movcajaconcepto()));
        $xtpl->assign('cd_movcajaconcepto_label', RYT_PRACTICAORDENPRACTICA_CD_MOVCAJACONCEPTO);
        $this->parseInforme($entidad->getInforme(), $xtpl);
    }

    protected function parseInforme($entidad, $xtpl) {
        $oInforme = FormatUtils::ifEmpty($entidad, new Informe());

        $xtpl->assign('cd_informe', stripslashes($oInforme->getCd_informe()));
        $xtpl->assign('cd_informe_label', RYT_INFORME_CD_INFORME);

        $xtpl->assign('ds_apynom', stripslashes($oInforme->getDs_apynom()));
        $xtpl->assign('ds_apynom_label', RYT_INFORME_DS_APYNOM);

        $xtpl->assign('ds_profesional', stripslashes($oInforme->getDs_profesional()));
        $xtpl->assign('ds_profesional_label', RYT_INFORME_DS_PROFESIONAL);

        $xtpl->assign('ds_estudiorx', stripslashes($oInforme->getDs_estudiorx()));
        $xtpl->assign('ds_estudiorx_label', RYT_INFORME_DS_ESTUDIORX);

        $xtpl->assign('ds_informe', stripslashes($oInforme->getDs_informe()));
        $xtpl->assign('ds_informe_label', RYT_INFORME_DS_INFORME);
    }

}
