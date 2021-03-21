<?php

/**
 * Acción para inicializar el contexto para modificar
 * un usuario.
 *  
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ModificarUsuarioRYTInitAction extends EditarUsuarioRYTInitAction {

    protected function getEntidad() {
        $oUsuario = null;

        if (isset($_GET ['id'])) {
            //recuperamos dado su identifidor.
            $id = FormatUtils::getParam('id');

            $criterio = new CriterioBusqueda();
            $criterio->addFiltro('cd_usuario', $id, '=');

            $manager = new UsuarioRYTManager();
            $oUsuario = $manager->getUsuario($criterio);
        } else {

            $oUsuario = parent::getEntidad();
        }
        return $oUsuario;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_MODIFICAR_USUARIO);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Modificar Usuario";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "modificar_usuarioryt";
    }

}