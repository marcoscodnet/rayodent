<?php

/**
 * Acci�n para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelReportePlacasAction extends Action {

    protected function getLayoutExcel() {
        return new LayoutExcel();
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EXCEL_REPORTE_PLACAS);
    }

    public function execute() {
        $layout = $this->getLayoutExcel();
        $layout->setNombreArchivo($this->getNombreArchivo());
        $layout->setContenido($this->getContenido());
        $layout->setTitulo($this->getTitulo());
        echo $layout->show();
        $forward = null;
        return $forward;
    }

    protected function getEntidades($criterio) {
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        //$criterio = $this->getCriterioBusqueda();
        $oPracticaOrdenPracticas = $oPracticaOrdenPracticaManager->getPracticaordenpracticas($criterio);
        return $oPracticaOrdenPracticas;
    }

    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a exportar.
        $criterio = $this->getCriterioBusqueda();
        $entidades = $this->getEntidades($criterio);
        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $entidades, $criterio);
        return $content;
    }

    /*
     * se parsea la salida utilizando xtemplate.
     */

    private function parseContenido(XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio) {

        $this->parseHeader($xtpl);
        /*   Resumen diario   */
        $this->parseHeaderTabla($xtpl);
        $this->parseRows($xtpl, $entidades);

        /* TOTALES */
        $this->parseFooter($xtpl, $entidades);

        $xtpl->parse('main');
        return $xtpl->text('main');
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

    /**
     * se parsea un header para el listado.
     * @param $xtpl
     * @param $entidades
     * @param $campoFiltro
     * @param $filtro
     * @return unknown_type
     */
    protected function parseHeader(XTemplate $xtpl) {
        //Recupero los par�metros

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
        $cd_practica = FormatUtils::getParam('cd_practica', "");
        if ($dt_fin_filtro == "") {
            $dt_fin_filtro = "(No ingresada)";
        }
        if ($nu_caja == "") {
            $nu_caja = "Todas";
        }
        if ($cd_practica == "") {
            $ds_practica = "Todas";
        } else {
            $oPracticaManager = new PracticaManager();
            $criterio = New CriterioBusqueda();
            $criterio->addFiltro("cd_practica", $cd_practica, "=");
            $oPractica = $oPracticaManager->getPractica($criterio);
            $ds_practica = $oPractica->getDs_practica();
        }


        $content = "<h2>Listado de placas</h2>";
        $content .= "Fecha desde: $dt_inicio_filtro<br/>";

        $content .= "Fecha hasta: $dt_fin_filtro <br/>";
        $content .= "Caja Nº: $nu_caja <br/>";
        $content .= "Pr�ctica: $ds_practica <br/><br/>";
        $xtpl->assign('header', $content);
        $xtpl->parse('main.header');
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
// $item =new  Practicaordenpractica();

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

    protected function getCriterioIds($ids, $dt_movcaja, $primero=0,$ultimo=0) {
        /*$oCriterio = $this->getCriterioBusqueda();
        $ids_array = explode(",", $ids);
        $count = count($ids_array);
        $indice = 0;
        foreach ($ids_array as $id) {
            if ($indice == 0 && $count > 2) {
                $oCriterio->addFiltro('(POS.cd_practica', $id, "=", null, "AND");
            } elseif ($indice == 0 && $count == 2) {
                $oCriterio->addFiltro('POS.cd_practica', $id, "=", null, "AND");
            } elseif (($count - 1) == ($indice + 1)) {
                $oCriterio->addFiltro('POS.cd_practica', $id . ")", "=", null, "OR");
            } else {
                if ($id != "") {
                    $oCriterio->addFiltro('POS.cd_practica', $id, "=", null, "OR");
                }
            }
            $indice++;
        }
        $oCriterio->addFiltro('MC.dt_movcaja', "'$dt_movcaja%'", "LIKE", null, "AND");
        return $oCriterio;*/
    	 $oCriterio =  new CriterioBusqueda();
       
        
        
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
      
        return $oCriterio;
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

    protected function getCampoOrdenDefault() {
        return "MC.dt_movcaja";
    }

    protected function getCriterioBusqueda() {
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $orden = 'ASC';
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

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

        if ($cd_practica != '' && $cd_practica != "") {
            $new_criterio->addFiltro('POS.cd_practica', $cd_practica, "=");
        }
        $new_criterio->addOrden($campoOrden, $orden);
        $new_criterio->setRowPerPage(ROW_PER_PAGE);
        return $new_criterio;
    }

    public function getTitulo() {
        return "Reporte de placas";
    }

    public function getNombreArchivo() {
        return "reporte_placas";
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
            $html_footer .= "<p style='text-align:center;'>" . $oPracticaOrdenPractica->getDs_practica() . " : " . $oPracticaOrdenPractica->getNu_cantplacas() . " Digitales: ".$oPracticaOrdenPractica->getNu_cantdigital()." NO Digitales: ".$oPracticaOrdenPractica->getNu_cantnodigital()."</p>";
        }
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer .= "<p style='text-align:center;'><b>Cantidad de pacientes: $totalpacientes </b></p>";
        $html_footer .= "<hr/><p style='text-align:center;'>TOTAL DE PLACAS: $totalplacas Digitales: ".$totaldigital." NO Digitales: ".$totalnodigital."</p>";
        return $html_footer;
    }

}
