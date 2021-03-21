<?php

/**
 * Acción para dar de alta un liquidacionprofesional.
 * 
 * @author modelBuilder
 * @since 11-01-2012
 * 
 */
class AltaLiquidacionprofesionalAction extends EditarLiquidacionprofesionalAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {

        /*
         * genera un movimiento de caja de ?extracciï¿½n caja central por liq prof?
         * por el monto total a liquidar,
         * ademï¿½s se deberï¿½ almacenar el registro correspondiente en la tabla ?liquidacionprofesional?,
         * como asï¿½ tambiï¿½n, a cada practica de orden practica involucrado a la liquidaciï¿½n,
         * se deberï¿½ tener un campo ?cd_liquidacionprofesional? e incluir el cï¿½digo correspondiente.
         */
        unset($_SESSION['movcajaconceptos_session']);
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
        //SI HAY UNA CAJA ABIERTA
        if ($cd_concepto == CD_CONCEPTO_INGRESO) {

            /* +------------------------------------------------------+
             * |    Creo el movimiento de caja para la caja central   |
             * +------------------------------------------------------+ */

            $oMovcajaCentral = new Movcaja();
            $oMovcajaCentral->setNu_caja(NU_CAJA_CAJA_CENTRAL);
            //Obtengo el usuario actual
            $cd_usuario = $_SESSION['cd_usuarioSession'];
            $oMovcajaCentral->setCd_usuario($cd_usuario);
            $hoyyahora = date('YmdHis');
            $oMovcajaCentral->setDt_movcaja($hoyyahora);
            $oMovcajaCentral->setCd_turno($cd_turno);
            $oMovcajaCentral->setDs_observacion("Liquidación de profesional");
            $movcajaManager->agregarMovcaja($oMovcajaCentral);

            /* +------------------------------------------------------+
             * | Almaceno el concepto aociado al movimiento de caja   |
             * +------------------------------------------------------+ */

            $oMovcajaconceptoCentral = new Movcajaconcepto();
            $oMovcajaconceptoCentral->setCd_movcaja($oMovcajaCentral->getCd_movcaja());

            $criterio = $this->getCriterioBusqueda();
            $valor = addslashes(FormatUtils::getParam('valor', ''));
            $tipo = addslashes(FormatUtils::getParam('tipo', ''));
            $oPracticaordenpracticaManager = new PracticaordenpracticaManager();
            $monto = $oPracticaordenpracticaManager->getTotalALiquidar($criterio, $valor, $tipo);
            $oMovcajaconceptoCentral->setNu_importe($monto);
            $oMovcajaconceptoCentral->setCd_concepto(CD_CONCEPTO_EGRESO_LIQUIDACION_PROFESIONAL);
            $oMovcajaconceptoManager = new MovcajaconceptoManager();
            $oMovcajaconceptoManager->agregarMovcajaconcepto($oMovcajaconceptoCentral);

            //Agrego la tuple correspondiente en la tabla Liquidaciï¿½n profesional
            $manager = new LiquidacionprofesionalManager();
            $oEntidad->setCd_movcaja($oMovcajaCentral->getCd_movcaja());
            $manager->agregarLiquidacionprofesional($oEntidad);

            //Recupero las prcaticas ordenpractica y le seteo el cd_liquidaciï¿½nprofesional
            $listado = $oPracticaordenpracticaManager->getPracticaordenpracticasDeLiquidacion($criterio, $valor, $tipo);
            foreach ($listado as $oPracticaordenpractica) {
                $oPracticaordenpractica->setCd_liquidacionprofesional($oEntidad->getCd_liquidacionprofesional());
                $oPracticaordenpracticaManager->modificarPracticaordenpractica($oPracticaordenpractica);
            }
            echo urldecode($this->getURLQueryString() . "&cd_liquidacionprofesional=" . $oEntidad->getCd_liquidacionprofesional());
        } else {
            return("ERROR: No se puede abrir una nueva caja porque ya hay una caja abierta. Debe <a style='text-decoration:underline;' href='" . WEB_PATH . "doAction?action=cerrar_caja_init'>cerrar la caja</a> para abrir una nueva");
            //$xtpl->assign('msj', $msj_html);
            //$xtpl->parse("main.msj");
        }
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return '';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return '';
    }

    protected function getActionForwardFailure() {
        return '';
    }

    protected function getCriterioBusqueda() {

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', 'MC.cd_movcaja');

        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();

        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $ds_profesional = FormatUtils::getParam('ds_profesional', "");

        if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        }

        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;

            $criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        }

        $criterio->addFiltro('OP.cd_profesional', $cd_profesional, "=");
        $criterio->addFiltro('MC.bl_anulacion', "0", "=");
        $criterio->addFiltro("POP.cd_liquidacionprofesional", "IS NULL", " ");

        $criterio->addOrden($campoOrden, $orden);

        return $criterio;
    }

    protected function getURLQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $valor = addslashes(FormatUtils::getParam('valor', ''));
        $tipo = addslashes(FormatUtils::getParam('tipo', ''));

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&cd_profesional=$cd_profesional&valor=$valor&tipo=$tipo";
        return $filtros;
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
