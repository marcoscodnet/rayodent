<?php

/**
 * Acción listar movcajas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ListarMovcajasAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new MovcajaTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altamovcaja', 'Agregar Movimiento Caja', 'alta_movcaja_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        $this->parseAccionesDefault($xtpl, $item, $item->getCd_movcaja(), 'movcaja', 'Movimientos de Caja', true, true, false, true);
    }

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true, $anular=true, $imprimir = true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;

        if ($ver) {
            $href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'search.gif', 'Ver detalles de ' . $lbl_entidad);
        }

        if ($modificar) {
            $href = 'doAction?action=modificar_' . $nombre_entidad . '_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'edit.gif', 'editar datos de ' . $lbl_entidad);
        }
        if ($imprimir) {
            $href = 'doAction?action=pdf_etiqueta_movcaja&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'etiqueta.png', 'Imprimir Etiqueta');
        }
        if ($imprimir) {
            $href = 'doAction?action=pdf_etiqueta_doble_movcaja&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'etiqueta-doble.png', 'Imprimir Etiqueta Doble');
        }
        if ($imprimir) {
            $href = 'doAction?action=pdf_factura_movcaja&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'imprimir-factura.png', 'Imprimir Factura');
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_" . $nombre_entidad . "&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'del.gif', 'eliminar ' . $lbl_entidad);
        }
        if ($anular) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelAnular($entidad) . "', this,'doAction?action=alta_anulacion&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'anular.png', 'Anular ' . $lbl_entidad);
        }
    }

    protected function getEntidadManager() {
        return new MovcajaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'MC.cd_movcaja';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Movimiento de caja';
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

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_MOVCAJA);
        $xtpl->assign('cd_movcaja', $entidad->getCd_movcaja());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function getCartelAnular($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_ANULAR_MOVCAJA);
        $xtpl->assign('cd_movcaja', $entidad->getCd_movcaja());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    //Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LISTAR_MOVCAJAS);

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
        $ds_paciente = urldecode(FormatUtils::getParam('ds_paciente', ""));
        $cd_paciente = FormatUtils::getParam('cd_paciente', "");

        $xtpl->assign('dt_inicio_filtro', $dt_inicio_filtro);
        $xtpl->assign('dt_fin_filtro', $dt_fin_filtro);
        $xtpl->assign('hs_inicio_filtro', $hs_inicio_filtro);
        $xtpl->assign('hs_fin_filtro', $hs_fin_filtro);
        $xtpl->assign('ds_paciente', $ds_paciente);
        $xtpl->assign('cd_paciente', $cd_paciente);


        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
        //Si es Admin, muestro el listado de cajas

        $nu_caja_get = FormatUtils::getParam('nu_caja');

        if ($oUsuario->getCd_perfil() == CD_PERFIL_ADMINISTRADOR) {
            $this->parseComboNuCaja($xtpl, $nu_caja_get);
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
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $nu_caja = FormatUtils::getParam('nu_caja');
        $ds_paciente = FormatUtils::getParam('ds_paciente');
        $cd_paciente = FormatUtils::getParam('cd_paciente');

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&nu_caja=$nu_caja&cd_paciente=$cd_paciente&ds_paciente=$ds_paciente";
        return $filtros;
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();
        //$criterio->put('campoFiltro', $campoFiltro);
        //$criterio->put('filtro', $filtro);

        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $new_criterio = new CriterioBusqueda();
        //Filtro Especial

        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
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

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $nu_caja = FormatUtils::getParam('nu_caja', "");
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

        $cd_paciente = FormatUtils::getParam('cd_paciente', "");
        if ($cd_paciente != "") {
            $new_criterio->addFiltro('OP.cd_paciente', $cd_paciente, "=");
        }

        $new_criterio->addOrden($campoOrden, $orden);
        $new_criterio->setPage($page);
        $new_criterio->setRowPerPage(ROW_PER_PAGE);
        return $new_criterio;
    }

    protected function getXTemplate() {
        return new XTemplate(TEMPLATE_LISTAR_MOVCAJAS);
    }

    protected function getUrlAccionExportarExcel() {
        return 'excel_movcajas';
    }

}

