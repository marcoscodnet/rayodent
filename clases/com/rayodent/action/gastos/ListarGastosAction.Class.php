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
class ListarGastosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new MovcajaTableModel($items);
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
        $criterio = $this->getCriterioBusqueda();
        //Si el ultimo proceso de caja fue un ingreso, entonces est� abierta
   
        $monto = $movcajaManager->getMontoTotalGastos($criterio);
        $xtpl->assign('total', $monto);
        return parent::parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);
    }

    protected function getCriterioBusqueda() {
        //recuperamos los par�metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $new_criterio = new CriterioBusqueda();
        //Filtro Especial

        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $movcajaManager = new MovcajaManager();
     
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $nu_caja = FormatUtils::getParam('nu_caja', "");
        $cd_concepto_get = FormatUtils::getParam('cd_concepto', "");
        if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $new_criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        }
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;

            $new_criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        }
        if ($nu_caja != "") {
            $new_criterio->addFiltro('nu_caja', $nu_caja, "=");
        } else {
            $cd_usuario = $_SESSION['cd_usuarioSession'];
            $usuarioManager = new UsuarioRYTManager();
            $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
            //Si es Admin, muestro el listado de cajas

            if ($oUsuario->getCd_perfil() != CD_PERFIL_ADMINISTRADOR) {
                $new_criterio->addFiltro('nu_caja', $oUsuario->getNu_caja(), "=");
            }
        }
    	if ($cd_concepto_get != "") {
            $new_criterio->addFiltro('C.cd_concepto', $cd_concepto_get, "=");
        }
        $this->addSelectedFiltro($new_criterio, $campoFiltro, $filtro);
        $new_criterio->addOrden($campoOrden, $orden);
        $new_criterio->setPage($page);
        $new_criterio->setRowPerPage(ROW_PER_PAGE);
        return $new_criterio;
    }

    protected function getEntidadManager() {
        return new GastosManager();
    }

    protected function getCampoOrdenDefault() {
        return 'MC.cd_movcaja';
    }

    protected function getTitulo() {
        return 'Gastos';
    }

    protected function getUrlAccionListar() {
        return 'listar_gastos';
    }

    protected function getForwardError() {
        return 'listar_movcajas_error';
    }

    protected function getMenuActivo() {
        return "Movcajas";
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_LISTAR_GASTOS);
    }

    protected function getFiltrosEspecialesQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $nu_caja = FormatUtils::getParam('nu_caja');
		$cd_concepto_get = FormatUtils::getParam('cd_concepto');
        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&nu_caja=$nu_caja&cd_concepto=$cd_concepto_get";
        return $filtros;
    }

    //Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LISTAR_GASTOS);

        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "";
        $movcajaManager = new MovcajaManager();
        $rta = $movcajaManager->hayCajaAbierta($oUsuario->getNu_caja());
        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_turno = $rta['cd_turno'];
        if ($cd_concepto == CD_CONCEPTO_INGRESO) {
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("cd_movcaja", $cd_movcaja, "=");
            $oMovcaja = $movcajaManager->getMovcaja($criterio);
            $fechayhora = FuncionesComunes::fechaHoraMysqlaPHP($oMovcaja->getDt_movcaja());
            $fechayhora = explode(" ", $fechayhora);
            $dt_inicio_filtro_default = $fechayhora[0];
            $hs_inicio_filtro_default = substr($fechayhora[1], 0, 5);
        }
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");


        $xtpl->assign('dt_inicio_filtro', $dt_inicio_filtro);
        $xtpl->assign('dt_fin_filtro', $dt_fin_filtro);
        $xtpl->assign('hs_inicio_filtro', $hs_inicio_filtro);
        $xtpl->assign('hs_fin_filtro', $hs_fin_filtro);


        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
        //Si es Admin, muestro el listado de cajas

        $nu_caja_get = FormatUtils::getParam('nu_caja');
        $cd_concepto_get = FormatUtils::getParam('cd_concepto');

        if ($oUsuario->getCd_perfil() == CD_PERFIL_ADMINISTRADOR) {
            $this->parseComboNuCaja($xtpl, $nu_caja_get);
            $this->parseComboConcepto($xtpl, $cd_concepto_get);
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
    
 	protected function parseComboConcepto($xtpl, $selected) {
 		$criterio = new CriterioBusqueda();
        
        $criterio->addFiltro("C.cd_tipoconcepto", 8, "=");
        $criterio->addOrden("ds_concepto");
        $managerConcepto = new ConceptoManager();
        $conceptos = $managerConcepto->getConceptos($criterio);
        
        foreach ($conceptos as $key => $oConcepto) {
            $xtpl->assign('ds_concepto', utf8_encode($oConcepto->getDs_concepto()));
            $xtpl->assign('cd_concepto', FormatUtils::selected($oConcepto->getCd_concepto(), $selected));
             $xtpl->parse('main.menu_admin2.conceptos_option');
        }
        
        $xtpl->parse('main.menu_admin2');
    }

}

