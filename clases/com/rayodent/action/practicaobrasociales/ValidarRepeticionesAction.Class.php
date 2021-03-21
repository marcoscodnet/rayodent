<?php

class ValidarRepeticionesAction extends Action {

    protected function getFiltro() {
        $cd_obrasocial = urldecode(FormatUtils::getParam('cd_obrasocial', '0'));
        $cd_practicaobrasocial = urldecode(FormatUtils::getParam('cd_practicaobrasocial'));

        $oCriterio = new CriterioBusqueda();

        $oCriterio->addFiltro("PO.cd_practicaobrasocial", $cd_practicaobrasocial, "=", new FormatValor());
        $oPracticaObrasocialManager = new PracticaobrasocialManager();
        $oPracticaObrasocial = $oPracticaObrasocialManager->getPracticaobrasocial($oCriterio);

        $oNewCriterio = new CriterioBusqueda();
        $oNewCriterio->addFiltro("PO.cd_obrasocial", $cd_obrasocial, "=");
        $oNewCriterio->addFiltro("PO.cd_practica", $oPracticaObrasocial->getCd_practica(), "=");
        $oNewCriterio->addOrden('dt_vigencia', 'DESC');

        return $oNewCriterio;
    }

    public function validar($oCriterioBusqueda) {
        $oCriterio = new CriterioBusqueda();
        //Recupero el limite m�ximo de repeticiones para esa pr�ctica y esa OS
        $oPracticaObrasocialManager = new PracticaobrasocialManager();
        $oPracticasObrasociales = $oPracticaObrasocialManager->getPracticaobrasociales($oCriterioBusqueda);
        $nu_limiterepeticiones = "";
        $i = 0;
        $cd_practica = 0;
        $cd_movcaja = urldecode(FormatUtils::getParam('cd_movcaja', '0'));
        foreach ($oPracticasObrasociales as $oPracticaObrasocial) {
            if ($i == 0) {
                $nu_limiterepeticiones = $oPracticaObrasocial->getNu_limiterepeticiones();
                $i++;
                CdtUtils::log_debug('Limite de repeticiones: ' . $oPracticaObrasocial->getNu_limiterepeticiones());
                $cd_practica = $oPracticaObrasocial->getCd_practica();
            }

            $oCriterio->addFiltro("POP.cd_practicaobrasocial", $oPracticaObrasocial->getCd_practicaobrasocial(), "=", null, "OR");
        }
        $cd_practicaobrasocial = urldecode(FormatUtils::getParam('cd_practicaobrasocial'));
        $cd_obrasocial = urldecode(FormatUtils::getParam('cd_obrasocial', '0'));
        
     	if (isset($_SESSION['movcajaconceptos_session'])) {
        	$itemcollection = $_SESSION['movcajaconceptos_session'];
        } else {
            $itemcollection = new ItemCollection();
        }
        $cd_paciente = urldecode(FormatUtils::getParam('cd_paciente', '0'));
        CdtUtils::log_debug('Cantidad de Items en Session:' . $itemcollection->size());
        foreach ($itemcollection as $key => $entidadAInsertar) {
        	/*ob_start();
			var_dump($entidadAInsertar);
			CdtUtils::log_debug(ob_get_clean());
			ob_end_clean();	*/
        	if ($entidadAInsertar->getObjectByIndex('cd_paciente') == $cd_paciente && $entidadAInsertar->getObjectByIndex('cd_obrasocial') == $cd_obrasocial) {
	        	
        		$oNewCriterio = new CriterioBusqueda();
		        $oNewCriterio->addFiltro("PO.cd_practicaobrasocial", $entidadAInsertar->getObjectByIndex('cd_practicaobrasocial'), "=", new FormatValor());
		        //$oPracticaObrasocialManager = new PracticaobrasocialManager();
		        $oPracticaObrasocialAux = $oPracticaObrasocialManager->getPracticaobrasocial($oNewCriterio);
		        $cd_practica2 = $oPracticaObrasocialAux->getCd_practica();
        		/*$oNewCriterio = new CriterioBusqueda();
	        	$oNewCriterio->addFiltro("OS.cd_obrasocial", $cd_obrasocial, "=");
	        	$oNewCriterio->addFiltro("P1.cd_practica", $cd_practica, "=");
	        	$oNewCriterio->addFiltro("P2.cd_practica", $cd_practica2, "=");
	        	$oNewCriterio->addFiltro("P2.cd_practica", $cd_practica, "=",NULL,"OR");
	        	$oNewCriterio->addFiltro("P1.cd_practica", $cd_practica2, "=");*/
	                    
	        	$oMovcajacontrolpracticaManager = new MovcajacontrolpracticaManager();
	       	 	$oMovcajacontrolpracticas = $oMovcajacontrolpracticaManager->getMovcajacontrolpracticas($cd_obrasocial,$cd_practica,$cd_practica2);
	       
	        	foreach ($oMovcajacontrolpracticas as $oMovcajacontrolpractica) {
	        		
	        		$texto = "Para la Obra Social ".$oMovcajacontrolpractica->getObrasocial()->getDs_obrasocial()." no se pueden realizar las pr�cticas ".$oMovcajacontrolpractica->getPractica1()->getDs_practica()." y ".$oMovcajacontrolpractica->getPractica2()->getDs_practica()." en el mismo movimiento";
					$msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>$texto</p></div>");
			        echo $msj;
			        return $msj;
	        	}   	
        	}
        }
        
        //Si tiene limite de pr�cticas
        if ($nu_limiterepeticiones != "" && $nu_limiterepeticiones != null) {
            //Obtengo las consumidas en el �ltimo a�o
            $t = time();
            $dt_carga = date('Ymd', strtotime('- 1 years', $t));
            $oCriterio = new CriterioBusqueda();
            $oCriterio->addFiltro("SUBSTRING(OP.dt_carga, -14,8)", $dt_carga, ">", null, "AND");
            
            $oCriterio->addFiltro("OP.cd_paciente", $cd_paciente, "=");
            if ($cd_practica != 0) {
                $oCriterio->addFiltro("P.cd_practica", $cd_practica, "=");
            }
            if ($cd_obrasocial != 0) {
                $oCriterio->addFiltro("POS.cd_obrasocial", $cd_obrasocial, "=");
            }
            $oCriterio->addFiltro("MC.bl_anulacion", "0", "=");
            $oCriterio->addFiltro("MC.cd_movcaja", $cd_movcaja, "<>");
            $oCriterio->addOrden('OP.dt_carga', 'DESC');
            $oPracticaOrdenpracticaManager = new PracticaordenpracticaManager();
            $practicaOrdenpracticas = $oPracticaOrdenpracticaManager->getPracticaordenpracticasConsumidas($oCriterio);
            CdtUtils::log_debug('Practicas consumidas: ' . $practicaOrdenpracticas->size());

            $consumidas = $practicaOrdenpracticas->size();
            //A los consumidos, le agrego los que est�n en sesi�n.
           
            $ultimaensession = false;
           
            
            foreach ($itemcollection as $key => $entidadAInsertar) {
                CdtUtils::log_debug('Chequeando los consumos en sesi�n.');
                CdtUtils::log_debug('Comparando ' . $entidadAInsertar->getObjectByIndex('cd_paciente') . " con " . $cd_paciente);
                CdtUtils::log_debug('Comparando ' . $entidadAInsertar->getObjectByIndex('cd_obrasocial') . " con " . $cd_obrasocial);
                CdtUtils::log_debug('Comparando ' . $entidadAInsertar->getObjectByIndex('cd_practicaobrasocial') . " con " . $cd_practicaobrasocial);
                if ($entidadAInsertar->getObjectByIndex('cd_paciente') == $cd_paciente && $entidadAInsertar->getObjectByIndex('cd_obrasocial') == $cd_obrasocial && $entidadAInsertar->getObjectByIndex('cd_practicaobrasocial') == $cd_practicaobrasocial) {
                    
                    
        			CdtUtils::log_debug('Hay un consumo en sesi�n.');
                    $consumidas = $consumidas + 1;
                    $ultimaensession = true;
                    CdtUtils::log_debug('Practicas TOTAL consumidas: ' . $consumidas);
                }
            }


            if ($consumidas > 0 && $consumidas >= ($nu_limiterepeticiones + 1)) {
                if ($ultimaensession) {
                    $texto = "El paciente excedi� el l�mite de pr�cticas en este movimiento de caja";
                } else {
                    $oPracticaOrdenPractica = $practicaOrdenpracticas->current();
                    $dt_carga = FuncionesComunes::fechaHoraMysqlaPHP($oPracticaOrdenPractica->getOrdenpractica()->getMovcaja()->getDt_movcaja());
                    $cd_movcaja = $oPracticaOrdenPractica->getOrdenpractica()->getCd_movcaja();
                    $ds_practica = $oPracticaOrdenPractica->getPracticaobrasocial()->getPractica()->getDs_practica();
                   /*ob_start();
					var_dump($oPracticaOrdenPractica);
					CdtUtils::log_debug(ob_get_clean());
					ob_end_clean();	*/
                    $texto = "El paciente excedi� el l�mite de pr�cticas. �ltima pr�ctica: $ds_practica realizada el $dt_carga  cod mov. caja: <a href='doAction?action=ver_movcaja&id=$cd_movcaja' target='_blank'>$cd_movcaja</a>";
                }
                $msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>$texto</p></div>");
                echo $msj;
                return $msj;
            } /*else {
                echo "";
                return "";
            }*/
        }
        CdtUtils::log_debug($cd_obrasocial.': ' . CD_OBRASOCIAL_IOMA);
        if ($cd_obrasocial == CD_OBRASOCIAL_IOMA) {
        	
        	if ($cd_practica == CD_PRACTICA_PANORAMICA) {
        		
        		//Obtengo si en los �ltimos 6 meses se hizo una seriada
	            $t = time();
	            $dt_carga = date('Ymd', strtotime('- 6 months', $t));
	            $oCriterio = new CriterioBusqueda();
	            $oCriterio->addFiltro("SUBSTRING(OP.dt_carga, -14,8)", $dt_carga, ">", null, "AND");
	            $cd_paciente = urldecode(FormatUtils::getParam('cd_paciente', '0'));
	            $oCriterio->addFiltro("OP.cd_paciente", $cd_paciente, "=");
	            $oCriterio->addFiltro("P.cd_practica", CD_PRACTICA_SERIADA, "=");
                $oCriterio->addFiltro("POS.cd_obrasocial", $cd_obrasocial, "=");
                $oCriterio->addFiltro("MC.bl_anulacion", "0", "=");
                $oCriterio->addFiltro("MC.cd_movcaja", $cd_movcaja, "<>");
	            $oCriterio->addOrden('OP.dt_carga', 'DESC');
	            $oPracticaOrdenpracticaManager = new PracticaordenpracticaManager();
	            $practicaOrdenpracticas = $oPracticaOrdenpracticaManager->getPracticaordenpracticasConsumidas($oCriterio);
	            CdtUtils::log_debug('Practicas seriadas: ' . $practicaOrdenpracticas->size());
	
	            $seriadas = $practicaOrdenpracticas->size();
	            if ($seriadas > 0) {
	            	$oPracticaOrdenPractica = $practicaOrdenpracticas->current();
                    $dt_carga = FuncionesComunes::fechaHoraMysqlaPHP($oPracticaOrdenPractica->getOrdenpractica()->getMovcaja()->getDt_movcaja());
                    $cd_movcaja = $oPracticaOrdenPractica->getOrdenpractica()->getCd_movcaja();
                    $texto = "El paciente se realiz� una pr�ctica seriada el $dt_carga y cod mov. caja: <a href='doAction?action=ver_movcaja&id=$cd_movcaja' target='_blank'>$cd_movcaja</a>";
					$msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>$texto</p></div>");
	                echo $msj;
	                return $msj;
	            }
	            
        	}
        	if ($cd_practica == CD_PRACTICA_SERIADA) {
        		//Obtengo si en los �ltimos 6 meses se hizo una seriada
	            $t = time();
	            $dt_carga = date('Ymd', strtotime('- 6 months', $t));
	            $oCriterio = new CriterioBusqueda();
	            $oCriterio->addFiltro("SUBSTRING(OP.dt_carga, -14,8)", $dt_carga, ">", null, "AND");
	            $cd_paciente = urldecode(FormatUtils::getParam('cd_paciente', '0'));
	            $oCriterio->addFiltro("OP.cd_paciente", $cd_paciente, "=");
	            $oCriterio->addFiltro("P.cd_practica", CD_PRACTICA_PANORAMICA, "=");
                $oCriterio->addFiltro("POS.cd_obrasocial", $cd_obrasocial, "=");
                $oCriterio->addFiltro("MC.bl_anulacion", "0", "=");
                $oCriterio->addFiltro("MC.cd_movcaja", $cd_movcaja, "<>");
	            $oCriterio->addOrden('OP.dt_carga', 'DESC');
	            $oPracticaOrdenpracticaManager = new PracticaordenpracticaManager();
	            $practicaOrdenpracticas = $oPracticaOrdenpracticaManager->getPracticaordenpracticasConsumidas($oCriterio);
	            CdtUtils::log_debug('Practicas panoramicas: ' . $practicaOrdenpracticas->size());
	
	            $panoramicas = $practicaOrdenpracticas->size();
	            if ($panoramicas > 0) {
	            	$oPracticaOrdenPractica = $practicaOrdenpracticas->current();
                    $dt_carga = FuncionesComunes::fechaHoraMysqlaPHP($oPracticaOrdenPractica->getOrdenpractica()->getMovcaja()->getDt_movcaja());
                    $cd_movcaja = $oPracticaOrdenPractica->getOrdenpractica()->getCd_movcaja();
                    $texto = "El paciente se realiz� una pr�ctica panor�mica el $dt_carga y cod mov. caja: <a href='doAction?action=ver_movcaja&id=$cd_movcaja' target='_blank'>$cd_movcaja</a>";
					$msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>$texto</p></div>");
	                echo $msj;
	                return $msj;
	            }
	            
        	}
        	
        	
        }
        echo "";
        return "";
    }

    public function execute() {

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            $oFiltro = $this->getFiltro();
            
            $this->validar($oFiltro);
            //commit de la transacci�n.
            DbManager::save();
        } catch (GenericException $ex) {
            //rollback de la transacci�n.
            DbManager::undo();
            CdtUtils::log_debug('failure en ValidarRepeticionesAction');
        }

        return $forward;
    }

}
