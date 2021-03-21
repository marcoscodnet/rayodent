<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 24-11-2011
 */
class Practicaobrasocial {

    //variables de instancia.

    private $cd_practicaobrasocial;
    private $oPractica;
    private $oObrasocial;
    private $nu_practicaos;
    private $nu_limiterepeticiones;
    private $nu_importe;
    private $dt_vigencia;

    //Constructor.
    public function Practicaobrasocial() {
        //TODO inicializar variables.


        $this->cd_practicaobrasocial = '';

        $this->nu_practicaos = '';

        $this->nu_limiterepeticiones = null;

        $this->nu_importe = '';

        $this->dt_vigencia = '';


        $this->oPractica = new Practica();

        $this->oObrasocial = new Obrasocial();
    }

    //Getters

    public function getCd_practicaobrasocial() {
        return $this->cd_practicaobrasocial;
    }

    public function getPractica() {
        return $this->oPractica;
    }

    public function getObrasocial() {
        return $this->oObrasocial;
    }

    public function getNu_practicaos() {
        return $this->nu_practicaos;
    }

    public function getNu_limiterepeticiones() {
        return $this->nu_limiterepeticiones;
    }

    public function getNu_importe() {
        return $this->nu_importe;
    }

    public function getDt_vigencia() {
        return $this->dt_vigencia;
    }

    public function getCd_practica() {
        return $this->oPractica->getCd_practica();
    }

    public function getCd_obrasocial() {
        return $this->oObrasocial->getCd_obrasocial();
    }

    //Setters

    public function setCd_practicaobrasocial($value) {
        $this->cd_practicaobrasocial = $value;
    }

    public function setPractica($value) {
        $this->oPractica = $value;
    }

    public function setObrasocial($value) {
        $this->oObrasocial = $value;
    }

    public function setNu_practicaos($value) {
        $this->nu_practicaos = $value;
    }

    public function setNu_limiterepeticiones($value) {
        $this->nu_limiterepeticiones = $value;
    }

    public function setNu_importe($value) {
        $this->nu_importe = $value;
    }

    public function setDt_vigencia($value) {
        $this->dt_vigencia = $value;
    }

    public function setCd_practica($value) {
        $this->oPractica->setCd_practica($value);
    }

    public function setCd_obrasocial($value) {
        $this->oObrasocial->setCd_obrasocial($value);
    }

}
?>
