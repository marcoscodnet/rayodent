<?php

class CargarCamposTipoConceptoBonoAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $xtpl = $this->getXTemplate();

        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);
        $xtpl->assign('bl_tarjeta_label', RYT_MOVCAJA_BL_TARJETA);
        $xtpl->assign('ds_obrasocial_label', RYT_MOVCAJA_DS_OBRASOCIAL);        
        $xtpl->parse('main');
        $text = $xtpl->text('main');
        echo $text;
        return $text;
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_DATOS_TIPO_CONCEPTO_BONO);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
