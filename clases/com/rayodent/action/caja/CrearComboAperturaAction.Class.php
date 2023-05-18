<?php

class CrearComboAperturaAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {

        //print_r(FormatUtils::getParam('nu_caja',0));
        $nu_caja = FormatUtils::getParam('nu_caja',0);
        $cd_movcaja = FormatUtils::getParam('cd_movcaja');


        $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));
        $xtpl = $this->getXTemplate();
        //if ($nu_caja!='') {
            $movcajaManager = new MovcajaManager();
            $movimientos = $movcajaManager->dameProceso($nu_caja, $dt_inicio_filtro, 11);

            //print_r($movimientos);


            foreach ($movimientos as $key => $oMovimiento) {
                $xtpl->assign('cd_movcaja', FormatUtils::selected($oMovimiento->getCd_movcaja(), $cd_movcaja));
                $fechayhora = FuncionesComunes::fechaHoraMysqlaPHP($oMovimiento->getDt_movcaja());
                $fechayhora = explode(" ", $fechayhora);

                $hs = substr($fechayhora[1], 0, 5);
                $xtpl->assign('ds_movcaja', $hs);
                $xtpl->parse('main.aperturas_option');
            }
        //}



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
