<?php

/**
 * Acci�n listar movcajas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ListarReportePlacasAction extends EditarInitAction {

    protected function getAccionSubmit() {
        return "listar_reporte_placas";
    }

    protected function getTitulo() {
        return "Reporte de placas";
    }

    protected function getEntidad() {
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        $criterio = $this->getCriterioBusqueda();
        $oPracticaOrdenPracticas = $oPracticaOrdenPracticaManager->getPracticaordenpracticas($criterio);
        return $oPracticaOrdenPracticas;
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {
        /*   Resumen diario   */
        $this->parseHeaderTabla($xtpl);
        $this->parseFiltros($xtpl);
        $this->parseRows($xtpl, $entidad);


        /* TOTALES */
        $this->parseFooter($xtpl, $entidad);
    }

    protected function parseFooter($xtpl, $entidad) {
        $criterio = $this->getCriterioBusqueda();
        $content = $this->getFooter($entidad, $criterio);
        $xtpl->assign('footer', $content);
        $xtpl->parse('main.footer');
    }

    protected function parseHeaderTabla($xtpl) {
        $xtpl->assign('dt_movcaja_label', RYT_MOVCAJA_DT_MOVCAJA);
        $xtpl->assign('ds_practica_label', RYT_PRACTICA_DS_PRACTICA);
        $xtpl->assign('nu_cantplacas_label', RYT_PRACTICAORDENPRACTICA_NU_CANTPLACAS);
        $xtpl->assign('nu_cantdigital_label', RYT_PRACTICAORDENPRACTICA_NU_CANTDIGITAL);
        $xtpl->assign('nu_cantnodigital_label', RYT_PRACTICAORDENPRACTICA_NU_CANTNODIGITAL);
    }

    protected function parseFiltros($xtpl) {
        $content = $this->getFiltrosEspeciales();
        $xtpl->assign('filtrosEspeciales', $content);
        $xtpl->parse('main.botones_tabla.filtrosEspeciales');
        $xtpl->parse('main.botones_tabla');
    }

//Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LISTAR_REPORTE_PLACAS);

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

        if ($oUsuario->getCd_perfil() == CD_PERFIL_ADMINISTRADOR) {
            $this->parseComboNuCaja($xtpl, $nu_caja_get);
        } else {
//sino, muestro la caja del usuario
            $xtpl->assign('nu_caja', $oUsuario->getNu_caja());
            $xtpl->parse('main.menu_no_admin');
        }

        $cd_practica = FormatUtils::getParam('cd_practica');
        $this->parseComboPracticas($xtpl, $cd_practica);



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

    protected function parseComboPracticas($xtpl, $selected) {
        $practicaManager = new PracticaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("bl_activa", 1, "=");
        $criterio->addOrden('ds_practica');
        $practicas = $practicaManager->getPracticas($criterio);
        foreach ($practicas as $oPractica) {
            $xtpl->assign('cd_practica', FormatUtils::selected($oPractica->getCd_practica(), $selected));
            $xtpl->assign('ds_practica', $oPractica->getDs_practica());
            $xtpl->parse('main.ds_practica_option');
        }
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
        $cd_practica = FormatUtils::getParam('cd_practica');

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&nu_caja=$nu_caja&cd_practica=$cd_practica";
        return $filtros;
    }

    protected
    function getCriterioBusqueda() {
//recuperamos los par�metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $orden = FormatUtils::getParam('orden', 'ASC');
        $campoOrden = $this->getCampoOrdenDefault();

        $criterio = new CriterioBusqueda();

        $new_criterio = new CriterioBusqueda();

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
            $_SESSION['hs_inicio_filtro_default'] = $hs_inicio_filtro_default;
        }
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $nu_caja = FormatUtils::getParam('nu_caja', "");
        $cd_practica = FormatUtils::getParam('cd_practica', "");
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

        if ($cd_practica != '' && $cd_practica != null) {
            $new_criterio->addFiltro('POS.cd_practica', $cd_practica, "=");
        }
        $new_criterio->addFiltro('bl_anulacion', "0", "=");
        $new_criterio->addOrden($campoOrden, $orden);
