<?php

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelLiquidacionAction extends ExportExcelCollectionAction {

    protected function getIListar() {
        return new MovcajaManager();
    }

    protected function getTableModel(ItemCollection $items) {
        return new LiquidacionExcelTableModel($items);
    }

    protected function getCampoOrdenDefault() {
        return cd_movcaja;
    }

    public function getTitulo() {
        return "Liquidaci&oacute;n";
    }

    public function getNombreArchivo() {
        return "liquidacion";
    }

    /**
     * se listan entidades.
     * @return boolean (true=exito).
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a exportar.
        $criterio = $this->getCriterioBusqueda();
        $entidades = $this->getIListar()->getMovcajasDeLiquidacionParaOS($criterio, $criterio->getValorFiltro('POS.cd_obrasocial'));
        $this->tableModel = $this->getTableModel($entidades);

        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $entidades, $criterio);

        return $content;
    }

    private function parseContenido(XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio) {
    	
    	foreach ($criterio->getFiltros() as $key => $campo_operador_valor) {
			$campo = $campo_operador_valor['campo'];
			$valor = $campo_operador_valor['valor'];
			$operador = $campo_operador_valor['operador'];
			if ($campo == 'POS.cd_obrasocial') {
				$oObraSocialManager = new ObrasocialManager();
		        $oCriterio = new CriterioBusqueda();
		        $oCriterio->addFiltro("cd_obrasocial", $valor, "=");
		        $oObraSocial = $oObraSocialManager->getObrasocial($oCriterio);
			}
    		if ($campo == 'dt_movcaja') {
    			$arrayFecha [0] = substr($valor, 6, 2);
		        $arrayFecha [1] = substr($valor, 4, 2);
		        $arrayFecha [2] = substr($valor, 0, 4);
		        $fechaPHP = implode("/", $arrayFecha);
		        $arrayHora [0] = substr($valor, 8, 2);
		        $arrayHora [1] = substr($valor, 10, 2);
		        $arrayHora [2] = substr($valor, -2);
		        $horaPHP = implode(":", $arrayHora);
				if ($operador=='>=') {
			        $dt_inicio_filtro=$fechaPHP . ' ' . $horaPHP;
				}
				else {
			        $dt_fin_filtro=$fechaPHP . ' ' . $horaPHP;
				}
    			
			}
			
			
		}
    
		//header del listado.
        $this->parseHeader($xtpl, $entidades, $criterio);
		
    	$xtpl->assign('value', 'Obra Social: '.$oObraSocial->getDs_obrasocial());
        $xtpl->parse('main.row.column');
        $xtpl->parse('main.row');
        $xtpl->assign('value', 'Per&iacute;odo: '.$dt_inicio_filtro.' - '.$dt_fin_filtro);
        $xtpl->parse('main.row.column');
		$xtpl->parse('main.row');
       	$xtpl->parse('main');
        

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
                $criterio = $this->getCriterioBusquedaDeTotal();
                $oMovCajaManager = new MovcajaManager();
                $monto = $oMovCajaManager->getMontoTotalDeObraSocial($criterio);
                $xtpl->assign('value', "<b>$monto</b>");
                $xtpl->parse('main.row.column');
            }
            $i++;
        }
        $xtpl->parse('main.row');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    function getCriterioBusquedaComun() {
        //recuperamos los parï¿½metros.
        $criterio = new CriterioBusqueda();
        $new_criterio = new CriterioBusqueda();
        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial', "");
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

        $criterio->addFiltro('POS.cd_obrasocial', $cd_obrasocial, "=");
        $criterio->addOrden($campoOrden, $orden);

        return $criterio;
    }

    function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $criterio = $this->getCriterioBusquedaComun();
        $criterio->addFiltro('MC.bl_anulacion', "0", "=");
        return $criterio;
    }

    function getCriterioBusquedaDeTotal() {
        //recuperamos los parï¿½metros.
        $criterio = $this->getCriterioBusquedaComun();
        $criterio->addFiltro('CA.bl_anulacion', "0", "=");
        return $criterio;
    }
    
	protected function parseHeader( XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio ){
		$xtpl->assign( 'header', '<span style="font-weight:bold; font-size: x-large;font-style:italic;font-family:verdana;">Rayodent</span><br><span style="font-size: large;font-style:italic;font-family:verdana;">Av 44 nº 511 (entre 5 y 6)</span><br><span style="font-weight:bold; font-size: large;font-style:italic;font-family:verdana;">La Plata</span><span style="font-size: large;font-style:italic;font-family:verdana;">- Provincia de Buenos Aires</span><br><span style="font-weight:bold; font-size: large;font-style:italic;font-family:verdana;">Tel. </span><span style="font-size: large;font-style:italic;font-family:verdana;">(0221)4212481 / 0800 222 3392</span><br><span style="font-weight:bold; font-size: large;font-style:italic;font-family:verdana;">Cuit </span><span style="font-size: large;font-style:italic;font-family:verdana;">27-12991440-3</span>');
		$xtpl->parse('main.header');
	
	}

	

}
