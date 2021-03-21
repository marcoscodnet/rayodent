<?php

/**
 * Acción para editar un practicaordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarPracticaordenpracticaAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
     */
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
        $oPracticaordenpractica->setInforme($this->getEntidadInforme());
        return $oPracticaordenpractica;
    }

    protected function getEntidadInforme() {

        //se construye el informe a modificar.
        $oInforme = new Informe ( );
        $oInforme->setCd_informe(FormatUtils::getParamPOST('cd_informe'));
        $oInforme->setDs_apynom(FormatUtils::getParamPOST('ds_apynom'));
        $oInforme->setDs_profesional(FormatUtils::getParamPOST('ds_profesional'));
        $oInforme->setDs_estudiorx(FormatUtils::getParamPOST('ds_estudiorx'));
        $oInforme->setDs_informe(FormatUtils::getParamPOST('ds_informe'));
        return $oInforme;
    }

}
