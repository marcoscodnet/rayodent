<?php

/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Factory para usuario.
 *
 */
class UsuarioRYTFactory extends UsuarioFactory {

    /**
     * construye un usuario.
     * @param $next
     * @return unknown_type
     */
    public function build($next) {
        $oUsuario = new UsuarioRYT();
        $oUsuario->setDs_nomusuario($next ['ds_nomusuario']);
        $oUsuario->setCd_usuario($next ['cd_usuario']);
        $oUsuario->setCd_perfil($next ['cd_perfil']);
        $oUsuario->setCd_pais($next ['cd_pais']);
        $oUsuario->setDs_apynom($next ['ds_apynom']);
        $oUsuario->setDs_mail($next ['ds_mail']);
        $oUsuario->setNu_caja($next ['nu_caja']);
        $oUsuario->setDs_password($next ['ds_password']);
        $oUsuario->setDs_telefono($next ['ds_telefono']);

        //para el caso que se hace el join con el perfil.
        if (array_key_exists('ds_perfil', $next)) {
            $perfilFactory = new PerfilFactory();
            $oUsuario->setPerfil($perfilFactory->build($next));
        }

        //para el caso que se hace el join con el pais.
        if (array_key_exists('ds_pais', $next)) {
            $paisFactory = new PaisFactory();
            $oUsuario->setPais($paisFactory->build($next));
        }

        return $oUsuario;
    }

}
?>