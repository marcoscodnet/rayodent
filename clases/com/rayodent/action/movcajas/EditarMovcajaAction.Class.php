<?php

/**
 * Acci�n para editar un movcaja.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarMovcajaAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
     */
    protected function getEntidad() {

        //se construye el movcaja a modificar.
        $oMovcaja = new Movcaja ( );
        $oMovcaja->setCd_movcaja(FormatUtils::getParamPOST('cd_movcaja'));
        $oMovcaja->setDt_movcaja(FormatUtils::getParamPOST('dt_movcaja'));
        $oMovcaja->setDs_observacion(FormatUtils::getParamPOST('ds_observacion'));
        $oMovcaja->setCd_turno(FormatUtils::getParamPOST('cd_turno'));
        $oMovcaja->setNu_etiquetasimple(FormatUtils::getParamPOST('nu_etiquetasimple'));
        $oMovcaja->setNu_etiquetadoble(FormatUtils::getParamPOST('nu_etiquetadoble'));
        //Obtengo la caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();

        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);

        $oMovcaja->setNu_caja($oUsuario->getNu_caja());

        //Obtengo el usuario en sesi�n

        $oMovcaja->setCd_usuario($cd_usuario);



        $oMovcaja->setBl_anulacion(0);


        return $oMovcaja;
    }

    protected function getEntidadAjax() {
        //se construye el movcaja a modificar.
        $collection = new ItemCollection();
        $cd_tipoconcepto = FormatUtils::getParamPOST('cd_tipoconcepto');
        $collection->addItem($cd_tipoconcepto, 'cd_tipoconcepto');
        $collection->addItem(FormatUtils::getParamPOST('cd_concepto'), 'cd_concepto');
        $collection->addItem(FormatUtils::getParamPOST('ds_concepto'), 'ds_concepto');
        $collection->addItem(FormatUtils::getParamPOST('cd_paciente'), 'cd_paciente');
        $collection->addItem(FormatUtils::getParamPOST('cd_profesional'), 'cd_profesional');
        $collection->addItem(FormatUtils::getParamPOST('cd_empleado'), 'cd_empleado');
        $collection->addItem(FormatUtils::getParamPOST('cd_obrasocial'), 'cd_obrasocial');
        $collection->addItem(FormatUtils::getParamPOST('ds_obrasocial'), 'ds_obrasocial');
        $collection->addItem(FormatUtils::getParamPOST('nu_importe'), 'nu_importe');
        $collection->addItem(FormatUtils::getParamPOST('bl_tarjeta'), 'bl_tarjeta');
        $collection->addItem(FormatUtils::getParamPOST('bl_digital'), 'bl_digital');
        $collection->addItem(FormatUtils::getParamPOST('nu_reciboreintegro'), 'nu_reciboreintegro');
        $collection->addItem(FormatUtils::getParamPOST('nu_practicaos'), 'nu_practicaos');
        $collection->addItem(FormatUtils::getParamPOST('cd_practicaobrasocial'), 'cd_practicaobrasocial');
        $collection->addItem(FormatUtils::getParamPOST('nu_placas'), 'nu_placas');
        $collection->addItem(FormatUtils::getParamPOST('ds_pieza'), 'ds_pieza');
        $collection->addItem(FormatUtils::getParamPOST('cd_aporteos'), 'cd_aporteos');
        $collection->addItem(FormatUtils::getParamPOST('cd_ordenpractica'), 'cd_ordenpractica');
        

        return $collection;
    }

    protected function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    public function execute() {

        //se inicia una transacci�n.
        if (!$this->isAjax()) {
            DbManager::begin_tran();

            try {

                $oEntidad = $this->getEntidad();
                $forward = $this->getForwardSuccess();

                $this->editar($oEntidad);

                //commit de la transacci�n.
                DbManager::save();
            } catch (GenericException $ex) {
                //rollback de la transacci�n.
                DbManager::undo();
                CdtUtils::log_debug('failure en EditarAction => forward: ' . $this->getForwardError());
                $forward = $this->doForwardException($ex, $this->getForwardError());
            }
        } else {
            $oEntidad = $this->getEntidadAjax();
            $this->editar($oEntidad);
            $forward = 0;
        }

        return $forward;
    }

    function getLayout() {
        if ($this->isAjax()) {
            new LayoutSimple();
        } else {
            parent::getLayout();
        }
    }

    function parseRespuestaAjax($itemcollection) {
        $xtpl = $this->getXTemplateAjax();
        $total = 0;
        if ($itemcollection->size() > 0) {
            foreach ($itemcollection as $key => $item) {
            	//print_r($item);
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
               $xtpl->assign('ds_practica', ($item->getObjectByIndex('nu_practicaos')));
                $xtpl->assign('ds_obrasocial', utf8_encode($item->getObjectByIndex('ds_obrasocial')));
                $xtpl->assign('nu_importe', "$ " . utf8_encode($item->getObjectByIndex('nu_importe') * $coeficiente));
                $bl_tarjeta = ( $item->getObjectByIndex('bl_tarjeta') )?'SI':'NO';
                $bl_digital = ( $item->getObjectByIndex('bl_digital') )?'SI':'NO';
				$xtpl->assign ( 'ds_posnet', $bl_tarjeta );
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
        $xtpl->parse('main');

        echo $xtpl->text('main');
    }

    protected function getCoeficiente($cd_tipooperacion) {
        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

}

