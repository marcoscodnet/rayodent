<?php


class SeleccionarObrasocialAAsociarAction extends Action {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    public function execute() {
        $selecteds = array();
        $id = FormatUtils::getParam('id');
        $accion = FormatUtils::getParam('a');
        if (isset($_SESSION['pacientesobrasociales_session'])) {
            $obrassociales_selected = $_SESSION['pacientesobrasociales_session'];
        } else {
            $obrassociales_selected = new ItemCollection();
        }
        //si vienen vs separados por guión
        if ($tmp_sel = explode("_", $id)) {
            $selecteds = $tmp_sel;
        } else {
            $selecteds[0] = $id;
        }
        foreach ($selecteds as $cd_obrasocial) {
            if ($accion == 'add') {
                if (!$obrassociales_selected->existObject($cd_obrasocial)) {
                    $obrassociales_selected->push($cd_obrasocial);
                }
            } elseif ($accion == 'del') {
                if ($obrassociales_selected->existObject($cd_obrasocial) != false) {
                    $obrassociales_selected->removeItem($cd_obrasocial);
                }
            }
        }
        $_SESSION['pacientesobrasociales_session'] = $obrassociales_selected;
        //var_dump($obrassociales_selected);
    }

}
