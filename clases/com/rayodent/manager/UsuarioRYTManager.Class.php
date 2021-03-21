<?php

/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Manejador de lógica de negocio para usuarios.
 *
 */
class UsuarioRYTManager extends UsuarioManager {

    public function createAndGetUsuario($ds_nomusuario) {

        try {

            $oUsuario = $this->getUsuarioPorNombre($ds_nomusuario);
        } catch (GenericException $ex) {

            //no existe, lo creamos.
            $oUsuario = new Usuario();
            $aux = explode('@', $ds_nomusuario);
            $oUsuario->setDs_apynom($aux[0]);
            $oUsuario->setDs_mail($ds_nomusuario);
            $oUsuario->setDs_password($ds_nomusuario);
            $oUsuario->setDs_nomusuario($ds_nomusuario);
            //setear el perfil por default.
            $oPerfil = new Perfil();
            $oPerfil->setCd_perfil(CDT_SEGURIDAD_PERFIL_DEFAULT_ID);
            $oPerfil = PerfilQuery::getPerfilPorId($oPerfil);
            $oUsuario->setPerfil($oPerfil);

            $this->agregarUsuario($oUsuario);

            $oUsuario = $this->getUsuarioPorNombre($ds_nomusuario);
        }

        return $oUsuario;
    }

    /**
     * se agrega un usuario.
     * @param $oUsuario usuario a agregar.
     * @return boolean (true=exito).
     */
    public function agregarUsuario($oUsuario) {

        //validaciones
        if (UsuarioRYTQuery::existeNombreUsuario($oUsuario))
            throw new GenericException(CDT_SEGURIDAD_MSG_USUARIO_REPETIDO);

        //persistir el usuario en la bbdd.
        UsuarioRYTQuery::insertUsuario($oUsuario);
    }


    public function getNuCajas(){
        return UsuarioRYTQuery::getNuCajas();
    }
    /**
     * se modifica un usuario.
     * @param $oUsuario usuario a agregar.
     * @return boolean (true=exito).
     */
    public function modificarUsuario($oUsuario) {

        //validaciones
        if (UsuarioRYTQuery::existeNombreUsuario($oUsuario))
            throw new GenericExeption(CDT_SEGURIDAD_MSG_USUARIO_REPETIDO);

        //persistir los cambios del usuario en la bbdd.
        UsuarioRYTQuery::modificarUsuario($oUsuario);

        //TODO postcondiciones / manejo de errores.
        //throw new Exception('some ErrorMailing Message', 500, $oZFHttpEx);
    }

    /**
     * eliminar un usuario.
     * @param $cd_usuario identificador del usuario a eliminar
     * @return boolean (true=exito).
     */
    public function eliminarUsuario($cd_usuario) {

        $oUsuario = new Usuario ();
        $oUsuario->setCd_usuario($cd_usuario);

        //TODO validaciones.
        //persistir el cambio en la bbdd.
        UsuarioQuery::eliminarUsuario($oUsuario);

        //TODO postcondiciones / manejo de errores.
    }

    /**
     * se listan usuarios.
     * @param $criterio
     * @return itemCollection
     */
    public function getUsuarios(CriterioBusqueda $criterio) {

        $usuarios = UsuarioQuery::getUsuariosConPerfil($criterio);

        return $usuarios;
    }

    public function getUsuarioPorNombre($ds_nomusuario) {

        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('ds_nomusuario', $ds_nomusuario, '=', new FormatValorString());

        $usuarios = UsuarioQuery::getUsuariosConPerfil($criterio);

        if ($usuarios->size() > 0)
            return $usuarios->getObjectByIndex(0);
        else
            throw new GenericException(CDT_SEGURIDAD_MSG_USUARIO_NO_EXISTE);
    }

    public function getUsuarioPorMail($ds_mail) {

        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('ds_mail', $ds_mail, '=', new FormatValorString());

        $usuarios = UsuarioQuery::getUsuariosConPerfil($criterio);

        if ($usuarios->size() > 0)
            return $usuarios->getObjectByIndex(0);
        else
            throw new GenericException(CDT_SEGURIDAD_MSG_USUARIO_NO_EXISTE);
    }

    /**
     * obtiene un usuario específico dado un identificador.
     * @param $cd_usuario identificador del usuario a recuperar
     * @return usuario
     */
    public function getUsuarioPorId($cd_usuario) {
        $oUsuario = new Usuario ();
        $oUsuario->setCd_usuario($cd_usuario);
        $oUsuario = UsuarioRYTQuery::getUsuarioPorId($oUsuario);
        return $oUsuario;
    }

    /**
     * obtiene un usuario específico junto con su perfil dado un identificador.
     * @param $cd_usuario identificador del usuario a recuperar
     * @return usuario con perfil asociado.
     */
    public function getUsuarioConPerfilPorId($cd_usuario) {
        $oUsuario = new Usuario ();
        $oUsuario->setCd_usuario($cd_usuario);
        $oUsuario = UsuarioRYTQuery::getUsuarioConPerfilPorId($oUsuario);
        return $oUsuario;
    }

    /**
     * se obtiene el usuario dado el criterio de bï¿½squeda.
     */
    public function getUsuario(CriterioBusqueda $criterio) {

        $usuarios = UsuarioRYTQuery::getUsuariosConPerfil($criterio);

        if ($usuarios->size() > 0)
            return $usuarios->getObjectByIndex(0);

        else
            return null;
    }

