<?php

class UsuarioRYT extends Usuario {

    private $nu_caja;

    //Método constructor


    function Usuario($nombre='', $clave='') {
        parent::Usuario($nombre = '', $clave = '');
        $this->nu_caja = 0;
    }

    //Métodos Get
    function getNu_caja() {
        return $this->nu_caja;
    }

    //Métodos Set
    function setNu_caja($value) {
        $this->nu_caja = $value;
    }

}

