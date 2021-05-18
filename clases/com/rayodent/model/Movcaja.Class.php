<?php

/**
 * Autogenerated class
 *
 *  @author modelBuilder
 *  @since 14-12-2011
 */
class Movcaja {

    //variables de instancia.

    private $cd_movcaja;
    private $dt_movcaja;
    private $ds_observacion;
    private $nu_caja;
    private $oUsuario;
    private $oTurno;
    private $bl_anulacion;
    private $nu_total;
    private $nu_total_placas;
    private $ds_detalle;
    private $ds_detalle_placas;
    private $ds_paciente;
    private $ds_direccion;


    private $nu_etiquetasimple;
    private $nu_etiquetadoble;
    private $nu_totalefectivo;
    private $nu_totalposnet;
    private $nu_totalOB;
    private $ds_obrasocial;

    /**
     * @return mixed
     */
    public function getDs_obrasocial()
    {
        return $this->ds_obrasocial;
    }

    /**
     * @param mixed $ds_obrasocial
     */
    public function setDs_obrasocial($ds_obrasocial)
    {
        $this->ds_obrasocial = $ds_obrasocial;
    }

    //Constructor.
    public function Movcaja() {
        //TODO inicializar variables.


        $this->cd_movcaja = '';

        $this->dt_movcaja = '';

        $this->ds_observacion = '';

        $this->nu_caja = '';

        $this->oUsuario = new UsuarioRYT();

        $this->oTurno = new Turno();

        $this->bl_anulacion = 0;

        $this->nu_total = 0;
        $this->nu_totalefectivo = 0;
        $this->nu_totalposnet = 0;
        $this->nu_totalOB = 0;


        $this->nu_total_placas = 0;

        $this->ds_detalle = '';

        $this->ds_detalle_placas = '';

        $this->ds_paciente = '';

        $this->ds_direccion = '';
        $this->ds_obrasocial = '';

    }

    //Getters

    public function getCd_movcaja() {
        return $this->cd_movcaja;
    }

    public function getDt_movcaja() {
        return $this->dt_movcaja;
    }

    public function getDs_observacion() {
        return $this->ds_observacion;
    }

    public function getNu_caja() {
        return $this->nu_caja;
    }

    public function getUsuario() {
        return $this->oUsuario;
    }

    public function getCd_usuario() {
        return $this->getUsuario()->getCd_usuario();
    }

    public function getTurno() {
        return $this->oTurno;
    }

    public function getCd_turno() {
        return $this->getTurno()->getCd_turno();
    }

    public function getBl_anulacion() {
        return $this->bl_anulacion;
    }

    public function getNu_total() {
        return $this->nu_total;
    }

    public function getNu_totalPlacas() {
        return $this->nu_total_placas;
    }

    public function getDs_detalle() {
        return $this->ds_detalle;
    }

    public function getDs_detallePlacas() {
        return $this->ds_detalle_placas;
    }

    public function getDs_paciente() {
        return $this->ds_paciente;
    }

    public function getDs_direccion() {
        return $this->ds_direccion;
    }

    //Setters

    public function setCd_movcaja($value) {
        $this->cd_movcaja = $value;
    }

    public function setDt_movcaja($value) {
        $this->dt_movcaja = $value;
    }

    public function setDs_observacion($value) {
        $this->ds_observacion = $value;
    }

    public function setNu_caja($value) {
        $this->nu_caja = $value;
    }

    public function setUsuario($value) {
        $this->oUsuario = $value;
    }

    public function setCd_usuario($value) {
        $this->getUsuario()->setCd_usuario($value);
    }

    public function setTurno($value) {
        $this->oTurno = $value;
    }

    public function setCd_turno($value) {
        $this->getTurno()->setCd_turno($value);
    }

    public function setBl_anulacion($value) {
        $this->bl_anulacion = $value;
    }

    public function setNu_total($value) {
        $this->nu_total = $value;
    }

    public function setNu_totalPlacas($value) {
        $this->nu_total_placas = $value;
    }

    public function setDs_detalle($value) {
        $this->ds_detalle = $value;
    }

    public function setDs_detallePlacas($value) {
        $this->ds_detalle_placas = $value;
    }

    public function setDs_paciente($value) {
        $this->ds_paciente = $value;
    }

    public function setDs_direccion($value) {
        $this->ds_direccion = $value;
    }


    public function getNu_etiquetasimple()
    {
        return $this->nu_etiquetasimple;
    }

    public function setNu_etiquetasimple($nu_etiquetasimple)
    {
        $this->nu_etiquetasimple = $nu_etiquetasimple;
    }

    public function getNu_etiquetadoble()
    {
        return $this->nu_etiquetadoble;
    }

    public function setNu_etiquetadoble($nu_etiquetadoble)
    {
        $this->nu_etiquetadoble = $nu_etiquetadoble;
    }

    /**
     * @return mixed
     */
    public function getNu_totalefectivo()
    {
        return $this->nu_totalefectivo;
    }

    /**
     * @param mixed $nu_totalefectivo
     */
    public function setNu_totalefectivo($nu_totalefectivo)
    {
        $this->nu_totalefectivo = $nu_totalefectivo;
    }

    /**
     * @return mixed
     */
    public function getNu_totalposnet()
    {
        return $this->nu_totalposnet;
    }

    /**
     * @param mixed $nu_totalposnet
     */
    public function setNu_totalposnet($nu_totalposnet)
    {
        $this->nu_totalposnet = $nu_totalposnet;
    }

    /**
     * @return mixed
     */
    public function getNu_totalOB()
    {
        return $this->nu_totalOB;
    }

    /**
     * @param mixed $nu_totalOB
     */
    public function setNu_totalOB($nu_totalOB)
    {
        $this->nu_totalOB = $nu_totalOB;
    }
}
?>
