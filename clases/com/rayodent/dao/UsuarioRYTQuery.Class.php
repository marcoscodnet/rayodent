<?php

class UsuarioRYTQuery extends UsuarioQuery {

    static function getUsuarioConPerfilPorNombreYPass(Usuario $user) {
        $db = DbManager::getConnection();
        $ds_nomusuario = $user->getDs_nomusuario();
        $ds_password = MD5($user->getDs_password());
        $sql = "SELECT U.cd_usuario, U.ds_nomusuario, U.cd_perfil, U.ds_apynom, U.ds_mail, U.cd_pais, PA.ds_pais, U.ds_telefono, U.ds_password, P.ds_perfil, U.nu_caja FROM " . CDT_SEGURIDAD_TABLA_USUARIO . " U";
        $sql .= " LEFT JOIN " . CDT_SEGURIDAD_TABLA_PERFIL . " P ON(P.cd_perfil=U.cd_perfil)  ";
        $sql .= " LEFT JOIN " . CDT_GEO_TABLA_PAIS . " PA ON(PA.cd_pais=U.cd_pais)  ";
        $sql .= " WHERE ds_nomusuario ='$ds_nomusuario' AND ds_password = '$ds_password'";

        $result = $db->sql_query($sql);

        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new UsuarioRYTFactory();
            $obj = $factory->build($temp);
        } else {
            throw new UsuarioNoValidoException();
        }

        $db->sql_freeresult($result);
        return ($obj);
    }

    static function insertUsuario(Usuario $obj) {
        $db = DbManager::getConnection();
        $ds_nomusuario = $obj->getDs_nomusuario();

        $ds_password = MD5($obj->getDs_password());
        $cd_perfil = $obj->getCd_perfil();
        $ds_mail = $obj->getDs_mail();
        $nu_caja = (int) $obj->getNu_caja();
        $ds_apynom = $obj->getDs_apynom();
        $cd_pais = FormatUtils::ifEmpty($obj->getCd_pais(), 'null');
        $ds_telefono = $obj->getDs_telefono();
        $ds_domicilio = $obj->getDs_domicilio();
        $sql = "INSERT INTO " . CDT_SEGURIDAD_TABLA_USUARIO . " (ds_nomusuario ,ds_password ,cd_perfil, ds_apynom, ds_mail, nu_caja, ds_telefono, ds_domicilio, cd_pais) VALUES ('$ds_nomusuario' ,'$ds_password' ,$cd_perfil, '$ds_apynom', '$ds_mail', $nu_caja, '$ds_telefono', '$ds_domicilio', $cd_pais) ";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    static function getUsuariosConPerfil(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();

        $sql = "SELECT U.ds_password, U.cd_usuario, U.ds_nomusuario, P.cd_perfil, P.ds_perfil, U.ds_apynom, U.cd_pais, PA.ds_pais, U.ds_telefono, U.ds_mail, U.nu_caja FROM " . CDT_SEGURIDAD_TABLA_USUARIO . " U";
        $sql .= " LEFT JOIN " . CDT_SEGURIDAD_TABLA_PERFIL . " P ON(P.cd_perfil=U.cd_perfil) ";
        $sql .= " LEFT JOIN " . CDT_GEO_TABLA_PAIS . " PA ON(PA.cd_pais=U.cd_pais)  ";
        $sql .= $criterio->buildFiltro();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $usuarios = ResultFactory::toCollection($db, $result, new UsuarioRYTFactory());

        $db->sql_freeresult($result);

        return ($usuarios);
    }

    static function getNuCajas() {
        $db = DbManager::getConnection();
        $sql = "SELECT DISTINCT nu_caja FROM " . CDT_SEGURIDAD_TABLA_USUARIO;

        $result = $db->sql_query($sql);

        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
        $cajas = new ItemCollection();
        while ($next = $db->sql_fetchassoc($result)) {
            $cajas->addItem($next['nu_caja']);
        }
        return $cajas;
    }

    static function getUsuarioPorId(Usuario $obj) {
        $db = DbManager::getConnection();
        $cd_usuario = $obj->getCd_usuario();
        $sql = "SELECT U.ds_nomusuario, U.cd_perfil, U.cd_usuario, U.ds_apynom, U.ds_mail, U.cd_pais, PA.ds_pais, U.ds_telefono, U.ds_password, U.nu_caja FROM " . CDT_SEGURIDAD_TABLA_USUARIO . " U";
        $sql .= " LEFT JOIN " . CDT_GEO_TABLA_PAIS . " PA ON(PA.cd_pais=U.cd_pais)  ";
        $sql .= " WHERE U.cd_usuario = $cd_usuario";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new UsuarioRYTFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return ($obj);
    }

    static function getUsuarioConPerfilPorId(Usuario $obj) {
        $db = DbManager::getConnection();
        $cd_usuario = $obj->getCd_usuario();
        $sql = "SELECT U.cd_usuario, U.ds_nomusuario, U.cd_perfil, U.ds_apynom, U.ds_mail, U.cd_pais, PA.ds_pais, U.ds_telefono, U.ds_password, P.ds_perfil, U.nu_caja FROM " . CDT_SEGURIDAD_TABLA_USUARIO . " U";
        $sql .= " LEFT JOIN " . CDT_SEGURIDAD_TABLA_PERFIL . " P ON(P.cd_perfil=U.cd_perfil)  ";
        $sql .= " LEFT JOIN " . CDT_GEO_TABLA_PAIS . " PA ON(PA.cd_pais=U.cd_pais)  ";
        $sql .= " WHERE U.cd_usuario = $cd_usuario";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new UsuarioRYTFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return ($obj);
    }

    static function modificarUsuario(Usuario $obj) {
        $db = DbManager::getConnection();

        $cd_usuario = $obj->getCd_usuario();
        $ds_nomusuario = $obj->getDs_nomusuario();
        $cd_perfil = $obj->getCd_perfil();
        $ds_mail = $obj->getDs_mail();
        $nu_caja = $obj->getNu_caja();
        $ds_apynom = $obj->getDs_apynom();
        $cd_pais = FormatUtils::ifEmpty($obj->getCd_pais(), 'null');
        $ds_telefono = $obj->getDs_telefono();
        $ds_domicilio = $obj->getDs_domicilio();

        $sql = "UPDATE " . CDT_SEGURIDAD_TABLA_USUARIO . " SET ds_nomusuario='$ds_nomusuario',ds_telefono='$ds_telefono',ds_domicilio='$ds_domicilio',cd_perfil=$cd_perfil,cd_pais=$cd_pais,ds_apynom='$ds_apynom', ds_mail= '$ds_mail', nu_caja= '$nu_caja'";
        if ($obj->getDs_password() != "") {
            $ds_password = MD5($obj->getDs_password());
            $sql .= ", ds_password = '$ds_password'";
        }
        $sql .= " WHERE cd_usuario = $cd_usuario";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>