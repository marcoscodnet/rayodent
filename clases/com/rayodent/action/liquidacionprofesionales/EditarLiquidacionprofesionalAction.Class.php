<?php

/**
 * Acción para editar un liquidacionprofesional.
 * 
 * @author modelBuilder
 * @since 11-01-2012
 * 
 */
abstract class EditarLiquidacionprofesionalAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
     */
    protected function getEntidad() {
        //se construye el liquidacionprofesional a modificar.
        $oLiquidacionprofesional = new Liquidacionprofesional ( );
        $oLiquidacionprofesional->setCd_liquidacionprofesional(FormatUtils::getParam('cd_liquidacionprofesional'));
        //$oLiquidacionprofesional->setCd_movcaja ( FormatUtils::getParam('cd_movcaja') );
        $oLiquidacionprofesional->setCd_profesional(FormatUtils::getParam('cd_profesional'));


        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");

        if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $oLiquidacionprofesional->setDt_desde($dt_inicio_filtro);
        }
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;
            $oLiquidacionprofesional->setDt_hasta($dt_fin_filtro);
        }


        $oLiquidacionprofesional->setNu_valor(FormatUtils::getParam('valor'));
        $oLiquidacionprofesional->setTipo(FormatUtils::getParam('tipo'));      
        
        return $oLiquidacionprofesional;
    }

}
