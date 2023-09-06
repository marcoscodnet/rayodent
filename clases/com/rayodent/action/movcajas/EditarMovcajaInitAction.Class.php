<?php

/**
 * Acci�n para inicializar el contexto para editar
 * un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarMovcajaInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_MOVCAJA);
    }

    protected function getEntidad() {
        //se construye el movcaja a modificar.
        $oMovcaja = new Movcaja ( );
        $oMovcaja->setCd_movcaja(FormatUtils::getParamPOST('cd_movcaja'));
        $oMovcaja->setDt_movcaja(FormatUtils::getParamPOST('dt_movcaja'));
        $oMovcaja->setDs_observacion(FormatUtils::getParamPOST('ds_observacion'));
        $oMovcaja->setNu_caja(FormatUtils::getParamPOST('nu_caja'));
        $oMovcaja->setCd_usuario(FormatUtils::getParamPOST('cd_usuario'));
        $oMovcaja->setCd_turno(FormatUtils::getParamPOST('cd_turno'));
        $oMovcaja->setNu_etiquetasimple(FormatUtils::getParamPOST('nu_etiquetasimple'));
        $oMovcaja->setNu_etiquetadoble(FormatUtils::getParamPOST('nu_etiquetadoble'));
        return $oMovcaja;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseLabel(XTemplate $xtpl) {
        $xtpl->assign('cd_movcaja_label', RYT_MOVCAJA_CD_MOVCAJA);
        $xtpl->assign('dt_movcaja_label', RYT_MOVCAJA_DT_MOVCAJA);
        $xtpl->assign('ds_observacion_label', RYT_MOVCAJA_DS_OBSERVACION);
        $xtpl->assign('ds_paciente_label', RYT_MOVCAJA_DS_PACIENTE);
        $xtpl->assign('ds_profesional_label', RYT_MOVCAJA_DS_PROFESIONAL);
        $xtpl->assign('ds_personal_label', RYT_MOVCAJA_DS_PERSONAL);
        //Label combos
        $xtpl->assign('cd_tipoconcepto_label', RYT_CONCEPTO_CD_TIPOCONCEPTO);
        $xtpl->assign('ds_concepto_label', RYT_CONCEPTO_DS_CONCEPTO);
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_usuario", $cd_usuario, "=");
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuario($criterio);
        $nu_caja = $oUsuario->getNu_caja();
        $movcajaManager = new MovcajaManager();
        $rta = $movcajaManager->hayCajaAbierta($nu_caja);
        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_turno = $rta['cd_turno'];
        $nu_caja_abierta = $rta['nu_caja'];
        $cd_usuario_caja_abierta = $rta['cd_usuario'];
        $oUsuarioCajaAbierta = $usuarioManager->getUsuarioPorId($cd_usuario_caja_abierta);
        $this->parseLabel($xtpl);
        if ($cd_concepto == CD_CONCEPTO_INGRESO && $nu_caja == $nu_caja_abierta) {
            $oMovcaja = FormatUtils::ifEmpty($entidad, new Movcaja());
            $xtpl->assign('cd_movcaja', stripslashes($oMovcaja->getCd_movcaja()));
            $xtpl->assign('dt_movcaja', stripslashes($oMovcaja->getDt_movcaja()));
            $xtpl->assign('ds_observacion', stripslashes($oMovcaja->getDs_observacion()));
            $xtpl->assign('nu_caja', stripslashes($oMovcaja->getNu_caja()));
            $xtpl->assign('nu_etiquetasimple', stripslashes($oMovcaja->getNu_etiquetasimple()));
            $xtpl->assign('nu_etiquetadoble', stripslashes($oMovcaja->getNu_etiquetadoble()));
            $xtpl->assign('cd_usuario', stripslashes($oMovcaja->getCd_usuario()));
            $xtpl->assign('cd_turno', stripslashes($oMovcaja->getCd_turno()));
            $xtpl->assign('idTipoConceptoBono', CD_TIPO_CONCEPTO_BONO);
            $xtpl->assign('idTipoConceptoPractica', CD_TIPO_CONCEPTO_PRACTICA);
            $xtpl->assign('idTipoConceptoReintegro', CD_TIPO_CONCEPTO_REINTEGRO);
            if ($oMovcaja->getCd_movcaja()) {// si se est� editando el movcaja (si tiene ID)
            	$criterio = new CriterioBusqueda();
		        $criterio->addFiltro("OP.cd_movcaja", $oMovcaja->getCd_movcaja(), "=");
		        $oOrdenpracticaManager = new OrdenpracticaManager();
		        $oOrdenpractica = $oOrdenpracticaManager->getOrdenpractica($criterio);
		        if ($oOrdenpractica) {
		        	$this->parseOrdenpractica($oOrdenpractica, $xtpl);
		        }
		        
		        /*$criterio = new CriterioBusqueda();
		        $criterio->addFiltro("cd_movcaja", $oMovcaja->getCd_movcaja(), "=");
		        $oMovcajaconceptoManager = new MovcajaconceptoManager();
		        $oMovcajaconcepto = $oMovcajaconceptoManager->getMovcajaconcepto($criterio);
		        $criterio = new CriterioBusqueda();
		        $criterio->addFiltro("cd_concepto", $oMovcajaconcepto->getCd_concepto(), "=");
		        $oConceptoManager = new ConceptoManager();
		        $oConcepto = $oConceptoManager->getConcepto($criterio);
		        $selected=$oConcepto->getCd_tipoconcepto();*/
		        $criterio = new CriterioBusqueda();
		        $criterio->addFiltro("MCC.cd_movcaja", $oMovcaja->getCd_movcaja(), "=");
		        $oMovcajaconceptoManager = new MovcajaconceptoManager();
		        $oMovcajaconceptos = $oMovcajaconceptoManager->getMovcajaconceptos($criterio);
		        $itemcollection = new ItemCollection();
		        foreach ($oMovcajaconceptos as $oMovcajaconcepto) {
		        	
		        	$collection = new ItemCollection();
			        $collection->addItem($oMovcajaconcepto->getConcepto()->getCd_tipoconcepto(), 'cd_tipoconcepto');
			        $collection->addItem($oMovcajaconcepto->getCd_concepto(), 'cd_concepto');
			        $collection->addItem($oMovcajaconcepto->getConcepto()->getDs_concepto(), 'ds_concepto');
			        if ($oOrdenpractica) {
				        $collection->addItem($oOrdenpractica->getCd_paciente(), 'cd_paciente');
				        $collection->addItem($oOrdenpractica->getCd_profesional(), 'cd_profesional');
				        $collection->addItem($oOrdenpractica->getCd_empleado(), 'cd_empleado');
				        $collection->addItem($oOrdenpractica->getCd_obrasocial(), 'cd_obrasocial');
				        $collection->addItem($oOrdenpractica->getNu_reciboreintegro(), 'nu_reciboreintegro');
			        }
			        $collection->addItem($oMovcajaconcepto->getNu_importe(), 'nu_importe');
			        $collection->addItem($oMovcajaconcepto->getBl_tarjeta(), 'bl_tarjeta');
                    $collection->addItem($oMovcajaconcepto->getBl_digital(), 'bl_digital');
			        $criterio = new CriterioBusqueda();
			       	$criterio->addFiltro("MCC.cd_movcajaconcepto", $oMovcajaconcepto->getCd_movcajaconcepto(), "=");
		            $practicaordenpracticaManager = new PracticaordenpracticaManager();
		            $oPracticaordenpractica = $practicaordenpracticaManager->getPracticaordenpractica($criterio);
		            if (!empty($oPracticaordenpractica)) {
			            if ($oOrdenpractica->getCd_obrasocial()) {
				        	$criterio = new CriterioBusqueda();
					        $criterio->addFiltro("cd_obrasocial", $oOrdenpractica->getCd_obrasocial(), "=");
					        $oObrasocialManager = new ObrasocialManager();
					        $oObrasocial = $oObrasocialManager->getObrasocial($criterio);
				        	$collection->addItem($oObrasocial->getDs_obrasocial(), 'ds_obrasocial');
				        }
			        
			        
			        
			        
		            
				        $criterio = new CriterioBusqueda();
				        $criterio->addFiltro("PO.cd_practicaobrasocial", $oPracticaordenpractica->getPracticaobrasocial()->getCd_practicaobrasocial(), "=");
				        $oPracticaobrasocialManager = new PracticaobrasocialManager();
				        $oPracticaobrasocial = $oPracticaobrasocialManager->getPracticaobrasocial($criterio);
				        $nu_practicaos = $oPracticaobrasocial->getNu_practicaos().' ('.$oPracticaobrasocial->getPractica()->getDs_practica().')';
			        	$collection->addItem($nu_practicaos, 'nu_practicaos');
			        	$collection->addItem($oPracticaordenpractica->getPracticaobrasocial()->getCd_practicaobrasocial(), 'cd_practicaobrasocial');
			        	$collection->addItem($oPracticaordenpractica->getNu_cantplacas(), 'nu_placas');
			        	$collection->addItem($oPracticaordenpractica->getDs_pieza(), 'ds_pieza');
			        	$collection->addItem($oPracticaordenpractica->getCd_aporteos(), 'cd_aporteos');
		            }

			       
			        $itemcollection->addItem($collection);
            	}
            	$_SESSION['movcajaconceptos_session'] = $itemcollection;
		     /*ob_start();
					var_dump($_SESSION['movcajaconceptos_session']);
					CdtUtils::log_debug(ob_get_clean());
					ob_end_clean();*/
		        $this->parseRespuestaAjax($itemcollection, $xtpl);
            }
            
            $xtpl->parse("main.boton_aceptar");
            $xtpl->parse("main.boton_agregar");
            $this->parseTipoconcepto($selected, $xtpl);
        } elseif ($cd_concepto == CD_CONCEPTO_INGRESO && $nu_caja != $nu_caja_abierta) {
            $msj_html = "ERROR: Actualmente Ud no tiene una caja abierta. La caja abierta es la N� $nu_caja_abierta del usuario " . $oUsuarioCajaAbierta->getDs_nomusuario();
            $xtpl->assign('msj', $msj_html);
            $xtpl->parse("main.msj");
        } else {
            $msj_html = "ERROR: Debe <a style='text-decoration:underline;' href='" . WEB_PATH . "doAction?action=abrir_caja_init'>abrir una nueva caja</a> para ingresar un movimiento";
            $xtpl->assign('msj', $msj_html);
            $xtpl->parse("main.msj");
        }

        $xtpl->assign('cd_concepto_practica_particular', CD_CONCEPTO_PRACTICA_PARTICULAR);
        $xtpl->assign('cd_practica_particular', CD_OBRASOCIAL_PARTICULAR);

        $oObraSocialManager = new ObrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_obrasocial", CD_OBRASOCIAL_PARTICULAR, "=");
        $oObraSocial = $oObraSocialManager->getObrasocial($criterio);
        $xtpl->assign('ds_practica_particular', $oObraSocial->getDs_obrasocial());
        
    }

    protected function parseTipoconcepto($selected, XTemplate $xtpl) {

        $manager = new TipoconceptoManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('bl_oculto', 0, "=");
        $tipoconceptos = $manager->getTipoconceptos($criterio);

        foreach ($tipoconceptos as $key => $oTipoconcepto) {

            $xtpl->assign('ds_tipoconcepto', $oTipoconcepto->getDs_tipoconcepto());
            $xtpl->assign('cd_tipoconcepto', FormatUtils::selected($oTipoconcepto->getCd_tipoconcepto(), $selected));

            $xtpl->parse('main.tipoconceptos_option');
        }
    }
    
	protected function parseOrdenpractica(Ordenpractica $oOrdenpractica, XTemplate $xtpl) {

        $xtpl->assign('cd_paciente', stripslashes($oOrdenpractica->getCd_paciente()));
        $xtpl->assign('ds_paciente', stripslashes($oOrdenpractica->getPaciente()->getDs_apynom()));
        $xtpl->assign('cd_profesional', stripslashes($oOrdenpractica->getCd_profesional()));
        $xtpl->assign('ds_profesional', stripslashes($oOrdenpractica->getProfesional()->getDs_nombre()));
        $xtpl->assign('cd_empleado', stripslashes($oOrdenpractica->getCd_empleado()));
        if ($oOrdenpractica->getCd_empleado()) {
        	$criterio = new CriterioBusqueda();
	        $criterio->addFiltro("cd_empleado", $oOrdenpractica->getCd_empleado(), "=");
	        $oEmpleadoManager = new EmpleadoManager();
	        $oEmpleado = $oEmpleadoManager->getEmpleado($criterio);
        	$xtpl->assign('ds_personal', stripslashes($oEmpleado->getDs_nombre()));
        }
        
    }
    
	function parseRespuestaAjax($itemcollection, $xtpl) {
        //$xtpl = $this->getXTemplateAjax();
        $total = 0;
        if ($itemcollection->size() > 0) {
            foreach ($itemcollection as $key => $item) {
            	
            	/*ob_start();
					var_dump($item);
					CdtUtils::log_debug(ob_get_clean());
					ob_end_clean();	*/
                $cd_concepto = $item->getObjectByIndex('cd_concepto');
                $coeficiente = 1;
                if ($cd_concepto != "") {
                    $conceptoManager = new ConceptoManager();
                    $criterio = new CriterioBusqueda();
                    $criterio->addFiltro("cd_concepto", $cd_concepto, "=");
                    $oConcepto = $conceptoManager->getConcepto($criterio);
                    $xtpl->assign('ds_tipoconcepto', ($oConcepto->getTipoconcepto()->getDs_tipoconcepto()));
                    $xtpl->assign('ds_concepto', ($oConcepto->getDs_concepto()));
                    $cd_tipooperacion = $oConcepto->getTipooperacion()->getCd_tipooperacion();
                    $coeficiente = $this->getCoeficiente($cd_tipooperacion);
                    $oConcepto = $conceptoManager->getConcepto($criterio);
                } else {
                    $tipoconceptoManager = new TipoconceptoManager();
                    $cd_tipoconcepto = $item->getObjectByIndex('cd_tipoconcepto');
                    $criterio = new CriterioBusqueda();
                    $criterio->addFiltro("cd_tipoconcepto", $cd_tipoconcepto, "=");
                    $oTipoconcepto = $tipoconceptoManager->getTipoconcepto($criterio);
                    $xtpl->assign('ds_tipoconcepto', ($oTipoconcepto->getDs_tipoconcepto()));
                }
                $xtpl->assign('cd_tipoconcepto', ($item->getObjectByIndex('cd_tipoconcepto')));
               $xtpl->assign('ds_practica', ($item->getObjectByIndex('nu_practicaos')));
                $xtpl->assign('ds_obrasocial', ($item->getObjectByIndex('ds_obrasocial')));
                $xtpl->assign('nu_importe', "$ " . ($item->getObjectByIndex('nu_importe') * $coeficiente));
                $bl_tarjeta = ( $item->getObjectByIndex('bl_tarjeta') )?'SI':'NO';
				$xtpl->assign ( 'ds_posnet', $bl_tarjeta );
                $bl_digital = ( $item->getObjectByIndex('bl_digital') )?'SI':'NO';
                $xtpl->assign ( 'ds_digital', $bl_digital );
                //if (($item->getObjectByIndex('cd_obrasocial') == NULL) || ($item->getObjectByIndex('cd_obrasocial' != NULL) && ($item->getObjectByIndex('cd_obrasocial') != CD_OBRASOCIAL_PARTICULAR) )) {
                if ($item->getObjectByIndex('cd_tipoconcepto') != CD_TIPO_CONCEPTO_PRACTICA || ($item->getObjectByIndex('cd_tipoconcepto') == CD_TIPO_CONCEPTO_PRACTICA && $item->getObjectByIndex('cd_obrasocial') == CD_OBRASOCIAL_PARTICULAR)) {
                    $total += $item->getObjectByIndex('nu_importe') * $coeficiente;
                }
                $xtpl->assign('key', $key + 1);
                $xtpl->parse('main.movscajas_conceptos');
            }
            $xtpl->assign('nu_total', $total);
        }
        /*$xtpl->parse('main');

        echo $xtpl->text('main');*/
    }
    
	protected function getCoeficiente($cd_tipooperacion) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

}

