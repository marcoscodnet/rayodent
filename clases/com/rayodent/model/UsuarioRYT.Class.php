<?php

class UsuarioRYT extends Usuario {

    private $nu_caja;

    //M�todo constructor


    function Usuario($nombre='', $clave='') {
        parent::Usuario($nombre = '', $clave = '');
        $this->nu_caja = 0;
    }

    //M�todos Get
    function getNu_caja() {
        return $this->nu_caja;
    }

    //M�todos Set
    function setNu_caja($value) {
        $this->nu_caja = $value;
    }

}

