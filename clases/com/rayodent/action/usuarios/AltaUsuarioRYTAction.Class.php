<?php

/**
 * Acción para dar de alta un usuario.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class AltaUsuarioRYTAction extends EditarUsuarioRYTAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $manager = new UsuarioRYTManager();
        $manager->agregarUsuario($oEntidad);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'alta_usuarioryt_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'alta_usuarioryt_error';
    }

}