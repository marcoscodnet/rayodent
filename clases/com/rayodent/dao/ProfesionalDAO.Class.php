<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011
 */
class ProfesionalDAO {

    public static function insertarProfesional(Profesional $oProfesional) {
        $db = DbManager::getConnection();


        $cd_profesional = $oProfesional->getCd_profesional();

        $cd_tipodocumento = $oProfesional->getCd_tipodocumento();

        $nu_documento = $oProfesional->getNu_documento();

        $ds_nombre = $oProfesional->getDs_nombre();

        $nu_matricula = ($oProfesional->getNu_matricula())?$oProfesional->getNu_matricula():0;

        $ds_domicilio = $oProfesional->getDs_domicilio();

        $ds_telefono = $oProfesional->getDs_telefono();

        $ds_email = $oProfesional->getDs_email();


        $sql = "INSERT INTO profesional (cd_tipodocumento, nu_documento, ds_nombre, nu_matricula, ds_domicilio, ds_telefono, ds_email) VALUES('$cd_tipodocumento', '$nu_documento', '$ds_nombre', '$nu_matricula', '$ds_domicilio', '$ds_telefono', '$ds_email')";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $id = $db->sql_nextid();
        $oProfesional->setCd_profesional($id);    
            
        $db->sql_freeresult($result);
    }

    public static function modificarProfesional(Profesional $oProfesional) {
        $db = DbManager::getConnection();


        $cd_profesional = $oProfesional->getCd_profesional();

        $cd_tipodocumento = $oProfesional->getCd_tipodocumento();

        $nu_documento = $oProfesional->getNu_documento();

        $ds_nombre = $oProfesional->getDs_nombre();

        $nu_matricula = ($oProfesional->getNu_matricula())?$oProfesional->getNu_matricula():0;

        $ds_domicilio = $oProfesional->getDs_domicilio();

        $ds_telefono = $oProfesional->getDs_telefono();

        $ds_email = $oProfesional->getDs_email();



        $sql = "UPDATE profesional SET cd_tipodocumento = '$cd_tipodocumento', nu_documento = '$nu_documento', ds_nombre = '$ds_nombre', nu_matricula = '$nu_matricula', ds_domicilio = '$ds_domicilio', ds_telefono = '$ds_telefono', ds_email = '$ds_email' WHERE cd_profesional = $cd_profesional ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function eliminarProfesional(Profesional $oProfesional) {
        $db = DbManager::getConnection();

        $cd_profesional = $oProfesional->getCd_profesional();

        $sql = "DELETE FROM profesional WHERE cd_profesional = $cd_profesional ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function getProfesionales(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM profesional P";
        $sql .= " INNER JOIN tipodocumento TD ON (P.cd_tipodocumento = TD.cd_tipodocumento)";
        $sql .= $criterio->buildFiltro();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $items = ResultFactory::toCollection($db, $result, new ProfesionalFactory());
        $db->sql_freeresult($result);
        return $items;
    }

    public static function getCantProfesionales(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT count(*) as count FROM profesional P";
         $sql .= " INNER JOIN tipodocumento TD ON (P.cd_tipodocumento = TD.cd_tipodocumento)";
        $sql .= $criterio->buildFiltroSinPaginar();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    public static function getProfesional(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM profesional P";
        $sql .= " INNER JOIN tipodocumento TD ON (P.cd_tipodocumento = TD.cd_tipodocumento)";
        $sql .= $criterio->buildFiltro();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new ProfesionalFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $obj;
    }

}
?>