<?php

/**
  ESTO ES EL TOTAL POR CADA MOVIMIENTO DE CAJA

  SELECT CA.cd_movcaja, SUM( MCC.nu_importe * T.nu_coeficiente )
  FROM movcaja CA, movcajaconcepto MCC, concepto C, tipooperacion T
  WHERE C.cd_concepto = MCC.cd_concepto
  AND T.cd_tipooperacion = C.cd_tipooperacion
  AND CA.cd_movcaja = MCC.cd_movcaja
  GROUP BY CA.cd_movcaja

 *
 *
 * //Esto es el total
 * select SUM(importe) from (
  SELECT CA.cd_movcaja , SUM(MCC.nu_importe * T.nu_coeficiente) as importe
  FROM movcaja CA, movcajaconcepto MCC , concepto C , tipooperacion T
  WHERE C.cd_concepto =MCC.cd_concepto
  AND T.cd_tipooperacion =C.cd_tipooperacion
  AND CA.cd_movcaja = MCC.cd_movcaja
  GROUP BY CA.cd_movcaja ) as caja

 */
class ArqueoCajaAnteriorAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new ArqueoCajaTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = array();
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        // $this->parseAccionesDefault($xtpl, $item, $item->getCd_movcaja(), 'movcaja', 'movcaja', true, false, false, true);
    }

    protected function parseContenido(XTemplate $xtpl, $filtro, $oPaginador, $query_string, $entidades, CriterioBusqueda $criterio) {
        $total = 100;
        //Tomo el nu_caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);

        $movcajaManager = new MovcajaManager();
        /*$rta = $movcajaManager->hayCajaAbierta($oUsuario->getNu_caja());

        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_usuario_caja_abierta = $rta['cd_usuario'];
        $nu_caja_abierta = $rta['nu_caja'];
        $oUsuarioCajaAbierta = $usuarioManager->getUsuarioPorId($cd_usuario_caja_abierta);

        //Si el ultimo proceso de caja fue un ingreso, entonces est� abierta

        if ($cd_concepto == CD_CONCEPTO_INGRESO && $nu_caja_abierta == $oUsuario->getNu_caja()) {*/
            //Tomo todos movimientos posteriores a ese nigreso
            $criterio = new CriterioBusqueda();

        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $hs_fin_filtro = "23:59";

        $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));
        $dt_fin_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));



        //if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
        $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
        $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
        $dt_inicio_filtro .=$hs_inicio_filtro;
        $criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        /*}
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {*/
        $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
        $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
        $dt_fin_filtro .=$hs_fin_filtro;

        $criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        // }


            //$criterio->addFiltro("CA.cd_movcaja", $cd_movcaja, ">=");
            $criterio->addFiltro("CA.nu_caja", NU_CAJA_CAJA_CENTRAL, "<>");
            $criterio->addFiltro("CA.nu_caja", $oUsuario->getNu_caja(), "=");

            $monto = $movcajaManager->getMontoTotal($criterio);
            $montoPosnet = $movcajaManager->getMontoTotalPosnet($criterio);
            //$efectivo = abs($monto-$montoPosnet);
            $efectivo = ($monto-$montoPosnet);
        $xtpl->assign( 'accion_listar', 'arquear_caja_anterior' );
        $xtpl->assign('total', $monto.' (Efectivo: $'.$efectivo.' PosNet: $'.$montoPosnet.')' );
        return parent::parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);
    }



    protected function parseFiltros($xtpl) {
        $content = $this->getFiltrosEspeciales();
        $xtpl->assign('filtrosEspeciales', $content);
        $xtpl->parse('main.botones_tabla.filtrosEspeciales');
        $xtpl->parse('main.botones_tabla');
    }

    //Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_ARQUEO_CAJA_ANTERIOR);

        $dt_fecha_filtro = FormatUtils::getParam('dt_fecha_filtro', date("d/m/Y"));


        $xtpl->assign('dt_fecha_filtro', $dt_fecha_filtro);

        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
        //Si es Admin, muestro el listado de cajas

        $nu_caja_get = FormatUtils::getParam('nu_caja');
        $cd_concepto_get = FormatUtils::getParam('cd_concepto');

        if ($oUsuario->getCd_perfil() == CD_PERFIL_ADMINISTRADOR) {
            $this->parseComboNuCaja($xtpl, $nu_caja_get);
            //$this->parseComboApertura($xtpl, $cd_concepto_get);
        } else {
            //sino, muestro la caja del usuario
            $xtpl->assign('nu_caja', $oUsuario->getNu_caja());
            $xtpl->parse('main.menu_no_admin');
        }




        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function parseComboNuCaja($xtpl, $selected) {
        $usuarioManager = new UsuarioRYTManager();
        $criterio = new CriterioBusqueda();
        $nu_cajas = $usuarioManager->getNuCajas();
        foreach ($nu_cajas as $key => $nu_caja) {
            $xtpl->assign('nu_caja_value', FormatUtils::selected($nu_caja, $selected));
            $xtpl->assign('nu_caja', $nu_caja);
            $xtpl->parse('main.menu_admin.nu_caja_option');
        }

        $xtpl->parse('main.menu_admin');
    }

    /**
     * se obtienen los<filtros especiales para pasar por get (url)
     * @param $xtpl
     */
    protected function getFiltrosEspecialesQueryString() {
        $filtros = "";
        $dt_fecha_filtro = FormatUtils::getParam('dt_fecha_filtro');


        $filtros .= "&dt_fecha_filtro=$dt_fecha_filtro";
        return $filtros;
    }


    protected function getCriterioBusqueda() {
        //recuperamos los par�metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();


        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $nu_caja = $oUsuario->getNu_caja();

        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $hs_fin_filtro = "23:59";

        $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));
        $dt_fin_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));



        //if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        /*}
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {*/
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;

            $criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
       // }


        //if ($nu_caja != "" && $nu_caja != null) {
            $movcajaManager = new MovcajaManager();
            /*$rta = $movcajaManager->hayCajaAbierta($nu_caja);
            $cd_concepto = $rta['cd_concepto'];
            $cd_movcaja = $rta['cd_movcaja'];
            if ($cd_concepto == CD_CONCEPTO_INGRESO) {*/
                //Tomo todos movimientos posteriores a ese nigreso
                /*$criterio = new CriterioBusqueda();
                $criterio->addFiltro("MC.cd_movcaja", $cd_movcaja, ">=");*/
                $criterio->addFiltro("MC.nu_caja", $nu_caja, "=");
                $criterio->addFiltro("MC.nu_caja", NU_CAJA_CAJA_CENTRAL, "<>");

        //}
        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $criterio->addOrden($campoOrden, $orden);
        //$criterio->setPage($page);
        // $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }


    protected function getEntidadManager() {
        return new MovcajaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'MC.cd_movcaja';
    }

    protected function getTitulo() {
        return 'Arqueo de cajas Anteriores';
    }

    protected function getUrlAccionListar() {
        return 'listar_movcajas';
    }

    protected function getForwardError() {
        return 'listar_movcajas_error';
    }

    protected function getMenuActivo() {
        return "Movcajas";
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_ARQUEO_CAJA);
    }

    protected function getUrlAccionExportarExcel() {
        return 'excel_arqueo_caja_anterior';
    }
}

