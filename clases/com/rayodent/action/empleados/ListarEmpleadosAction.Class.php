<?php

/**
 * Acción listar empleados.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ListarEmpleadosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new EmpleadoTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaempleado', 'Agregar Empleado', 'alta_empleado_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_empleado', RYT_EMPLEADO_CD_EMPLEADO);
				
		$filtros[] = $this->buildFiltro('cd_tipodocumento', RYT_EMPLEADO_CD_TIPODOCUMENTO);
				
		$filtros[] = $this->buildFiltro('nu_documento', RYT_EMPLEADO_NU_DOCUMENTO);
				
		$filtros[] = $this->buildFiltro('ds_nombre', RYT_EMPLEADO_DS_NOMBRE);
				
		$filtros[] = $this->buildFiltro('cd_tipopersonal', RYT_EMPLEADO_CD_TIPOPERSONAL);
				
		$filtros[] = $this->buildFiltro('ds_domicilio', RYT_EMPLEADO_DS_DOMICILIO);
				
		$filtros[] = $this->buildFiltro('ds_telefono', RYT_EMPLEADO_DS_TELEFONO);
				
		$filtros[] = $this->buildFiltro('ds_email', RYT_EMPLEADO_DS_EMAIL);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_empleado(), 'empleado', 'empleado', true, true, true);
    }


    protected function getEntidadManager() {
        return new EmpleadoManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_empleado';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Empleados';
    }

    protected function getUrlAccionListar() {
        return 'listar_empleados';
    }

    protected function getForwardError() {
        return 'listar_empleados_error';
    }

    protected function getMenuActivo() {
        return "Empleados";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_EMPLEADO);
        $xtpl->assign('cd_empleado', $entidad->getCd_empleado());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
