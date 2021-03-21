<?php

/**
 * Acción para editar un almacén.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioRYTAction extends EditarUsuarioAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
     */
    protected function getEntidad() {
        $oUsuario = new UsuarioRYT ( );

        if (isset($_POST ['cd_usuario']))
            $oUsuario->setCd_usuario(FormatUtils::getParamPOST('cd_usuario'));

        if (isset($_POST ['usuario']))
            $oUsuario->setDs_nomusuario(FormatUtils::getParamPOST('usuario'));

        if (isset($_POST ['apynom']))
            $oUsuario->setDs_apynom(FormatUtils::getParamPOST('apynom'));

        if (isset($_POST ['mail']))
            $oUsuario->setDs_mail(FormatUtils::getParamPOST('mail'));

        if (isset($_POST ['pass']))
            $oUsuario->setDs_password(FormatUtils::getParamPOST('pass'));

        if (isset($_POST ['perfil']))
            $oUsuario->setCd_perfil(FormatUtils::getParamPOST('perfil'));

        if (isset($_POST ['pais']))
            $oUsuario->setCd_pais(FormatUtils::getParamPOST('pais'));

        if (isset($_POST ['telefono']))
            $oUsuario->setDs_telefono(FormatUtils::getParamPOST('telefono'));

        if (isset($_POST ['nu_caja']))
            $oUsuario->setNu_caja(FormatUtils::getParamPOST('nu_caja'));

        return $oUsuario;
    }

}