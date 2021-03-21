<?php

/**
 * Acción listar usuarios.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ListarUsuariosRYTAction extends ListarUsuariosAction {

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altausuario', 'Agregar Usuario', 'alta_usuarioryt_init');
        return $opciones;
    }

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;

        if ($ver) {
            $href = 'doAction?action=ver_' . $nombre_entidad . 'ryt&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'search.gif', 'detalles de ' . $lbl_entidad);
        }

        if ($modificar) {
            $href = 'doAction?action=modificar_' . $nombre_entidad . 'ryt_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'edit.gif', 'editar datos de ' . $lbl_entidad);
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_" . $nombre_entidad . "&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'del.gif', 'eliminar ' . $lbl_entidad);
        }
    }

    protected function getUrlAccionListar() {
        return 'listar_usuariosryt';
    }

    protected function getUrlAccionExportarPdf() {
        return false;
    }

    protected function getUrlAccionExportarExcel() {
        return false;
    }

}