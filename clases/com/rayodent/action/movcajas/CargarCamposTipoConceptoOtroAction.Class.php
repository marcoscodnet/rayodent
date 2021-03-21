<?php

class CargarCamposTipoConceptoOtroAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $xtpl = $this->getXTemplate();

        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);
        $xtpl->assign('bl_tarjeta_label', RYT_MOVCAJA_BL_TARJETA);
        $xtpl->parse('main');
        $text = $xtpl->text('main');
        echo $text;
        return $text;
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_DATOS_TIPO_CONCEPTO_OTRO);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
