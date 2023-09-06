<?php

/**
 * Acci�n para dar de alta un anulacion.
 * 
 * @author modelBuilder
 * @since 22-12-2011
 * 
 */
class AltaAnulacionAction extends EditarAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function getEntidad() {
        //id de la caja a anular
        $cd_movcaja = FormatUtils::getParam('id');

        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("MC.cd_movcaja", $cd_movcaja, "=");

        $movcajaManager = new MovcajaManager();

        $oMovcaja = $movcajaManager->getMovcaja($criterio);
        $oMovcaja->setBl_anulacion("1");
        $movcajaManager->modificarMovcaja($oMovcaja, 1);

        $movcajaconceptosManager = new MovcajaconceptoManager();
        $listado_cajaconceptos = $movcajaconceptosManager->getMovcajaconceptos($criterio);
        $total = 0;
        foreach ($listado_cajaconceptos as $key => $oMovCajaConceptos) {
            $cd_tipooperacion = $oMovCajaConceptos->getConcepto()->getCd_tipooperacion();
            $coeficiente = $this->getCoeficiente($cd_tipooperacion);
            $valor = $oMovCajaConceptos->getNu_importe() * $coeficiente;
            $bl_tarjeta = ($oMovCajaConceptos->getBl_tarjeta())?1:0;
            $bl_digital = ($oMovCajaConceptos->getBl_digital())?1:0;
            if ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() != CD_TIPO_CONCEPTO_PRACTICA || ($oMovCajaConceptos->getConcepto()->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA && $oMovCajaConceptos->getPracticaordenpractica()->getPracticaobrasocial()->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR)) {
                $total += $valor;
            }
        }

        //Creo el concepto de contraasiento
        $oMovcajaconcepto = new Movcajaconcepto();
        $oMovcajaconcepto->setCd_movcaja($cd_movcaja);
        $oMovcajaconcepto->setNu_importe($total);
        $oMovcajaconcepto->setBl_tarjeta($bl_tarjeta);
        $oMovcajaconcepto->setBl_digital($bl_digital);
        if ($total > 0) {
            $oMovcajaconcepto->setCd_concepto(CD_CONCEPTO_CONTRAASIENTO_NEGATIVO);
            $oMovcajaconcepto->setNu_importe($total);
        } elseif ($total <= 0) {
            $oMovcajaconcepto->setCd_concepto(CD_CONCEPTO_CONTRAASIENTO_POSITIVO);
            $oMovcajaconcepto->setNu_importe($total * (-1));
        }
        $movcajaconceptosManager->agregarMovcajaconcepto($oMovcajaconcepto);

        $oAnulacion = new Anulacion ( );
        $oAnulacion->setCd_movcaja($cd_movcaja);
        $oAnulacion->setCd_movcajaconcepto($oMovcajaconcepto->getCd_movcajaconcepto());
        $fechayhora = date('YmdHis');
        $oAnulacion->setDt_anulacion($fechayhora);
        //Obtengo la caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $oAnulacion->setCd_usuario($cd_usuario);
        $oAnulacion->setNu_caja($oUsuario->getNu_caja());
        //TODO: Agregar lo del turno cuando haga la apertura y cierre de caja
        $oAnulacion->setCd_turno(1);

		//por si es apertura o cierre hay que eliminar el proceso de caja
		$criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_movcaja", $cd_movcaja, "=");
        
         $procesocajaManager = new ProcesocajaManager();

        $oProcesoCaja = $procesocajaManager->getProcesocaja($criterio);
        if ($oProcesoCaja) {
        	$procesocajaManager->eliminarProcesocaja($oProcesoCaja->getCd_procesocaja());
        }
        return $oAnulacion;
    }

    protected function getCoeficiente($cd_tipooperacion) {

        $oTipooperacionmanager = new TipooperacionManager();
        return $oTipooperacionmanager->getCoeficiente($cd_tipooperacion);
    }

    protected function editar($oEntidad) {
        $manager = new AnulacionManager();

        $manager->agregarAnulacion($oEntidad);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_anulacion_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_anulacion_error';
    }

    protected function getActionForwardFailure() {
        return 'alta_anulacion_init';
    }

}
