<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 11-01-2012
 */
class Liquidacionprofesional {

    //variables de instancia.

    private $cd_liquidacionprofesional;
    private $cd_movcaja;
    private $cd_profesional;
    private $dt_desde;
    private $dt_hasta;
    private $nu_valor;
    private $tipo;

    //Constructor.
    public function Liquidacionprofesional() {
        //TODO inicializar variables.


        $this->cd_liquidacionprofesional = '';

        $this->cd_movcaja = '';

        $this->cd_profesional = '';

        $this->dt_desde = '';

        $this->dt_hasta = '';
        $this->nu_valor = '';
        $this->tipo = '';
    }

    //Getters

    public function getCd_liquidacionprofesional() {
        return $this->cd_liquidacionprofesional;
    }

    public function getCd_movcaja() {
        return $this->cd_movcaja;
    }

    public function getCd_profesional() {
        return $this->cd_profesional;
    }

    public function getDt_desde() {
        return $this->dt_desde;
    }

    public function getDt_hasta() {
        return $this->dt_hasta;
    }

    public function getNu_valor() {
        return $this->nu_valor;
    }

    public function getTipo() {
        return $this->tipo;
    }

    //Setters

    public function setCd_liquidacionprofesional($value) {
        $this->cd_liquidacionprofesional = $value;
    }

    public function setCd_movcaja($value) {
        $this->cd_movcaja = $value;
    }

    public function setCd_profesional($value) {
        $this->cd_profesional = $value;
    }

    public function setDt_desde($value) {
        $this->dt_desde = $value;
    }

    public function setDt_hasta($value) {
        $this->dt_hasta = $value;
    }

    public function setNu_valor($value) {
        $this->nu_valor = $value;
    }

    public function setTipo($value) {
        $this->tipo = $value;
    }

}
?>