    /**
     * obtiene la cantidad de usuarios dado un filtro.
     * @param $filtro filtro de búsqueda.
     * @return cantidad de usuarios
     */
    public function getCantidadUsuarios(CriterioBusqueda $criterio) {
        return UsuarioQuery::getCantUsuarios($criterio);
    }

    public function cambiarClave($cd_usuario, $clave_actual, $clave_nueva) {
        $clave_actual = MD5($clave_actual);

        $oUsuario = $this->getUsuarioPorId($cd_usuario);
        $pass = $oUsuario->getDs_password();

        if (strcmp($clave_actual, $pass) == 0) {
            $oUsuario->setDs_password($clave_nueva);
            UsuarioQuery::modificarUsuario($oUsuario);
        } else {
            throw new PasswordIncorrectaException();
        }
    }

    public function login($nombre_usuario, $clave) {

        $oUsuario = $this->getUsuarioPorNombre($nombre_usuario);

        //vemos si coincide la clave ingresada.
        $clave = md5($clave);
        if ($clave != $oUsuario->getDs_password())
            throw new GenericException(CDT_SEGURIDAD_MSG_PASSWORD_INCORRECTA);

        //buscamos las funciones que puede realizar el usuario.
        $oUsuario->setFunciones(FuncionQuery::getFuncionesDeUsuario($oUsuario));

        //iniciamos la sesión.
        $oUsuario->iniciarSesion();
    }

    public function registrar(Usuario $oUsuario) {

        //chequeamos el captcha.
        //TODO ver cómo mejorarlo.
        include("captcha/securimage.php");
        $img = new Securimage();
        $valid = $img->check(FormatUtils::getParamPOST('captcha'));
        if (!$valid)
            throw new CaptchaException();


        //creamos la registración
        $oRegistracion = new Registracion();
        $oRegistracion->setCd_pais($oUsuario->getCd_pais());
        $oRegistracion->setDs_apynom($oUsuario->getDs_apynom());
        $oRegistracion->setDs_nomusuario($oUsuario->getDs_nomusuario());
        $oRegistracion->setDs_password($oUsuario->getDs_password());
        $oRegistracion->setDs_domicilio($oUsuario->getDs_domicilio());
        $oRegistracion->setDs_mail($oUsuario->getDs_mail());
        $oRegistracion->setDs_telefono($oUsuario->getDs_telefono());

        $oRegistracionManager = new RegistracionManager();
        $oRegistracionManager->agregarRegistracion($oRegistracion);
    }

    public function activarRegistracion($codigoActivacion) {

        $oRegistracionManager = new RegistracionManager();

        //buscamos la registración
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro('ds_codigoactivacion', $codigoActivacion, "=", new FormatValorString());
        $oRegistracion = $oRegistracionManager->getRegistracion($criterio);
        if ($oRegistracion == null || $oRegistracion->getCd_registracion() == 0) {
            throw new GenericException(CDT_SEGURIDAD_MSG_CODIGO_ACTIVACION_INCORRECTO);
        }

        //vemos si ya expiró
        $fechaVencimiento = $oRegistracion->getDt_fecha();
        $fechaVencimiento = date("Ymd", strtotime("$fechaVencimiento + 30 days"));
        $fecha = date("Ymd");
        if ($fechaVencimiento < $fecha) {
            throw new GenericException(CDT_SEGURIDAD_MSG_CODIGO_ACTIVACION_EXPIRO);
        }

        $oUsuario = $oRegistracion->createUsuario();

        //setear el perfil por default.
        $oPerfil = new Perfil();
        $oPerfil->setCd_perfil(CDT_SEGURIDAD_PERFIL_DEFAULT_ID);
        $oPerfil = PerfilQuery::getPerfilPorId($oPerfil);
        $oUsuario->setPerfil($oPerfil);

        //persistir el usuario en la bbdd.
        $this->agregarUsuario($oUsuario);

        //borrar la registración.
        $oRegistracionManager->eliminarRegistracion($oRegistracion->getCd_registracion());


        //login del usuario.
        $this->login($oUsuario->getDs_nomusuario(), $oUsuario->getDs_password());
    }

    public function solicitarClave($usuario, $msg='', $subject='') {


        try {

            $oUsuario = $this->getUsuarioPorNombre($usuario);
        } catch (GenericException $ex) {
            //si no existe buscamos por email.
            $oUsuario = $this->getUsuarioPorMail($usuario);
        }


        //generamos la nueva clave.
        $clave_nueva = FuncionesComunes::textoRadom(8);
        $oUsuario->setDs_password($clave_nueva);

        //modificamos el usuario.
        UsuarioQuery::modificarUsuario($oUsuario);


        $to = $oUsuario->getDs_mail();
        $nombre_destinatario = str_replace(",", "", $oUsuario->getDs_apynom());

        $xtpl = new XTemplate(CDT_SEGURIDAD_TEMPLATE_MAIL_SOLICITAR_CLAVE);
        $xtpl->assign('nombre', $nombre_destinatario);
        $xtpl->assign('clave', $clave_nueva);
        $xtpl->parse('main');
        $msg = $xtpl->text('main');

        if (empty($subject))
            $subject = CDT_SEGURIDAD_MSG_MAIL_SOLICITAR_CLAVE_SUBJECT;

        FuncionesComunes::enviarMail($nombre_destinario, $to, $subject, $msg);
    }

}