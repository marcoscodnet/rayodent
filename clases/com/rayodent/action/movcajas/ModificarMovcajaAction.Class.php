<?php 

/**
 * Acción para modificar un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarMovcajaAction extends EditarMovcajaAction{


	
	
	/**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        if (!$this->isAjax()) {
            $manager = new MovcajaManager();
            $manager->modificarMovcaja($oEntidad);
        } else {
            if (isset($_SESSION['movcajaconceptos_session'])) {
                $itemcollection = $_SESSION['movcajaconceptos_session'];
            } else {
                $itemcollection = new ItemCollection();
            }
            if ($this->camposObligatoriosCompletos($oEntidad)) {
                $itemcollection->addItem($oEntidad);
            }
            $_SESSION['movcajaconceptos_session'] = $itemcollection;
            $this->parseRespuestaAjax($itemcollection);
        }
    }
    
	function camposObligatoriosCompletos($oEntidad) {

        if (($oEntidad->getObjectByIndex('cd_tipoconcepto') == null)) {
            return false;
        }
		//Si es prï¿½ctica, es obligatorio: medico, paciente, personal, tipoconcepto, concepto, practica, importe
        /*if (($oEntidad->getObjectByIndex('cd_tipoconcepto') != "") && ($oEntidad->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA)) {
            if (($oEntidad->getObjectByIndex('cd_profesional') != "") && ($oEntidad->getObjectByIndex('cd_paciente') != "") && ($oEntidad->getObjectByIndex('cd_empleado') != "")) {
                if (($oEntidad->getObjectByIndex('cd_concepto') != "") && ($oEntidad->getObjectByIndex('cd_practicaobrasocial') != "") && ($oEntidad->getObjectByIndex('nu_importe') != "")) {
                    return true;
                }
            }
        }*/
    	if (($oEntidad->getObjectByIndex('cd_tipoconcepto') != "") && ($oEntidad->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA)) {
            if (($oEntidad->getObjectByIndex('cd_profesional') != "") && ($oEntidad->getObjectByIndex('cd_paciente') != "")) {
                if (($oEntidad->getObjectByIndex('cd_concepto') != "") && ($oEntidad->getObjectByIndex('cd_practicaobrasocial') != "") && ($oEntidad->getObjectByIndex('nu_importe') != "")) {
                    return true;
                }
            }
        }
        //Si es Bono, es obligatorio: Tipo concepto, concepto, Obra Social, Importe
        if (($oEntidad->getObjectByIndex('cd_tipoconcepto') != "") && ($oEntidad->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_BONO)) {
            if (($oEntidad->getObjectByIndex('cd_concepto') != "") && ($oEntidad->getObjectByIndex('cd_obrasocial') != "") && ($oEntidad->getObjectByIndex('nu_importe') != "")) {
                return true;
            }
        }
        //Si es Reintegro, es obligatorio: Tipo concepto, concepto, Orden Practica, Importe, Numero de recibo de reintegro
        if (($oEntidad->getObjectByIndex('cd_tipoconcepto') != "") && ($oEntidad->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_REINTEGRO)) {
            if (($oEntidad->getObjectByIndex('cd_concepto') != "") && ($oEntidad->getObjectByIndex('cd_ordenpractica') != "") && ($oEntidad->getObjectByIndex('nu_importe') != "") && ($oEntidad->getObjectByIndex('nu_reciboreintegro') != "")) {
                return true;
            }
        }
        //Si es Otro, es obligatorio: Tipo concepto, concepto, Importe
        if (($oEntidad->getObjectByIndex('cd_tipoconcepto') != CD_TIPO_CONCEPTO_BONO) && ($oEntidad->getObjectByIndex('cd_tipoconcepto') != CD_TIPO_CONCEPTOREINTEGRO) && ($oEntidad->getObjectByIndex('cd_tipoconcepto') != CD_TIPO_CONCEPTO_PRACTICA)) {
            if (($oEntidad->getObjectByIndex('cd_concepto') != "") && ($oEntidad->getObjectByIndex('nu_importe') != "")) {
                return true;
            }
        }
        //Chequea la cantidad de repeticiones
        $cd_obrasocial = $oEntidad->getObjectByIndex('cd_obrasocial');
        $cd_practicaobrasocial = $oEntidad->getObjectByIndex('cd_practicaobrasocial');
        $oCriterio = new CriterioBusqueda();

        $oCriterio->addFiltro("PO.cd_practicaobrasocial", $cd_practicaobrasocial, "=", new FormatValor());
        $oPracticaObrasocialManager = new PracticaobrasocialManager();
        $oPracticaObrasocial = $oPracticaObrasocialManager->getPracticaobrasocial($oCriterio);

        $oNewCriterio = new CriterioBusqueda();
        $oNewCriterio->addFiltro("PO.cd_obrasocial", $cd_obrasocial, "=");
        $oNewCriterio->addFiltro("PO.cd_practica", $oPracticaObrasocial->getCd_practica(), "=");
        $oNewCriterio->addOrden('dt_vigencia', 'DESC');
        $oPracticaObrasocialManager = new PracticaobrasocialManager();
        $oPracticasObrasociales = $oPracticaObrasocialManager->getPracticaobrasociales($oCriterioBusqueda);
        $nu_limiterepeticiones = "";
        $i = 0;
        $cd_practica = 0;
        foreach ($oPracticasObrasociales as $oPracticaObrasocial) {

            if ($oPracticaObrasocial->getNu_limiterepeticiones() != "" && $oPracticaObrasocial->getNu_limiterepeticiones() != 0) {
                CdtUtils::log_debug('Limite de repeticiones: ' . $oPracticaObrasocial->getNu_limiterepeticiones());
                $i++;
                $nu_limiterepeticiones = $oPracticaObrasocial->getNu_limiterepeticiones();
                $cd_practica = $oPracticaObrasocial->getCd_practica();
            }

            $oCriterio->addFiltro("POP.cd_practicaobrasocial", $oPracticaObrasocial->getCd_practicaobrasocial(), "=", null, "OR");
        }
        $cd_practicaobrasocial = urldecode(FormatUtils::getParam('cd_practicaobrasocial'));
        $cd_obrasocial = urldecode(FormatUtils::getParam('cd_obrasocial', '0'));
        //Si tiene limite de prï¿½cticas
        if ($nu_limiterepeticiones != "" && $nu_limiterepeticiones != null) {
            //Obtengo las consumidas en el ï¿½ltimo aï¿½o
            $t = time();
            $dt_carga = date('Ymd', strtotime('- 1 years', $t));
            $oCriterio->addFiltro("SUBSTRING(OP.dt_carga, -14,8)", $dt_carga, ">", null, "AND");
            $cd_paciente = urldecode(FormatUtils::getParam('cd_paciente', '0'));
            $oCriterio->addFiltro("OP.cd_paciente", $cd_paciente, "=");
            if ($cd_practica != 0) {
                $oCriterio->addFiltro("P.cd_practica", $cd_practica, "=");
            }
            if ($cd_obrasocial != 0) {
                $oCriterio->addFiltro("POS.cd_obrasocial", $cd_obrasocial, "=");
            }
            $oCriterio->addFiltro("MC.bl_anulacion", "0", "="); //Las que no han sido anuladas
            $oCriterio->addOrden('OP.dt_carga', 'DESC');
            $oPracticaOrdenpracticaManager = new PracticaordenpracticaManager();
            $practicaOrdenpracticas = $oPracticaOrdenpracticaManager->getPracticaordenpracticasConsumidas($oCriterio);
            CdtUtils::log_debug('Practicas consumidas: ' . $practicaOrdenpracticas->size());
            $consumidas = $practicaOrdenpracticas->size();
            //A los consumidos, le agrego los que estï¿½n en sesiï¿½n.
            $itemcollection = $_SESSION['movcajaconceptos_session'];
            CdtUtils::log_debug('Cantidad de Items en Session:' . $itemcollection->size());
            foreach ($itemcollection as $key => $entidadAInsertar) {
                CdtUtils::log_debug('Chequeando los consumos en sesión.');
                if ($entidadAInsertar->getObjectByIndex('cd_paciente') == $cd_paciente && $entidadAInsertar->getObjectByIndex('cd_obrasocial') == $cd_obrasocial && $entidadAInsertar->getObjectByIndex('cd_practica') == $oPracticaObrasocial->getCd_practica()) {
                    CdtUtils::log_debug('Hay un consumo en sesión.');
                    $consumidas++;
                    CdtUtils::log_debug('Practicas TOTAL consumidas: ' . $consumidas);
                }
            }

            if ($consumidas <= ($nu_limiterepeticiones + 1)) {
                return true;
            }
        }

        return false;
    }
    
	protected function getCoeficiente($cd_tipooperacion) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_movcaja_success';
	}
	
	protected function getXTemplateAjax() {
        return new XTemplate(RYT_TEMPLATE_TABLE_MOVCAJACONCEPTOS);
    }
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_movcaja_error';
	}
		

	public function getIdEntidad(){
		return FormatUtils::getParamPOST('id');
	}
	
	
	protected function getActionForwardFailure(){
		return 'modificar_movcaja_init';
	}
	
}
