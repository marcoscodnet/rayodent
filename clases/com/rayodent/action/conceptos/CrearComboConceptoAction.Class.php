<?php

class CrearComboConceptoAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $criterio = new CriterioBusqueda();
        $tcid = FormatUtils::getParam('tcid');
        $criterio->addFiltro("C.cd_tipoconcepto", $tcid, "=");
        $criterio->addOrden("ds_concepto");
        $managerConcepto = new ConceptoManager();
        $conceptos = $managerConcepto->getConceptos($criterio);
        $xtpl = $this->getXTemplate();
        foreach ($conceptos as $key => $oConcepto) {
            $xtpl->assign('ds_concepto', utf8_encode($oConcepto->getDs_concepto()));
            $xtpl->assign('cd_concepto', FormatUtils::selected($oConcepto->getCd_concepto(), $selected));
            $xtpl->parse('main.conceptos_option');
        }

        $xtpl->assign('cd_concepto_practica_particular', CD_CONCEPTO_PRACTICA_PARTICULAR);
        $xtpl->assign('cd_practica_particular', CD_OBRASOCIAL_PARTICULAR);

        $oObraSocialManager = new ObrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_obrasocial", CD_OBRASOCIAL_PARTICULAR, "=");
        $oObraSocial = $oObraSocialManager->getObrasocial($criterio);
        $xtpl->assign('ds_practica_particular', $oObraSocial->getDs_obrasocial());

        $xtpl->parse('main');

        echo $xtpl->text('main');
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_COMBO_CONCEPTO);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
