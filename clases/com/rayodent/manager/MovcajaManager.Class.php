<?php

/**
 * Autogenerated class
 *
 *  @author modelBuilder
 *  @since 14-12-2011
 */
class MovcajaManager implements IListar {

    public function agregarMovcaja(Movcaja $oMovcaja) {
//persistir en la bbdd.
        MovcajaDAO::insertarMovcaja($oMovcaja);
        if (isset($_SESSION['movcajaconceptos_session'])) {
            $oMovcajaconceptoManager = new MovcajaconceptoManager();
            foreach ($_SESSION['movcajaconceptos_session'] as $item) {
                //Guardo el Mov Caja concepto
                $oMovcajaconcepto = new Movcajaconcepto();
                $oMovcajaconcepto->setCd_movcaja($oMovcaja->getCd_movcaja());
                $oMovcajaconcepto->setCd_concepto($item->getObjectByIndex('cd_concepto'));
                $oMovcajaconcepto->setNu_importe($item->getObjectByIndex('nu_importe'));
                $bl_tarjeta = ($item->getObjectByIndex('bl_tarjeta'))?1:0;
                $oMovcajaconcepto->setBl_tarjeta($bl_tarjeta);
                $oMovcajaconcepto->setCd_ordenpractica($item->getObjectByIndex('cd_ordenpractica'));
                $oMovcajaconceptoManager->agregarMovcajaconcepto($oMovcajaconcepto);

                //Ahora, si es pr�ctica
                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA) {
                    //Creo la orden de pr�ctica primero
                    $oOrdenpractica = new Ordenpractica();
                    $oOrdenpractica->setCd_empleado($item->getObjectByIndex('cd_empleado'));
                    $oOrdenpractica->setCd_paciente($item->getObjectByIndex('cd_paciente'));
                    $oOrdenpractica->setCd_profesional($item->getObjectByIndex('cd_profesional'));
                    $oOrdenpractica->setCd_obrasocial($item->getObjectByIndex('cd_obrasocial'));
                    $oOrdenpractica->setCd_movcaja($oMovcaja->getCd_movcaja());
                    $oOrdenpractica->setCd_turno($oMovcaja->getCd_turno());
                    $oOrdenpractica->setDt_carga($oMovcaja->getDt_movcaja());
                    $ordenpracticaManager = new OrdenpracticaManager();
                    $ordenpracticaManager->agregarOrdenpractica($oOrdenpractica);

// Luego inserto la pr�ctica orden pr�ctica
                    $oPracticaordenpractica = new Practicaordenpractica();
                    $oPracticaordenpractica->setCd_ordenpractica($oOrdenpractica->getCd_ordenpractica());
                    $oPracticaordenpractica->setCd_movcajaconcepto($oMovcajaconcepto->getCd_movcajaconcepto());
                    $oPracticaordenpractica->setNu_cantplacas($item->getObjectByIndex('nu_placas'));
                    $oPracticaordenpractica->setDs_pieza($item->getObjectByIndex('ds_pieza'));
                    $oPracticaordenpractica->setCd_aporteos($item->getObjectByIndex('cd_aporteos'));
                    $oPracticaordenpractica->setCd_practicaobrasocial($item->getObjectByIndex('cd_practicaobrasocial'));
                    $oPracticaordenPracticaManager = new PracticaordenpracticaManager();
                    $oPracticaordenPracticaManager->agregarPracticaordenpractica($oPracticaordenpractica);
                }
//Ahora, si es Bono
                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_BONO) {
                    if (isset($oOrdenpractica) && ($oOrdenpractica->getCd_ordenpractica() != "")) {
                        $oOrdenpractica->setBl_bono(1);
                        $oOrdenpractica->setCd_obrasocial($item->getObjectByIndex('cd_obrasocial'));
                        $oOrdenpractica->setNu_importebono($item->getObjectByIndex('nu_importe'));
                        $ordenpracticaManager->modificarOrdenpractica($oOrdenpractica);
                    }
                }
//Ahora, si es Reintegro
                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_REINTEGRO) {
					//print_r($item);
					if ($item->getObjectByIndex('cd_ordenpractica')) {
						$cd_ordenpractica = $item->getObjectByIndex('cd_ordenpractica');
	                    //CdtUtils::log_debug('Orden p: ' . $cd_ordenpractica);
	                    $ordenpracticaManager = new OrdenpracticaManager();
	                    $criterio = new CriterioBusqueda();
	                    $criterio->addFiltro("cd_ordenpractica", $cd_ordenpractica, "=");
	                    $oOrdenpractica = $ordenpracticaManager->getOrdenpractica($criterio);
	                    $oOrdenpractica->setNu_reciboreintegro($item->getObjectByIndex('nu_reciboreintegro'));
	                    $ordenpracticaManager->modificarOrdenpractica($oOrdenpractica);
					}

                }
            }
        }
    }

    public function hayCajaAbierta($nu_caja) {

        $criterio = new CriterioBusqueda();
        //$criterio->addFiltro("PC.nu_caja", $nu_caja, "=");
        $criterio->addOrden("dt_procesocaja", "DESC");
        $respuesta = MovcajaDAO::getUltimoProcesocaja($criterio);
        if ($respuesta == NULL) {
            $respuesta['cd_concepto'] = 0;
            $respuesta['cd_movcaja'] = 0;
            $respuesta['cd_turno'] = 0;
            $respuesta['nu_caja'] = 0;
            $respuesta['cd_usuario'] = 0;
        }
        //retorna el cd_movcaja y el concepto
        return $respuesta;
    }

    public function modificarMovcaja(Movcaja $oMovcaja, $anulacion=0) {
//TODO validaciones;
//persistir en la bbdd.
		RYTUtils::logObject($_POST);
        MovcajaDAO::modificarMovcaja($oMovcaja);
        if (!$anulacion) {

	        $criterio = new CriterioBusqueda();
	        $criterio->addFiltro("OP.cd_movcaja", $oMovcaja->getCd_movcaja(), "=");
	        $ordenpracticaManager = new OrdenpracticaManager();
	        $oOrdenpracticas = $ordenpracticaManager->getOrdenpracticas($criterio);
	        $oPracticaordenPracticaManager = new PracticaordenpracticaManager();
	        foreach ($oOrdenpracticas as $oOrdenpractica) {
	        	$oPracticaordenPracticaManager->eliminarPracticaordenpracticaPorOrdenpractica($oOrdenpractica->getCd_ordenpractica());
	        }

	        $ordenpracticaManager->eliminarOrdenpracticaPorMovcaja($oMovcaja->getCd_movcaja());
	        $oMovcajaconceptoManager = new MovcajaconceptoManager();
	        $oMovcajaconceptoManager->eliminarMovcajaconceptoPorMovcaja($oMovcaja->getCd_movcaja());
	    	if (isset($_SESSION['movcajaconceptos_session'])) {

	            foreach ($_SESSION['movcajaconceptos_session'] as $item) {
	                //Guardo el Mov Caja concepto
	                $bl_tarjeta = (FormatUtils::getParamPOST('bl_tarjeta'))?FormatUtils::getParamPOST('bl_tarjeta'):$item->getObjectByIndex('bl_tarjeta');
	                $oMovcajaconcepto = new Movcajaconcepto();
	                $oMovcajaconcepto->setCd_movcaja($oMovcaja->getCd_movcaja());
	                $oMovcajaconcepto->setCd_concepto($item->getObjectByIndex('cd_concepto'));
	                $oMovcajaconcepto->setNu_importe($item->getObjectByIndex('nu_importe'));
	                $oMovcajaconcepto->setCd_ordenpractica($item->getObjectByIndex('cd_ordenpractica'));
	                $oMovcajaconcepto->setBl_tarjeta($bl_tarjeta);
	                $oMovcajaconceptoManager->agregarMovcajaconcepto($oMovcajaconcepto);

	                //Ahora, si es pr�ctica
	                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA) {
	                    //Creo la orden de pr�ctica primero
	                    $cd_paciente = (FormatUtils::getParamPOST('cd_paciente'))?FormatUtils::getParamPOST('cd_paciente'):$item->getObjectByIndex('cd_paciente');
	                	$cd_profesional = (FormatUtils::getParamPOST('cd_profesional'))?FormatUtils::getParamPOST('cd_profesional'):$item->getObjectByIndex('cd_profesional');
	                	$cd_empleado = (FormatUtils::getParamPOST('cd_empleado'))?FormatUtils::getParamPOST('cd_empleado'):$item->getObjectByIndex('cd_empleado');
	                    $oOrdenpractica = new Ordenpractica();
	                    $oOrdenpractica->setCd_empleado($cd_empleado);
	                    $oOrdenpractica->setCd_paciente($cd_paciente);
	                    $oOrdenpractica->setCd_profesional($cd_profesional);
	                    $oOrdenpractica->setCd_obrasocial($item->getObjectByIndex('cd_obrasocial'));
	                    $oOrdenpractica->setCd_movcaja($oMovcaja->getCd_movcaja());
	                    $oOrdenpractica->setCd_turno($oMovcaja->getCd_turno());
	                    $oOrdenpractica->setDt_carga($oMovcaja->getDt_movcaja());
	                    $ordenpracticaManager = new OrdenpracticaManager();
	                    $ordenpracticaManager->agregarOrdenpractica($oOrdenpractica);

	// Luego inserto la pr�ctica orden pr�ctica
	                    $oPracticaordenpractica = new Practicaordenpractica();
	                    $oPracticaordenpractica->setCd_ordenpractica($oOrdenpractica->getCd_ordenpractica());
	                    $oPracticaordenpractica->setCd_movcajaconcepto($oMovcajaconcepto->getCd_movcajaconcepto());
	                    $oPracticaordenpractica->setNu_cantplacas($item->getObjectByIndex('nu_placas'));
	                    $oPracticaordenpractica->setDs_pieza($item->getObjectByIndex('ds_pieza'));
	                    $oPracticaordenpractica->setCd_aporteos($item->getObjectByIndex('cd_aporteos'));
	                    $oPracticaordenpractica->setCd_practicaobrasocial($item->getObjectByIndex('cd_practicaobrasocial'));

	                    $oPracticaordenPracticaManager->agregarPracticaordenpractica($oPracticaordenpractica);
	                }
	//Ahora, si es Bono
	                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_BONO) {
	                    if (isset($oOrdenpractica) && ($oOrdenpractica->getCd_ordenpractica() != "")) {
	                        $oOrdenpractica->setBl_bono(1);
	                        $oOrdenpractica->setCd_obrasocial($item->getObjectByIndex('cd_obrasocial'));
	                        $oOrdenpractica->setNu_importebono($item->getObjectByIndex('nu_importe'));
	                        $ordenpracticaManager->modificarOrdenpractica($oOrdenpractica);
	                    }
	                }
	//Ahora, si es Reintegro
	                if ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_REINTEGRO) {

	                    $cd_ordenpractica = $item->getObjectByIndex('cd_ordenpractica');
	                    if ($cd_ordenpractica) {
	                    	$ordenpracticaManager = new OrdenpracticaManager();
		                    $criterio = new CriterioBusqueda();
		                    $criterio->addFiltro("cd_ordenpractica", $cd_ordenpractica, "=");
		                    $oOrdenpractica = $ordenpracticaManager->getOrdenpractica($criterio);
		                    $oOrdenpractica->setNu_reciboreintegro($item->getObjectByIndex('nu_reciboreintegro'));
		                    $ordenpracticaManager->modificarOrdenpractica($oOrdenpractica);
	                    }

	                }
	            }
	        }
       }
    }

    public function getMontoTotal($criterio) {
        return MovcajaDAO::getMontoTotal($criterio);
    }

	public function getMontoTotalPosnet($criterio) {
        return MovcajaDAO::getMontoTotalPosnet($criterio);
    }

    public function getTotalPlacas($criterio) {
        return MovcajaDAO::getTotalPlacas($criterio);
    }

    public function getMontoTotalGastos($criterio) {
        return MovcajaDAO::getMontoTotalGastos($criterio);
    }

    public function getMontoTotalDeObraSocial($criterio) {
        return MovcajaDAO::getMontoTotalDeObraSocial($criterio);
    }

    public static function eliminarMovcaja($id) {
//TODO validaciones;

        $oMovcaja = new Movcaja();
        $oMovcaja->setCd_movcaja($id);
        MovcajaDAO::eliminarMovcaja($oMovcaja);
    }

    public function getMovcajas(CriterioBusqueda $criterio) {
        return MovcajaDAO::getMovcajas($criterio);
    }

    public function getMovcajasDeLiquidacionParaOS(CriterioBusqueda $criterio, $cd_obrasocial = 0) {
        $listado_movcajas = MovcajaDAO::getMovcajasDeLiquidacion($criterio);

        foreach ($listado_movcajas as $oMovcaja) {
            $paciente = "";
            $cd_movcaja = $oMovcaja->getCd_movcaja();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("MCC.cd_movcaja", $cd_movcaja, "=");
            //$criterio->addFiltro("POS.cd_obrasocial", $cd_obrasocial, "=");
            $criterio->addFiltro("OP.cd_obrasocial", $cd_obrasocial, "=");
            $movcajaconceptosManager = new MovcajaconceptoManager();
            $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptosDeObraSocial($criterio);
            $detalle = "<ul>";

            $total = 0;
            foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
                $nomenclador = "";
                if ($paciente == "") {
                    //Obtengo el paciente :s
                    $oPracticaordenpracticaManager = new PracticaordenpracticaManager();
                    $criterio_pop = new CriterioBusqueda();
                    $criterio_pop->addFiltro("POP.cd_movcajaconcepto", $oMovCajaConceptos->getCd_movcajaconcepto(), "=");
                    $oPracticaordenpractica = $oPracticaordenpracticaManager->getPracticaordenpractica($criterio_pop);
                    $paciente = $oPracticaordenpractica->getOrdenpractica()->getPaciente()->getDs_apynom();
                    $nomenclador = $oPracticaordenpractica->getPracticaobrasocial()->getNu_practicaos();
                }
                if ($nomenclador == "") {
                    $detalle .= "<li>" . $oMovCajaConceptos->getConcepto()->getDs_concepto();
                } else {
                    $detalle .= "<li>" . $nomenclador;
                }
                $detalle .= " (" . $oMovCajaConceptos->getConcepto()->getTipoconcepto()->getDs_tipoconcepto() . ") / ";
                $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
                $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                $valor = $oMovCajaConceptos->getNu_importe() * $coeficiente;
                $detalle .= "$" . $valor . "</li>";
                $total += $valor;
            }

            $detalle .="</ul>";

            $oMovcaja->setDs_detalle($detalle);
            $oMovcaja->setDs_paciente($paciente);
            $oMovcaja->setNu_total($total);
        }
        return $listado_movcajas;
    }

    public function getCantidadMovcajasDeLiquidacion(CriterioBusqueda $criterio) {
        return MovcajaDAO::getCantidadMovcajasDeLiquidacion($criterio);
    }

    public function getListadoMovcajas(CriterioBusqueda $criterio) {
        $listado_movcajas = MovcajaDAO::getMovcajas($criterio);
        foreach ($listado_movcajas as $oMovcaja) {
            $cd_movcaja = $oMovcaja->getCd_movcaja();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("MCC.cd_movcaja", $cd_movcaja, "=");
            $movcajaconceptosManager = new MovcajaconceptoManager();
            $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptos($criterio);
            $detalle = "<ul>";
            $detalle_placas = "<ul>";
            $total = 0;
            $totalPosnet = 0;
            $totalEfectivo = 0;
            $totalOB=0;
            $total_placas = 0;
            $arrayOS=array();
            foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
            	//RYTUtils::logObject($oMovCajaConceptos);
                $detalle .= "<li>" . $oMovCajaConceptos->getConcepto()->getDs_concepto() . " (" . $oMovCajaConceptos->getConcepto()->getTipoconcepto()->getDs_tipoconcepto() . "-".$oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getPractica()->getDs_practica(). "-".$oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial().") / ";
                $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
                $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                $valor = $oMovCajaConceptos->getNu_importe() * $coeficiente;
                $bl_tarjeta = ($oMovCajaConceptos->getBl_tarjeta())?'SI':'NO';
                $detalle .= "$" . $valor . " PosNet: ".$bl_tarjeta."</li>";

                if (($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() != CD_OBRASOCIAL_PARTICULAR)) {
                    $totalOB +=$valor;
                    if(!in_array($oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial(),$arrayOS)){
                        $arrayOS[]=$oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getObrasocial()->getDs_obrasocial();
                    }


                }
                if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() != CD_TIPO_CONCEPTO_PRACTICA || ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR)) {
                    $totalPosnet +=($bl_tarjeta=='SI')?$valor:0;
                    $totalEfectivo +=($bl_tarjeta=='NO')?$valor:0;
                    $total += $valor;
                }
                //CdtUtils::log_debug('Tipo concepto: ' . $oMovCajaConceptos->getConcepto()->getCd_tipoconcepto());
                if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA) {
                    //Obtengo el detalle de la pr�ctica
                    $oPracticaordenpracticaManager = new PracticaordenpracticaManager();
                    $criterio_pop = new CriterioBusqueda();
                    $criterio_pop->addFiltro("POP.cd_movcajaconcepto", $oMovCajaConceptos->getCd_movcajaconcepto(), "=");
                    $oPracticaordenpractica = $oPracticaordenpracticaManager->getPracticaordenpractica($criterio_pop);
                    $ds_paciente = $oPracticaordenpractica->getOrdenpractica()->getPaciente()->getDs_apynom();
                    $ds_paciente .= ", " . $oPracticaordenpractica->getOrdenpractica()->getPaciente()->getTipodoc()->getDs_tipodocumento();
                    $ds_paciente .= " " . $oPracticaordenpractica->getOrdenpractica()->getPaciente()->getNu_doc();
                    $oMovcaja->setDs_paciente($ds_paciente);

                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $cant_placas = $oPracticaordenpractica->getNu_cantPlacas();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: $cant_placas)</li>";
                    $total_placas +=$cant_placas;
                }
            	elseif ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_REINTEGRO) {
            		//RYTUtils::logObject($oMovCajaConceptos);
                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: 0)</li>";

                    //CdtUtils::log_debug('Tipo concepto: ' . $oMovCajaConceptos->getCd_ordenpractica());
                    if ($oMovCajaConceptos->getCd_ordenpractica()) {
                    	$oOrdenpracticaManager = new OrdenpracticaManager();
	                    $criterio_pop = new CriterioBusqueda();
	                    $criterio_pop->addFiltro("OP.cd_ordenpractica", $oMovCajaConceptos->getCd_ordenpractica(), "=");
	                    $oOrdenpractica = $oOrdenpracticaManager->getOrdenpractica($criterio_pop);
	                    if ($oOrdenpractica) {
	                    	$ds_paciente = $oOrdenpractica->getPaciente()->getDs_apynom();
		                    $ds_paciente .= ", " . $oOrdenpractica->getPaciente()->getTipodoc()->getDs_tipodocumento();
		                    $ds_paciente .= " " . $oOrdenpractica->getPaciente()->getNu_doc();
		                    $oMovcaja->setDs_paciente($ds_paciente);
	                    	$detalle .= "<li> Mov. Caja: " .$oOrdenpractica->getCd_movcaja()."</li>";
	                    }

                    }



                }
                else {
                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: 0)</li>";
                }
            }
            $detalle_placas .= "</ul>";
            $detalle .="</ul>";
            //echo $detalle;
            $oMovcaja->setDs_detalle($detalle);
            $oMovcaja->setDs_detallePlacas($detalle_placas);
            $oMovcaja->setNu_total("$".$total." (Efectivo: $".$totalEfectivo." PosNet: $".$totalPosnet);
            $oMovcaja->setNu_totalefectivo("$".$totalEfectivo);
            $oMovcaja->setNu_totalposnet("$".$totalPosnet);
            $oMovcaja->setNu_totalOB("$".$totalOB);
            foreach ($arrayOS as $os){
                $oMovcaja->setDs_obrasocial($os.' ');
            }

        }
        return $listado_movcajas;
    }

    public function getListadoMovcajasArqueo(CriterioBusqueda $criterio) {
        $listado_movcajas = MovcajaDAO::getMovcajas($criterio);
        foreach ($listado_movcajas as $oMovcaja) {
            $cd_movcaja = $oMovcaja->getCd_movcaja();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("MCC.cd_movcaja", $cd_movcaja, "=");
            $movcajaconceptosManager = new MovcajaconceptoManager();
            $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptos($criterio);
            $detalle = "<ul>";
            $detalle_placas = "<ul>";
            $total = 0;
            $total_placas = 0;
            foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
                $detalle .= "<li>" . $oMovCajaConceptos->getConcepto()->getDs_concepto() . " (" . $oMovCajaConceptos->getConcepto()->getTipoconcepto()->getDs_tipoconcepto() . ") / ";
                $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
                $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                $valor = $oMovCajaConceptos->getNu_importe() * $coeficiente;
                $detalle .= "$" . $valor . "</li>";
                if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() != CD_TIPO_CONCEPTO_PRACTICA || ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR)) {
                    $total += $valor;
                }
                if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA) {
                    //Obtengo el detalle de la pr�ctica
                    $oPracticaordenpracticaManager = new PracticaordenpracticaManager();
                    $criterio_pop = new CriterioBusqueda();
                    $criterio_pop->addFiltro("POP.cd_movcajaconcepto", $oMovCajaConceptos->getCd_movcajaconcepto(), "=");
                    $oPracticaordenpractica = $oPracticaordenpracticaManager->getPracticaordenpractica($criterio_pop);
                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $cant_placas = $oPracticaordenpractica->getNu_cantPlacas();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: $cant_placas)</li>";
                    $total_placas +=$cant_placas;
                }
            	elseif ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_REINTEGRO) {
            		//RYTUtils::logObject($oMovCajaConceptos);
                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: 0)</li>";

                    //CdtUtils::log_debug('Tipo concepto: ' . $oMovCajaConceptos->getCd_ordenpractica());
                    if ($oMovCajaConceptos->getCd_ordenpractica()) {
                    	$oOrdenpracticaManager = new OrdenpracticaManager();
	                    $criterio_pop = new CriterioBusqueda();
	                    $criterio_pop->addFiltro("OP.cd_ordenpractica", $oMovCajaConceptos->getCd_ordenpractica(), "=");
	                    $oOrdenpractica = $oOrdenpracticaManager->getOrdenpractica($criterio_pop);
	                    $ds_paciente = $oOrdenpractica->getPaciente()->getDs_apynom();
	                    $ds_paciente .= ", " . $oOrdenpractica->getPaciente()->getTipodoc()->getDs_tipodocumento();
	                    $ds_paciente .= " " . $oOrdenpractica->getPaciente()->getNu_doc();
	                    $oMovcaja->setDs_paciente($ds_paciente);
	                    $detalle .= "<li> Mov. Caja: " .$oOrdenpractica->getCd_movcaja()."</li>";
                    }



                }
                else {
                    $nombre = $oMovCajaConceptos->getConcepto()->getDs_concepto();
                    $detalle_placas .= "<li> $nombre (Nro de Placas: 0)</li>";
                }
            }
            $detalle_placas .= "</ul>";
            $detalle .="</ul>";
            //echo $detalle;
            $oMovcaja->setDs_detalle($detalle);
            $oMovcaja->setDs_detallePlacas($detalle_placas);
            $oMovcaja->setNu_total($total);
        }
        return $listado_movcajas;
    }

    protected function getCoeficiente($cd_tipooperacion = 0) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

    public function getCantMovcajas(CriterioBusqueda $criterio) {
        return MovcajaDAO::getCantMovcajas($criterio);
    }

    public function getMovcaja(CriterioBusqueda $criterio) {
        return MovcajaDAO::getMovcaja($criterio);
    }

    public function getEntidadesArqueo(CriterioBusqueda $criterio) {
        return $this->getListadoMovcajasArqueo($criterio);
    }

//	interface IListar
    public function getEntidades(CriterioBusqueda $criterio) {
        return $this->getListadoMovcajas($criterio);
    }

    public function getCantidadEntidades(CriterioBusqueda $criterio) {
        return $this->getCantMovcajas($criterio);
    }

}
?>
