<?php

/**
 * Acción listar contactos.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ListarContactosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new ContactoTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altacontacto', 'Agregar Contacto', 'alta_contacto_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();
        $filtros[] = $this->buildFiltro('ds_apynom', RYT_CONTACTO_DS_APYNOM);
        $filtros[] = $this->buildFiltro('nu_documento', RYT_CONTACTO_NU_DOCUMENTO);
        $filtros[] = $this->buildFiltro('nu_cuit', RYT_CONTACTO_NU_CUIT);
        $filtros[] = $this->buildFiltro('ds_telefono', RYT_CONTACTO_DS_TELEFONO);
        $filtros[] = $this->buildFiltro('ds_movil', RYT_CONTACTO_DS_MOVIL);
        $filtros[] = $this->buildFiltro('ds_telefonotrabajo', RYT_CONTACTO_DS_TELEFONOTRABAJO);
        $filtros[] = $this->buildFiltro('ds_direccion', RYT_CONTACTO_DS_DIRECCION);
        $filtros[] = $this->buildFiltro('ds_email', RYT_CONTACTO_DS_EMAIL);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_contacto(), 'contacto', 'contacto', true, true, true);
    }

    protected function getEntidadManager() {
        return new ContactoManager();
    }

    protected function getCampoOrdenDefault() {
        return 'ds_apynom';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Contactos';
    }

    protected function getUrlAccionListar() {
        return 'listar_contactos';
    }

    protected function getForwardError() {
        return 'listar_contactos_error';
    }

    protected function getMenuActivo() {
        return "Contactos";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_CONTACTO);
        $xtpl->assign('cd_contacto', $entidad->getCd_contacto());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }
    
	protected function getOrdenDefault() {
        return 'ASC';
    }
    
	protected function addSelectedFiltro($criterio,$campoFiltro, $filtro){

		if(substr( $campoFiltro,0,3) == 'dt_' ){
			if( !empty( $filtro ))
			$criterio->addFiltro($campoFiltro, $filtro, '=', new FormatValorDate());
		}
		else
		$criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLikeContacto());
	}

}
