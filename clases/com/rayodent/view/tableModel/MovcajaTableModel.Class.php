<?php

/**
 * Autogenerated class
 *
 *  @author modelBuilder
 *  @since 14-12-2011
 */
class MovcajaTableModel extends ListarTableModel {

    private $columnNames = array();
    private $columnWidths = array();

    public function MovcajaTableModel(ItemCollection $items) {
        $this->items = $items;
        $this->initColumns();
    }

    private function initColumns() {
        $this->columnNames[] = 'ID';
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_MOVCAJA_DT_MOVCAJA;
        $this->columnWidths[] = 20;

        $this->columnNames[] = 'Efectivo';
        $this->columnWidths[] = 20;

        $this->columnNames[] = 'PosNet';
        $this->columnWidths[] = 20;

        $this->columnNames[] = RYT_ORDENPRACTICA_CD_OBRASOCIALBONO;
        $this->columnWidths[] = 20;

        $this->columnNames[] = '$';
        $this->columnWidths[] = 20;



        $this->columnNames[] = RYT_MOVCAJA_DS_DETALLE;
        $this->columnWidths[] = 80;

        $this->columnNames[] = RYT_MOVCAJA_DS_PACIENTE;
        $this->columnWidths[] = 80;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Movcajas";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnCount()
     */
    function getColumnCount() {
        return count($this->columnNames);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnName($columnIndex)
     */
    function getColumnName($columnIndex) {
        return $this->columnNames[$columnIndex];
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getColumnWidth($columnIndex)
     */
    function getColumnWidth($columnIndex) {
        return $this->columnWidths[$columnIndex];
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getRowCount()
     */
    function getRowCount() {
        $this->items->size();
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
     */
    function getValueAt($rowIndex, $columnIndex) {
        $oObject = $this->items->getObjectByIndex($rowIndex);
        return $this->getValue($oObject, $columnIndex);
    }

    public function getValue($anObject, $columnIndex) {
        $oMovcaja = $anObject;
        $value = 0;
        /*$montoArray = explode(' ', $oMovcaja->getNu_total());
        $detalleArray = explode('/', $oMovcaja->getDs_detalle());


        $criterio = new CriterioBusqueda();

            $criterio->addFiltro("cd_obrasocial", 64, "<>", new FormatValor());
        $criterio->addFiltro("cd_obrasocial", 12, "<>", new FormatValor());


        $manager = new ObrasocialManager();
        $obrassociales = $manager->getObrasociales($criterio);

        $esObraSocial=0;
        $descObraSocial='';
        foreach ($obrassociales as $key => $oObrasocial) {

            if (strpos($detalleArray[0], $oObrasocial->getDs_obrasocial())){
                $esObraSocial=1;
                $descObraSocial=utf8_encode($oObrasocial->getDs_obrasocial());
                break;
            }

        }


        $detalleMonto = explode(' ',$detalleArray[1]);*/
        switch ($columnIndex) {

            case 0: $value = $oMovcaja->getCd_movcaja();
                break;
            case 1: $value = FuncionesComunes::fechaHoraMysqlaPHP($oMovcaja->getDt_movcaja());
                break;
            case 2: $value = $oMovcaja->getNu_totalefectivo();
                break;
            case 3: $value = $oMovcaja->getNu_totalposnet();
                break;
            case 4: $value = $oMovcaja->getDs_obrasocial();
                break;
            case 5: $value = $oMovcaja->getNu_totalOB();
                break;
            case 6: $value = $oMovcaja->getDs_detalle();
                break;
            case 7: $value = $oMovcaja->getDs_paciente();
                break;
            default: $value = '';
                break;
        }
        return $value;
    }

    public function getEncabezados() {

        $encabezados[] = $this->buildTh($this->getColumnName(0), 'MC.cd_movcaja', 'cd_movcaja');
        $encabezados[] = $this->buildTh($this->getColumnName(1), 'dt_movcaja', 'dt_movcaja');
        $encabezados[] = $this->buildTh($this->getColumnName(2), null, null);
        $encabezados[] = $this->buildTh($this->getColumnName(3), null, null);
        $encabezados[] = $this->buildTh($this->getColumnName(4), null, null);
        $encabezados[] = $this->buildTh($this->getColumnName(5), null, null);
        $encabezados[] = $this->buildTh($this->getColumnName(6), null, null);
        $encabezados[] = $this->buildTh($this->getColumnName(7), 'ds_paciente', 'ds_paciente');
        return $encabezados;
    }

}
?>
