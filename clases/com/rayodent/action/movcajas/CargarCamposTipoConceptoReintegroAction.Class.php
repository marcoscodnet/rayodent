<?php

class CargarCamposTipoConceptoReintegroAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $xtpl = $this->getXTemplate();
		//echo $_GET['cd_concepto'];
		if (($_GET['cd_concepto']==1)||($_GET['cd_concepto']==116)) {
			$orden_practica = '<tr>
        <td align="right" style="width:208px;">'.RYT_MOVCAJA_ORDEN_PRACTICAS.':</td>
        <td align="left">
            <input type="hidden" name="cd_ordenpractica" id="cd_ordenpractica" size="40" value="" jVal="{valid:function (val) { return requerido(val,\'Ingrese un valor\'); }}" readonly/>
            <input type="text" name="ds_ordenpractica" id="ds_ordenpractica" size="40" value="" jVal="{valid:function (val) { return requerido(val,\'Ingrese un valor\'); }}" readonly/>
            <a href="#" onClick="abrir_busquedaOrdenpractica(\'doAction?action=buscar_orden_practica\');"><img src="css/desktop/images/search.gif" alt="Buscar Obra Social"></a>
        </td>
    </tr>';
			$xtpl->assign('orden_practica', $orden_practica);
			if ($_GET['cd_concepto']==1) {
				$recibo_reintegro = ' <tr>
        <td align="right">'.RYT_MOVCAJA_NU_RECIBOREINTEGRO.'*:</td>
        <td align="left">
            <input type="text" name="nu_reciboreintegro" id="nu_reciboreintegro" size="15" value="" jVal="{valid:function (val) { return requerido(val,\'Ingrese un valor\'); }}"/>
        </td>
    </tr>';
			$xtpl->assign('recibo_reintegro', $recibo_reintegro);
			}
			
		}
        
        $xtpl->assign('nu_importe_label', RYT_MOVCAJA_NU_IMPORTE);
        $xtpl->assign('bl_tarjeta_label', RYT_MOVCAJA_BL_TARJETA);
        
        $xtpl->parse('main');
        echo $xtpl->text('main');
    }

    function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_DATOS_TIPO_CONCEPTO_REINTEGRO);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