//$new_criterio->setPage($page);
        $new_criterio->setRowPerPage(ROW_PER_PAGE);
        return $new_criterio;
    }

    function getCampoOrdenDefault() {
        return 'MC.dt_movcaja';
    }

    protected function getXTemplate() {
        return new XTemplate(TEMPLATE_LISTAR_ORDENPRACTICAS);
    }

    protected function getFooter(ItemCollection $entidades, CriterioBusqueda $criterio) {
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        $totalplacas = $oPracticaOrdenPracticaManager->getTotalPlacas($criterio);
        $totaldigital = $oPracticaOrdenPracticaManager->getTotalDigital($criterio);
        $totalnodigital = $oPracticaOrdenPracticaManager->getTotalNODigital($criterio);
        $placas_por_practicas = $oPracticaOrdenPracticaManager->getTotalPlacasPorPractica($criterio);
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer = "";
        foreach ($placas_por_practicas as $oPracticaOrdenPractica) {
            $html_footer .= "<p style='text-align:left;'>" . $oPracticaOrdenPractica->getDs_practica() . " : " . $oPracticaOrdenPractica->getNu_cantplacas() . " Digitales: ".$oPracticaOrdenPractica->getNu_cantdigital()." NO Digitales: ".$oPracticaOrdenPractica->getNu_cantnodigital()."</p>";
        }
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer .= "<p style='text-align:left;'><b>Cantidad de pacientes: $totalpacientes </b></p>";
        $html_footer .= "<hr/><p style='text-align:left;'>TOTAL DE PLACAS: $totalplacas Digitales: ".$totaldigital." NO Digitales: ".$totalnodigital."</p>";
        return $html_footer;
    }

    protected function getCriterioIds($ids, $dt_movcaja, $primero=0,$ultimo=0) {
        /*$longitud_ids = strlen($ids);
        while (substr($ids, $longitud_ids - 1, $longitud_ids) == ",") {
            $ids = substr($ids, 0, $longitud_ids - 1);
            $longitud_ids = strlen($ids);
        }*/

        //$oCriterio = $this->getCriterioBusqueda();
        $oCriterio =  new CriterioBusqueda();
        /*$ids_array = explode(",", $ids);
        $count = count($ids_array);

        $indice = 0;
        foreach ($ids_array as $id) {
            if ($id != "" && $indice == 0 && $count > 2) {
                $oCriterio->addFiltro('(POS.cd_practica', $id, "=", null, "AND");
            } elseif ($id != "" && $indice == 0 && $count == 2) {
                $oCriterio->addFiltro('POS.cd_practica', $id, "=", null, "AND");
            } elseif ($id != "" && ($count - 1) == ($indice + 1)) {
                $oCriterio->addFiltro('POS.cd_practica', $id . ")", "=", null, "OR");
            } else {
                if ($id != "") {
                    $oCriterio->addFiltro('POS.cd_practica', $id, "=", null, "OR");
                }
            }
            $indice++;
        }*/
        
        
    	$hs_inicio_filtro = ($primero)?FormatUtils::getParam('hs_inicio_filtro', $_SESSION['hs_inicio_filtro_default']):"00:01";
    	$_SESSION['hs_inicio_filtro_default']="00:01";
        $hs_fin_filtro = ($ultimo)?FormatUtils::getParam('hs_fin_filtro', "23:59"):"23:59";
        $nu_caja = FormatUtils::getParam('nu_caja', "");
        $cd_practica = FormatUtils::getParam('cd_practica', "");
        if ($hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            
            $dt_inicio_filtro= $dt_movcaja.$hs_inicio_filtro;
            $oCriterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        }
        if ($hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            
            $dt_fin_filtro=$dt_movcaja.$hs_fin_filtro;

            $oCriterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        }
        if ($nu_caja != "") {
            $oCriterio->addFiltro('nu_caja', $nu_caja, "=");
        } else {
            $cd_usuario = $_SESSION['cd_usuarioSession'];
            $usuarioManager = new UsuarioRYTManager();
            $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
//Si es Admin, muestro el listado de cajas

            if ($oUsuario->getCd_perfil() != CD_PERFIL_ADMINISTRADOR) {
                $oCriterio->addFiltro('nu_caja', $oUsuario->getNu_caja(), "=");
            }
        }

        if ($cd_practica != '' && $cd_practica != null) {
            $oCriterio->addFiltro('POS.cd_practica', $cd_practica, "=");
        }
        $oCriterio->addFiltro('bl_anulacion', "0", "=");
        //$oCriterio->addFiltro('MC.dt_movcaja', "'$dt_movcaja%'", "LIKE", null, "AND");
        return $oCriterio;
    }

    protected function parseRows(XTemplate $xtpl, ItemCollection $items) {
        $par = false;
        $dt_old = "";
        $i = 0;
        $primero = 1;
        /*$total = $items->size();
        $ids = "";*/
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        foreach ($items as $key => $item) {
            if ($i != 0 && substr($item->getDt_movcaja(), 0, 8) != substr($dt_old, 0, 8)) {
				
                $criterio = $this->getCriterioIds($ids, substr($dt_old, 0, 8),$primero,0);
                $primero=0;
                $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
                $xtpl->assign('nu_cantpacientes', $totalpacientes);
                $ids = "";
                $xtpl->parse('main.row.rowtotal');
                $this->parseItemVacio($xtpl);
                $xtpl->parse('main.row');
            }
            $this->parseItem($xtpl, $item);
            $xtpl->parse('main.row');
            $dt_old = $item->getDt_movcaja();
            $i = $i + 1;
            /*$par = !$par;
            $ids .= $item->getPracticaobrasocial()->getCd_practica() . ",";*/
        }
        $criterio = $this->getCriterioIds($ids, substr($dt_old, 0, 8),$primero,1);
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $xtpl->assign('nu_cantpacientes', $totalpacientes);
        $xtpl->parse('main.row.rowtotal');
        $this->parseItemVacio($xtpl);
        $xtpl->parse('main.row');
    }

    protected function parseItem($xtpl, $item) {
        $xtpl->assign('dt_movcaja', substr(FuncionesComunes::fechaHoraMysqlaPHP($item->getDt_movcaja()), 0, 10));
        $xtpl->assign('ds_practica', $item->getDs_practica());
        $xtpl->assign('nu_cantplacas', $item->getNu_cantplacas());
        $xtpl->assign('nu_cantdigital', $item->getNu_cantdigital());
        $xtpl->assign('nu_cantnodigital', $item->getNu_cantnodigital());
    }

    protected function parseItemVacio($xtpl) {
        $xtpl->assign('dt_movcaja', "");
        $xtpl->assign('ds_practica', "");
        $xtpl->assign('nu_cantplacas', "");
        $xtpl->assign('nu_cantdigital', "");
        $xtpl->assign('nu_cantnodigital', "");
    }

}

