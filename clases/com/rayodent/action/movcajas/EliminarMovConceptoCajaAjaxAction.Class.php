<?php

class EliminarMovConceptoCajaAjaxAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $selecteds = array();
        $key = FormatUtils::getParam('k');
        $key = $key - 1;

        if (isset($_SESSION['movcajaconceptos_session'])) {
            $movcajaconceptos_tmp = $_SESSION['movcajaconceptos_session'];
        } else {
            $movcajaconceptos_tmp = new ItemCollection();
        }
        $movcajaconceptos_tmp->removeItemByKey($key);
        $_SESSION['movcajaconceptos_session'] = $movcajaconceptos_tmp;
        $this->parseRespuestaAjax($movcajaconceptos_tmp);
    }

    function parseRespuestaAjax($itemcollection) {
        $xtpl = $this->getXTemplateAjax();
        $coeficiente = 1;
        $total = 0;
        foreach ($itemcollection as $key => $item) {
            $cd_concepto = $item->getObjectByIndex('cd_concepto');
            if ($cd_concepto != "") {
                $conceptoManager = new ConceptoManager();
                $criterio = new CriterioBusqueda();
                $criterio->addFiltro("cd_concepto", $cd_concepto, "=");
                $oConcepto = $conceptoManager->getConcepto($criterio);
                $xtpl->assign('ds_tipoconcepto', utf8_encode($oConcepto->getTipoconcepto()->getDs_tipoconcepto()));
                $xtpl->assign('ds_concepto', utf8_encode($oConcepto->getDs_concepto()));
                $cd_tipooperacion = $oConcepto->getTipooperacion()->getCd_tipooperacion();
                $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                $oConcepto = $conceptoManager->getConcepto($criterio);
            } else {
                $tipoconceptoManager = new TipoconceptoManager();
                $cd_tipoconcepto = $item->getObjectByIndex('cd_tipoconcepto');
                $criterio = new CriterioBusqueda();
                $criterio->addFiltro("cd_tipoconcepto", $cd_tipoconcepto, "=");
                $oTipoconcepto = $tipoconceptoManager->getTipoconcepto($criterio);
                $xtpl->assign('ds_tipoconcepto', utf8_encode($oTipoconcepto->getDs_tipoconcepto()));
            }
            $xtpl->assign('cd_tipoconcepto', utf8_encode($item->getObjectByIndex('cd_tipoconcepto')));
            $xtpl->assign('ds_practica', utf8_encode($item->getObjectByIndex('nu_practicaos')));
            $xtpl->assign('ds_obrasocial', utf8_encode($item->getObjectByIndex('ds_obrasocial')));
            $xtpl->assign('nu_importe', "$ " . utf8_encode($item->getObjectByIndex('nu_importe') * $coeficiente));
        	if ($item->getObjectByIndex('cd_tipoconcepto') != CD_TIPO_CONCEPTO_PRACTICA || ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA && $item->getObjectByIndex('cd_obrasocial') == CD_OBRASOCIAL_PARTICULAR)) {
                    $total += $item->getObjectByIndex('nu_importe') * $coeficiente;
                }
            $xtpl->assign('key', $key + 1);
            $xtpl->parse('main.movscajas_conceptos');
        }
        $xtpl->assign('nu_total', $total);
        $xtpl->parse('main');
        echo $xtpl->text('main');
    }

    protected function getXTemplateAjax() {
        return new XTemplate(RYT_TEMPLATE_TABLE_MOVCAJACONCEPTOS);
    }

    protected function getCoeficiente($cd_tipooperacion) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

}
