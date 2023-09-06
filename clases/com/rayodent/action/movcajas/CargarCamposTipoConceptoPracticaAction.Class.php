<?php

class CargarCamposTipoConceptoPracticaAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $xtpl = $this->getXTemplate();

        $xtpl->assign('nu_placas_label', RYT_MOVCAJA_NU_PLACAS);
        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);
        $xtpl->assign('bl_tarjeta_label', RYT_MOVCAJA_BL_TARJETA);
        $xtpl->assign('bl_digital_label', RYT_MOVCAJA_BL_DIGITAL);
        $xtpl->assign('ds_obrasocial_label', RYT_MOVCAJA_DS_OBRASOCIAL);
        $xtpl->assign('ds_practica_label', RYT_MOVCAJA_DS_PRACTICA);
        $xtpl->assign('ds_aporte_label', RYT_MOVCAJA_DS_APORTE);
        $xtpl->assign('checked_o', "checked");
		$xtpl->assign('ds_pieza_label', RYT_MOVCAJA_DS_PIEZA);	
        
        $xtpl->parse('main');
        echo $xtpl->text('main');
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_DATOS_TIPO_CONCEPTO_PRACTICA);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
