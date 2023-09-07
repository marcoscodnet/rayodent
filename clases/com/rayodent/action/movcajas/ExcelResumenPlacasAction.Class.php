<?php

/**
 * Acci�n para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelResumenPlacasAction extends Action {

    protected function getLayoutExcel() {
        return new LayoutExcel();
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EXCEL_RESUMEN_PLACAS);
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
        $xtpl->assign('nu_montoplacas_label', RYT_PRACTICAORDENPRACTICA_NU_IMPORTE);
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

        
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
         $hs_fin_filtro = "23:59";
		
         
         $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        
        
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "");
         
        
		
        
        if ($dt_fin_filtro == "") {
            $dt_fin_filtro = "(No ingresada)";
        }
        
        if ($cd_obrasocial == "") {
            $ds_obrasocial = "Todas";
        } else {
            $oObrasocialManager = new ObrasocialManager();
            $criterio = New CriterioBusqueda();
            $criterio->addFiltro("cd_obrasocial", $cd_obrasocial, "=");
            $oObrasocial = $oObrasocialManager->getObrasocial($criterio);
            $ds_obrasocial = $oObrasocial->getDs_obrasocial();
        }


        $content = "<h2>Resumen de placas</h2>";
        $content .= "Fecha desde: $dt_inicio_filtro<br/>";

        $content .= "Fecha hasta: $dt_fin_filtro <br/>";
        
        $content .= "Obra Social: $ds_obrasocial <br/><br/>";
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
        $oCriterio =  new CriterioBusqueda();
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

    protected function parseItem($xtpl, $item) {
        $xtpl->assign('dt_movcaja', substr(FuncionesComunes::fechaHoraMysqlaPHP($item->getDt_movcaja()), 0, 10));
        $xtpl->assign('ds_practica', $item->getDs_practica());
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

    protected function getCampoOrdenDefault() {
        return "MC.dt_movcaja";
    }

    protected function getCriterioBusqueda() {
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

    public function getTitulo() {
        return "Resumen de placas";
    }

    public function getNombreArchivo() {
        return "resumen_placas";
    }

    protected function getFooter(ItemCollection $entidades, CriterioBusqueda $criterio) {
        $oPracticaOrdenPracticaManager = new PracticaordenpracticaManager();
        $totalplacas = $oPracticaOrdenPracticaManager->getTotalPlacas($criterio);
        $totaldigital = $oPracticaOrdenPracticaManager->getTotalDigital($criterio);
        $totalnodigital = $oPracticaOrdenPracticaManager->getTotalNODigital($criterio);
        $montoplacas = $oPracticaOrdenPracticaManager->getTotalMontoPlacas($criterio);
        $placas_por_practicas = $oPracticaOrdenPracticaManager->getTotalPlacasPorPractica($criterio);
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        $html_footer = "";
        foreach ($placas_por_practicas as $oPracticaOrdenPractica) {
            $html_footer .= "<p style='text-align:center;'>" . $oPracticaOrdenPractica->getDs_practica() . " : " . $oPracticaOrdenPractica->getNu_cantplacas() . " (".$oPracticaOrdenPractica->getNu_importealiquidar().") Digitales: ".$oPracticaOrdenPractica->getNu_cantdigital()." NO Digitales: ".$oPracticaOrdenPractica->getNu_cantnodigital()."</p>";
        }
        $totalpacientes = $oPracticaOrdenPracticaManager->getTotalPacientes($criterio);
        //$html_footer .= "<p style='text-align:center;'><b>Cantidad de pacientes: $totalpacientes </b></p>";
        $html_footer .= "<hr/><p style='text-align:center;'>TOTAL DE PLACAS: $totalplacas  ( $".$montoplacas.") Digitales: ".$totaldigital." NO Digitales: ".$totalnodigital."</p>";
        return $html_footer;
    }

}
