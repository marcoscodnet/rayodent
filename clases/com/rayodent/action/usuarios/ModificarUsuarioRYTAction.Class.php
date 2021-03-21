<?php

/**
 * Acción para modificar un usuario.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ModificarUsuarioRYTAction extends EditarUsuarioRYTAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $manager = new UsuarioRYTManager();
        $manager->modificarUsuario($oEntidad);
    }

    protected function getForwardSuccess() {
        return 'modificar_usuarioryt_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_usuarioryt_error';
    }

}