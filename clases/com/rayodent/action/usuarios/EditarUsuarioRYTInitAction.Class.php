<?php

/**
 * Acción para inicializar el contexto para editar
 * un almacén.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarUsuarioRYTInitAction extends EditarInitAction {

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

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oUsuario = FormatUtils::ifEmpty($entidad, new UsuarioRYT());
        $xtpl->assign('ds_apynom', stripslashes($oUsuario->getDs_apynom()));
        $xtpl->assign('ds_mail', stripslashes($oUsuario->getDs_mail()));
        $xtpl->assign('nu_caja', stripslashes($oUsuario->getNu_caja()));
        $xtpl->assign('ds_nomusuario', stripslashes($oUsuario->getDs_nomusuario()));
        $xtpl->assign('ds_telefono', stripslashes($oUsuario->getDs_telefono()));
        $xtpl->assign('cd_usuario', $oUsuario->getCd_usuario());


        $perfilManager = new PerfilManager();
        $perfiles = $perfilManager->getPerfiles();

        foreach ($perfiles as $key => $perfil) {
            $xtpl->assign('ds_perfil', $perfil->getDs_perfil());
            $xtpl->assign('cd_perfil', FormatUtils::selected($perfil->getCd_perfil(), $oUsuario->getCd_perfil()));

            $xtpl->parse('main.option');
        }

        $paisManager = new PaisManager();
        $paises = $paisManager->getPaises();

        foreach ($paises as $key => $pais) {
            $xtpl->assign('ds_pais', $pais->getDs_pais());
            $xtpl->assign('cd_pais', FormatUtils::selected($pais->getCd_pais(), $oUsuario->getCd_pais()));

            $xtpl->parse('main.option_pais');
        }
    }

}