<?php


class ListarResumenPlacasAction extends EditarInitAction {

    protected function getAccionSubmit() {
        return "listar_resumen_placas";
    }

    protected function getTitulo() {
        return "Resumen de placas";
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
        $xtpl->assign('nu_montoplacas_label', RYT_PRACTICAORDENPRACTICA_NU_IMPORTE);
        
    }

    protected function parseFiltros($xtpl) {
        $content = $this->getFiltrosEspeciales();
        $xtpl->assign('filtrosEspeciales', $content);
        $xtpl->parse('main.botones_tabla.filtrosEspeciales');
        $xtpl->parse('main.botones_tabla');
    }

//Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LISTAR_RESUMEN_PLACAS);

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', date('d/m/Y'));
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
       
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial');
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial');
    
        $xtpl->assign('dt_inicio_filtro', $dt_inicio_filtro);
        $xtpl->assign('dt_fin_filtro', $dt_fin_filtro);
       
        $xtpl->assign('ds_obrasocial', $ds_obrasocial);
        $xtpl->assign('cd_obrasocial', $cd_obrasocial);


     
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    

    

    /**
     * se obtienen los<filtros especiales para pasar por get (url)
     * @param $xtpl
     */
    protected function getFiltrosEspecialesQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial', "");

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&cd_obrasocial=$cd_obrasocial&ds_obrasocial=$ds_obrasocial";
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

        
        
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $hs_fin_filtro = "23:59";

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', date('d/m/Y'));
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        
        
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "");
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
        

        if ($cd_obrasocial != '' && $cd_obrasocial != null) {
            $new_criterio->addFiltro('POS.cd_obrasocial', $cd_obrasocial, "=");
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
        return new XTemplate(TEMPLATE_LISTAR_RESUMENPLACAS);
    }

    protected function getFooter(ItemCollection $entidades, CriterioBusqueda $criterio) {
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        $totalplacas = $oPracticaOrdenPracticaManager->getTotalPlacas($criterio);
        $totaldigital = $oPracticaOrdenPracticaManager->getTotalDigital($criterio);
        $totalnodigital = $oPracticaOrdenPracticaManager->getTotalNODigital($criterio);
        $montoplacas = $oPracticaOrdenPracticaManager->getTotalMontoPlacas($criterio);
        $placas_por_practicas = $oPracticaOrdenPracticaManager->getTotalPlacasPorPractica($criterio);
        //$totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer = "";
        foreach ($placas_por_practicas as $oPracticaOrdenPractica) {
            $html_footer .= "<p style='text-align:left;'>" . $oPracticaOrdenPractica->getDs_practica() . " : " . $oPracticaOrdenPractica->getNu_cantplacas() . " (".$oPracticaOrdenPractica->getNu_importealiquidar().") Digitales: ".$oPracticaOrdenPractica->getNu_cantdigital()." NO Digitales: ".$oPracticaOrdenPractica->getNu_cantnodigital()."</p>";
        }
        /*$totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer .= "<p style='text-align:left;'><b>Cantidad de pacientes: $totalpacientes </b></p>";*/
        $html_footer .= "<hr/><p style='text-align:left;'>TOTAL DE PLACAS: $totalplacas ( $".$montoplacas.") Digitales: ".$totaldigital." NO Digitales: ".$totalnodigital."</p>";
        return $html_footer;
    }

    protected function getCriterioIds($ids, $dt_movcaja) {
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
        
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $hs_fin_filtro = "23:59";
        
    	
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "");
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
        

        if ($cd_obrasocial != '' && $cd_obrasocial != null) {
            $oCriterio->addFiltro('POS.cd_obrasocial', $cd_obrasocial, "=");
        }
        $oCriterio->addFiltro('bl_anulacion', "0", "=");
        //$oCriterio->addFiltro('MC.dt_movcaja', "'$dt_movcaja%'", "LIKE", null, "AND");
        return $oCriterio;
    }

    protected function parseRows(XTemplate $xtpl, ItemCollection $items) {
        $par = false;
        $dt_old = "";
        $i = 0;
        $total = $items->size();
        $ids = "";
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        foreach ($items as $key => $item) {
            if ($i != 0 && substr($item->getDt_movcaja(), 0, 8) != substr($dt_old, 0, 8)) {

                $criterio = $this->getCriterioIds($ids, substr($dt_old, 0, 8));
                /*$totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
                $xtpl->assign('nu_cantpacientes', $totalpacientes);*/
                $ids = "";
                $xtpl->parse('main.row.rowtotal');
                $this->parseItemVacio($xtpl);
                $xtpl->parse('main.row');
            }
            $this->parseItem($xtpl, $item);
            $xtpl->parse('main.row');
            $dt_old = $item->getDt_movcaja();
            $i = $i + 1;
            $par = !$par;
            $ids .= $item->getPracticaobrasocial()->getCd_practica() . ",";
        }
        $criterio = $this->getCriterioIds($ids, substr($dt_old, 0, 8));
        /*$totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $xtpl->assign('nu_cantpacientes', $totalpacientes);*/
        $xtpl->parse('main.row.rowtotal');
        $this->parseItemVacio($xtpl);
        $xtpl->parse('main.row');
    }

    protected function parseItem($xtpl, $item) {
        $xtpl->assign('dt_movcaja', substr(FuncionesComunes::fechaHoraMysqlaPHP($item->getDt_movcaja()), 0, 10));
        $xtpl->assign('ds_practica', $item->getDs_practica());
        $xtpl->assign('nu_cantplacas', $item->getNu_cantplacas());
        $xtpl->assign('nu_cantplacas', $item->getNu_cantplacas());
        $xtpl->assign('nu_cantdigital', $item->getNu_cantdigital());
        $xtpl->assign('nu_cantnodigital', $item->getNu_cantnodigital());
        $xtpl->assign('nu_montoplacas', $item->getNu_importealiquidar());
    }

    protected function parseItemVacio($xtpl) {
        $xtpl->assign('dt_movcaja', "");
        $xtpl->assign('ds_practica', "");
        $xtpl->assign('nu_cantplacas', "");
        $xtpl->assign('nu_cantdigital', "");
        $xtpl->assign('nu_cantnodigital', "");
        $xtpl->assign('nu_montoplacas', "");
    }

}

