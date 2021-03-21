<?php

/**
 * Acción para editar un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarPracticaobrasocialAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
     */
    protected function getEntidad() {

        //se construye el practicaobrasocial a modificar.
        $oPracticaobrasocial = new Practicaobrasocial ( );

        $oPracticaobrasocial->setCd_practicaobrasocial(FormatUtils::getParamPOST('cd_practicaobrasocial'));
        $oPracticaobrasocial->setCd_practica(FormatUtils::getParamPOST('cd_practica'));
        $oPracticaobrasocial->setCd_obrasocial(FormatUtils::getParamPOST('cd_obrasocial'));
        $oPracticaobrasocial->setNu_practicaos(FormatUtils::getParamPOST('nu_practicaos'));
        $oPracticaobrasocial->setNu_limiterepeticiones(FormatUtils::getParamPOST('nu_limiterepeticiones', null, false));
        if (isset($_POST['nu_limiterepeticiones']) && ($_POST['nu_limiterepeticiones'] != "")) {
            $oPracticaobrasocial->setNu_limiterepeticiones(addslashes($_POST['nu_limiterepeticiones']));
        } else {
            $oPracticaobrasocial->setNu_limiterepeticiones(null);
        }
        $oPracticaobrasocial->setNu_importe(FormatUtils::getParamPOST('nu_importe'));
        $oPracticaobrasocial->setDt_vigencia(FuncionesComunes::fechaPHPaMysql(FormatUtils::getParamPOST('dt_vigencia')));

        return $oPracticaobrasocial;
    }

}
