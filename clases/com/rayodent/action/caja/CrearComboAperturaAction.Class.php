<?php

class CrearComboAperturaAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {


        $nu_caja = FormatUtils::getParam('nu_caja');



        $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));

        $movcajaManager = new MovcajaManager();
        $movimientos = $movcajaManager->dameProceso($nu_caja,$dt_inicio_filtro,11);



        $xtpl = $this->getXTemplate();
        foreach ($movimientos as $key => $oMovimiento) {
            $xtpl->assign('cd_movcaja', $oMovimiento->getCd_movcaja());
            $xtpl->assign('ds_movcaja', $oMovimiento->getCd_movcaja());
            $xtpl->parse('main.apertura_option');
        }



        $xtpl->parse('main');

        echo $xtpl->text('main');
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_COMBO_APERTURA);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
