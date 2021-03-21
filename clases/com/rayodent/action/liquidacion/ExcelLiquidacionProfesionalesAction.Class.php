<?php

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelLiquidacionProfesionalesAction extends ExportExcelCollectionAction {

    protected function getIListar() {
        return new PracticaordenpracticaManager();
    }

    protected function getTableModel(ItemCollection $items) {
        return new LiquidarProfesionalExcelTableModel($items);
    }

    protected function getCampoOrdenDefault() {
        return "POP.cd_practicaordenpractica";
    }

    public function getTitulo() {
        return "Liquidaci&oacute;n Profesionales";
    }

    public function getNombreArchivo() {
        return "Liquidacion profesional";
    }

    /**
     * se listan entidades.
     * @return boolean (true=exito).
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $valor = FormatUtils::getParam('valor', '');
        $tipo = FormatUtils::getParam('tipo', '');

        //obtenemos las entidades a exportar.
        $criterio = $this->getCriterioBusqueda();
        $entidades = $this->getIListar()->getPracticaordenpracticasDeLiquidacion($criterio, $valor, $tipo);
        $this->tableModel = $this->getTableModel($entidades);

        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $entidades, $criterio);

        return $content;
    }

    private function parseContenido(XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio) {


        //header del listado.
        $this->parseHeader($xtpl, $entidades, $criterio);

        //encabezados (ths) de la tabla.
        $this->parseTHs($xtpl);

        //se parsean los elementos a mostrar
        $this->parseRows($xtpl, $entidades);

        //footer del listado.
        $this->parseFooter($xtpl, $entidades, $criterio);

        //Agrego una fila con el total
        $i = 1;
        while ($i <= 3) {
            if ($i == 1) {
                $xtpl->assign('value', "");
                $xtpl->parse('main.row.column');
            }
            if ($i == 2) {
                $xtpl->assign('value', "TOTAL");
                $xtpl->parse('main.row.column');
            }
            if ($i == 3) {
                $criterio = $this->getCriterioBusqueda();
                $valor = addslashes(FormatUtils::getParam('valor', ''));
                $tipo = addslashes(FormatUtils::getParam('tipo', ''));
                $oPracticaordenpracticaManager = new PracticaOrdenpracticaManager();
                $monto = $oPracticaordenpracticaManager->getTotalALiquidar($criterio, $valor, $tipo);
                $xtpl->assign('value', "<b>$monto</b>");
                $xtpl->parse('main.row.column');
            }
            $i++;
        }
        $xtpl->parse('main.row');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $criterio = new CriterioBusqueda();

        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $ds_profesional = FormatUtils::getParam('ds_profesional', "");
        $cd_liquidacionprofesional = FormatUtils::getParam('cd_liquidacionprofesional', "");

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

        //if (& $ds_profesional != "") {
        $criterio->addFiltro('OP.cd_profesional', $cd_profesional, "=");
        $criterio->addFiltro('MC.bl_anulacion', "0", "=");

        //si viene blanco, listo los que son null
        //si viene un valor, esporque quiere listar el resultado de la liquidación,
        //por lo que lo incluyo en el filtro.
        if ($cd_liquidacionprofesional == "") {
            $criterio->addFiltro("POP.cd_liquidacionprofesional", "IS NULL", " ");
        } else {
            $criterio->addFiltro("POP.cd_liquidacionprofesional", $cd_liquidacionprofesional, "=");
        }


        $criterio->addOrden($campoOrden, $orden);

        return $criterio;
    }

}
