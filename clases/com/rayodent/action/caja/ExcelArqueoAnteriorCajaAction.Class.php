<?php

/**
 * Acci�n para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelArqueoAnteriorCajaAction extends ExportExcelCollectionAction {
	private $egresos;
	private $totalEgresos;
	public function ExcelArqueoAnteriorCajaAction() {
		$this->egresos = new ItemCollection(); 
		$this->totalEgresos=0;
	}
    protected function getIListar() {
        return new MovcajaManager();
    }

    protected function getTableModel(ItemCollection $items) {
        return new ArqueoCajaExcelTableModel($items);
    }

    protected function getCampoOrdenDefault() {
        return cd_movcaja;
    }

    protected function getCriterioBusqueda() {
        //recuperamos los par�metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

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





                $criterio->addFiltro("MC.nu_caja", $nu_caja, "=");
                $criterio->addFiltro("MC.nu_caja", NU_CAJA_CAJA_CENTRAL, "<>");

        $criterio->addOrden($campoOrden, $orden);
        //$criterio->setPage($page);
        // $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }


     protected function getMonto() {
        $total = 100;
        //Tomo el nu_caja del usuario actual
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);

        $movcajaManager = new MovcajaManager();
         $dt_inicio_filtro = "";
         $hs_inicio_filtro = "00:01";
         $hs_fin_filtro = "23:59";

         $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));
         $dt_fin_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));

         $criterio = new CriterioBusqueda();

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





            $criterio->addFiltro("CA.nu_caja", NU_CAJA_CAJA_CENTRAL, "<>");
            $criterio->addFiltro("CA.nu_caja", $oUsuario->getNu_caja(), "=");
            $monto = $movcajaManager->getMontoTotal($criterio);
            $montoPosnet = $movcajaManager->getMontoTotalPosnet($criterio);
            
            //$montoEfectivo = abs($monto-$montoPosnet);
            $montoEfectivo = ($monto-$montoPosnet);
           

        return $monto." (Efectivo: $".$montoEfectivo." PosNet: $".$montoPosnet.")";

    }


    public function getTitulo() {
        return "Arqueo de caja anterior";
    }

    public function getNombreArchivo() {
        return "ArqueoCajaAnterior";
    }

    protected function getHeader(ItemCollection $entidades, CriterioBusqueda $criterio) {
        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $nu_caja = $oUsuario->getNu_caja();
        $nombreusuario = $oUsuario->getDs_nomusuario();
        $dt_inicio_filtro = FormatUtils::getParam('dt_fecha_filtro', date('d/m/Y'));
        $header = "<p style='text-align:center; font-size:27px; font-family:arial'> Arqueo de caja Nro. ".$nu_caja." (".$nombreusuario.") del dia ".$dt_inicio_filtro."<br/></p>";
        return $header;
    }


    protected function getFooter( ItemCollection $entidades, CriterioBusqueda $criterio ){
            $movcajaManager = new MovcajaManager();
            $monto = $this->getMonto();
            $footer = "<p style='text-align:center; font-size:27px; font-family:arial'> TOTAL ARQUEO CAJA: <b>$monto</b></p>";
            $footer .= "<p style='text-align:left; font-size:27px; font-family:arial'> EGRESOS</p>";
         
            foreach ($this->getEgresos() as $egreso) {
            	//CdtUtils::log_debug($egreso);
            	$egreso = str_replace("<ul>","",$egreso);
            	$egreso = str_replace("<li>","<p style='text-align:left; font-size:27px; font-family:arial'>",$egreso);
            	$egreso = str_replace("</li>","</p>",$egreso);
            	$egreso = str_replace("</ul>","",$egreso);
            	$footer .= trim($egreso);
            }
            $footer .= "<p style='text-align:left; font-size:27px; font-family:arial'>TOTAL GASTOS: <b>$".$this->getTotalEgresos()."</b></p>";
            return $footer;
	}
	
/**
	 * se parsean las filtas.
	 * @param XTemplate $xtpl
	 * @param ItemCollection $items
	 * @return unknown_type
	 */
	protected function parseRows(XTemplate $xtpl, ItemCollection $items){
		$totalEgresos = 0;
		foreach ($items as $key=> $item){
			$arrayTotal = explode('(', $item->getNu_total());
			//CdtUtils::log_debug($arrayTotal[0]);
			$nu_total = str_replace('$','',$arrayTotal[0]);
			if (($nu_total<0)&&(!strpos($item->getDs_detalle(), 'Caja Fija'))) {
				
				$this->getEgresos()->addItem(trim($item->getDs_detalle()));
				$totalEgresos += $nu_total;
				
			}
			
			//parse el item -- main.row.column
			$this->parseItem( $xtpl, $item );			
			
			$xtpl->parse('main.row' );
		}
		$this->setTotalEgresos($totalEgresos*(-1));
		
	}


	public function getEgresos()
	{
	    return $this->egresos;
	}

	public function setEgresos($egresos)
	{
	    $this->egresos = $egresos;
	}

	public function getTotalEgresos()
	{
	    return $this->totalEgresos;
	}

	public function setTotalEgresos($totalEgresos)
	{
	    $this->totalEgresos = $totalEgresos;
	}
}
