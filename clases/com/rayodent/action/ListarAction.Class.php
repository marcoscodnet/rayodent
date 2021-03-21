<?php


abstract class ListarAction extends OutputAction{

	protected $tableModel;

	protected $hayFiltros = false;


	/**
	 * retorna la p?gina para paginaci?n de los resultados.
	 */
	protected function getPagePaginacion(){
		return  FormatUtils::getParam('page',1);
	}


	/**
	 * se listan entidades.
	 * @return boolean (true=exito).
	 */
	protected function getContenido(){

		$xtpl = $this->getXTemplate();
		$xtpl->assign('WEB_PATH', WEB_PATH);

		//recuperamos los par?metros.
		$filtro = urldecode(FormatUtils::getParam('filtro'));

		$page = $this->getPagePaginacion();

		$orden = FormatUtils::getParam('orden',$this->getOrdenDefault());

		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );
		$xtpl->assign( 'campoOrden', $campoOrden );
		$xtpl->assign( 'accion_listar', $this->getUrlAccionListar() );
		$xtpl->assign( 'orden', $orden );
		$xtpl->assign( 'campoFiltro', $campoFiltro );
		$xtpl->assign( 'filtro', $filtro );

		//t?tulo del listado.
		$xtpl->assign( 'titulo', $this->getTituloListado() );

		//armamos el query string (para la paginaci?n y la ordenaci?n).
		$query_string = $this->getQueryString( $filtro, $campoFiltro )."id=".FormatUtils::getParam('id') . $this->getFiltrosEspecialesQueryString() ."&";

		//obtenemos los elementos a mostrar.
		$criterio = $this->getCriterioBusqueda();

		try{

			$entidades = $this->getEntidadManager()->getEntidades ( $criterio );
			$num_rows = $this->getEntidadManager()->getCantidadEntidades (  $criterio );

		}catch(GenericException $ex){
			//capturamos la excepci?n para terminar de parsear el contenido y luego la volvemos a lanzar para mostrar el error.
			$entidades = new ItemCollection();
			$num_rows = 0;
			$this->getLayoutInstance()->setException( $ex );
		}
			

		$this->tableModel = $this->getListarTableModel( $entidades );

		//construimos el paginador.
		$oPaginador = $this->getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $page);

		//generamos el contenido.
		$content = $this->parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);

		return $content;

	}

	public function getQueryString($filtro, $campoFiltro){
		return "?filtro=$filtro&campoFiltro=$campoFiltro&";
	}

	/**
	 * criterio de b?squeda para filtrar el listado.
	 * @return unknown_type
	 */
	protected function getCriterioBusqueda(){
		//recuperamos los par?metros.
		$filtro = urldecode(FormatUtils::getParam('filtro'));
		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );

		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden',$this->getOrdenDefault());
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();
		//$criterio->put('campoFiltro', $campoFiltro);
		//$criterio->put('filtro', $filtro);

		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}

	protected function addSelectedFiltro($criterio,$campoFiltro, $filtro){

		if((substr( $campoFiltro,0,3) == 'dt_' )&&($campoFiltro!='dt_fecha')){
			if( !empty( $filtro ))
			$criterio->addFiltro($campoFiltro, $filtro, '=', new FormatValorDate());
		}
		else
		$criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
	}

	/**
	 * template donde parsear la salida.
	 * @return unknown_type
	 */
	protected function getXTemplate(){

		if( defined("DEFAULT_LISTAR_TEMPLATE") )
		return new XTemplate(DEFAULT_LISTAR_TEMPLATE);
		else
		return new XTemplate(CDT_MVC_TEMPLATE_LISTAR);
			
	}

	/**
	 * se parsean los errores.
	 * @return unknown_type
	 */
	protected function parseErrores(Xtemplate $xtpl){
		if (isset ( $_GET ['er'] )){
			$er = FormatUtils::getParam('er');
			if ($er == 1) {
				$mensaje =  "<script> mensajeError('".     $this->getMensajeError()        . "'); </script>";
				$xtpl->assign ( 'msj', $mensaje );
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$xtpl->parse ( 'main.msj' );
			}
		}
	}

	/**
	 * se parsean las filas.
	 * @param XTemplate $xtpl
	 * @param ItemCollection $items
	 * @return unknown_type
	 */
	protected function parseRows(XTemplate $xtpl, ItemCollection $items){

		$par = false;

		foreach ($items as $key=> $item){

			//parse el item -- main.row.column
			$this->parseItem( $xtpl, $item );

			//acciones sobre el item
			$this->parseAcciones( $xtpl, $item );

			//estilo de la fila.
			$row_class = ( $par )? $this->getRowClassPar() : $this->getRowClassImpar();
			$xtpl->assign('row_class', $row_class );

			$xtpl->parse('main.row' );

			$par = !$par;
		}

	}

	protected function getRowClassPar(){
		return "";
	}

	protected function getRowClassImpar(){
		return "color-b";
	}

	/**
	 * El manager de la entidad debe implementar la interfaz IListar.
	 * @return IListar
	 */
	protected abstract function getEntidadManager();

	/**
	 * table model para describir el listado.
	 * @return ListarTableModel
	 */
	protected abstract function getListarTableModel( ItemCollection $items );


	/**
	 * @return campo de ordenamiento por default.
	 */
	protected abstract function getCampoOrdenDefault();

	/**
	 * @return campo de filtro por default.
	 */
	protected function getCampoFiltroDefault(){
		return $this->getCampoOrdenDefault();
	}


	/**
	 * @return mensaje de error.
	 */
	protected function getMensajeError(){
		$cd='';
		if (isset ( $_GET ['id'] ))
		$cd = FormatUtils::getParam('id');
			
		if (isset ( $_GET ['msg'] ))
		$msg = FormatUtils::getParam('msg','',true,false);
		else
		$msg = "No se pudo realizar la operaci&oacute;n para el elemento con ID <b>$cd</b>.";
			
		return $msg;
	}



	/**
	 * @return url para ejecutar el listado.
	 */
	protected abstract function getUrlAccionListar();

	/**
	 * @return url para exportar el listado a pdf.
	 */
	protected function getUrlAccionExportarPdf(){
		return '';
	}

	protected function getUrlAccionExportarExcel(){
		return '';
	}
	/**
	 * @return forward a la p?gina de error.
	 */
	protected abstract function getForwardError();


	/**
	 * se parsea la entidad en el xtemplate.
	 * @param $xtpl Xtemplate asociado al listado.
	 * @param $entidad entidad a parsear.
	 * @return none
	 *
	 */
	protected function parseItem($xtpl, $entidad){
		$values = $this->getValues($entidad);
		$count = count($values);
		for($index=0;$index<$count;$index++) {
			$this->parseItemValue( $xtpl, $values[$index]);
		}

	}

	/**
	 * se retorna una lista con los valores de las columnas de la fila corriente.
	 * @return unknown_type
	 */
	protected function getValues($item){
		for ($i=0; $i < $this->tableModel->getColumnCount(); $i++){
			$values[]=  $this->tableModel->getValue($item, $i) ;
		}
		return $values;
	}


	/**
	 * se parsean los opciones: botones sobre la tabla.
	 * @param $xtpl
	 * @return unknown_type
	 */
	protected function parseOpciones(XTemplate $xtpl){

		$opciones = $this->getOpciones();
		$count = count($opciones);

		for($index=0;$index<$count;$index++) {

			$nombre = $opciones[$index]['nombre'];
			$label = $opciones[$index]['label'];
			$accion = $opciones[$index]['accion'];
			$style = $opciones[$index]['style'];
			$this->parseOpcion( $xtpl, $nombre, $label, $accion, $style);
		}
	}


	/**
	 * se retorna una lista con las opciones.
	 * cada elemento de la lista deber? ser un array de la forma:
	 *    - vector['nombre']='campo_orden'
	 *    - vector['label']='descripci?n de la ordenaci?n'
	 *    - vector['accion']='descripci?n de la ordenaci?n'
	 * se puede usar el m?todo buildFiltro(orden, descripcion) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	protected function getOpciones(){

	}

	/**
	 * se construye una opci?n
	 * @param unknown_type $nombre
	 * @param unknown_type $label
	 * @param unknown_type $accion
	 * @param unknown_type $style
	 * @return unknown_type
	 */
	protected function buildOpcion($nombre, $label, $accion, $style='add'){
		$opcion['nombre']= $nombre;
		$opcion['label']= $label;
		$opcion['accion']= $accion;
		$opcion['style']= $style;
		return $opcion;
	}

	/**
	 * se parsean las opciones del filtro de b?squeda:
	 * opciones del combo.
	 * @param XTemplate $xtpl
	 * @param $campo campo por el cual se filtra (es el seleccionado del combo).
	 * @return unknown_type
	 */
	protected function parseOpcionesFiltro(XTemplate $xtpl, $campo){
		$filtros = $this->getFiltros();
		$count = count($filtros);

		for($index=0;$index<$count;$index++) {

			$orden = $filtros[$index]['orden'];
			$descripcion = $filtros[$index]['descripcion'];

			$this->parseFiltro( $xtpl, $orden, $descripcion, $campo);
		}

		//imprimimos el combo y el campo de texto para la b?squeda siempre y cuando se haya definido alg?n filtro.
		if($count>0){
			$xtpl->parse ( 'main.botones_tabla.combo_filtros' );
			$this->hayFiltros = true;
		}

	}

	/**
	 * se retorna una lista con los filtros de b?squeda.
	 * cada elemento de la lista deber? ser un array de la forma:
	 *    - vector['orden']='campo_orden'
	 *    - vector['descripcion']='descripci?n de la ordenaci?n'
	 * se puede usar el m?todo buildFiltro(orden, descripcion) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	protected function getFiltros(){}

	/**
	 * se construye un filtro
	 * @param unknown_type $orden
	 * @param unknown_type $descripcion
	 * @return unknown_type
	 */
	protected function buildFiltro($orden, $descripcion){
		$filtro['orden']= $orden;
		$filtro['descripcion']= $descripcion;
		return $filtro;
	}

	/**
	 * se parsean los encabezados de las columnas del listado.
	 * @param XTemplate $xtpl
	 * @param unknown_type $query_string
	 * @return unknown_type
	 */
	protected function parseTHs(XTemplate $xtpl, $query_string){

		$ths = $this->getEncabezados();
		$count = count($ths);
		for($index=0;$index<$count;$index++) {
			$encabezado = $ths[$index]['encabezado'];
			$campoOrden = $ths[$index]['campoOrden'];
			$descripcionOrden = $ths[$index]['descripcionOrden'];
			$this->parseTH( $xtpl, $query_string, $encabezado, $campoOrden, $descripcionOrden);
		}

	}

	/**
	 * se retorna una lista con los encabezados de las columnas.
	 * cada elemento de la lista deber? ser un array de la forma:
	 *    - th['encabezado']='titulo'
	 *    - th['campoOrden']='campo_orden'
	 *    - th['descripcionOrden']='descripci?n de la ordenaci?n'
	 * se puede usar el m?todo buildTh(nombre, orden, descripcion) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	protected function getEncabezados(){
		return $this->tableModel->getEncabezados();
	}

	/**
	 * construye un encabezado.
	 * @param unknown_type $titulo
	 * @param unknown_type $orden
	 * @param unknown_type $descripcion
	 * @return unknown_type
	 * @deprecated
	 */
	protected function buildTh($titulo, $orden, $descripcion){
		$th['encabezado']= $titulo;
		$th['campoOrden']= $orden;
		$th['descripcionOrden']= $descripcion;
		return $th;
	}

	/**
	 * se parsean las acciones sobre los elementos del listado.
	 * @param XTemplate $xtpl
	 * @param unknown_type $item
	 * @return unknown_type
	 *
	 * redefinir siguiendo el ejemplo:
	 * 		$xtpl->assign('onclick', 'una funcion' );
	 * 		$xtpl->assign('href', 'un link' );
	 * 		$xtpl->assign('img', 'una imagen' );
	 * 		$xtpl->assign('title', 'un title' );
	 * 		$xtpl->parse('main.row.accion' );
	 *
	 * 		$xtpl->assign('onclick', 'otra funcion' );
	 * 		$xtpl->assign('href', 'otro link' );
	 * 		$xtpl->assign('img', 'otra imagen' );
	 * 		$xtpl->assign('title', 'otro title' );
	 * 		$xtpl->parse('main.row.accion' );
	 */
	protected function parseAcciones(XTemplate $xtpl, $item){
		$acciones = $this->getAcciones($item);
		$count = count($acciones);
		for($index=0;$index<$count;$index++) {
			$onclick = $acciones[$index]['onclick'];
			$href = $acciones[$index]['href'];
			$img = $acciones[$index]['img'];
			$title = $acciones[$index]['title'];
			$this->parseAccion( $xtpl, $onclick, $href, $img, $title);
		}

	}

	/**
	 * se retorna una lista con las acciones de cada columna.
	 * cada elemento de la lista deber? ser un array de la forma:
	 *    - accion['onclick']='evento para el onclick'
	 *    - accion['href']='link'
	 *    - accion['img']='imagen'
	 *    - accion['title']='t?tulo para la im?gen'
	 * se puede usar el m?todo buildAccion(onclick, href, img, title) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	protected function getAcciones($item){}

	/**
	 * construye una acci?n.
	 * @param unknown_type $onclick
	 * @param unknown_type $href
	 * @param unknown_type $img
	 * @param unknown_type $title
	 * @return unknown_type
	 */
	protected function buildAccion($onclick, $href, $img, $title){
		$accion['onclick']= $onclick;
		$accion['href']= $href;
		$accion['img']= $img;
		$accion['title']= $title;
		return $accion;
	}


	//PRIVATE.

	protected function getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $page){
		$num_pages = ceil ( $num_rows / ROW_PER_PAGE );

		//$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
		$url = $this->getUrlPaginador( $orden, $campoFiltro, $filtro, $campoOrden );
		$cssclassotherpage = 'paginadorOtraPagina';
		$cssclassactualpage = 'paginadorPaginaActual';
		$ds_pag_anterior = 0; //$gral['pag_ant'];
		$ds_pag_siguiente = 2; //$gral['pag_sig'];
		return new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	}

	protected function getUrlPaginador( $orden , $campoFiltro, $filtro, $campoOrden ){
		$url = 'doAction?action='. $this->getUrlAccionListar() . '&orden=' . $orden . '&campoFiltro=' . $campoFiltro . '&filtro=' . $filtro. '&campoOrden=' . $campoOrden . $this->getFiltrosEspecialesQueryString();
		return $url;
	}

	private function getParam($name, $default=''){

		return FormatUtils::getParam($name, $default);
	}

	/*
	 * se parsea la salida utilizando xtemplate.
	 */
	protected function parseContenido(XTemplate $xtpl, $filtro, $oPaginador, $query_string, $entidades, CriterioBusqueda $criterio){

		$xtpl->assign ( 'txt_filtro', $filtro );

		//paginaci?n.
		$xtpl->assign ( 'resultado', $oPaginador->imprimirResultados () );
		$xtpl->parse ( 'main.resultado' );

		$xtpl->assign ( 'PAG', $oPaginador->imprimirPaginado () );
		$xtpl->parse ( 'main.PAG' );

		//botones sobre el listado.
		$excel = $this->getUrlAccionExportarExcel();
		if(!empty ( $excel) ){
			$xtpl->assign ( 'accion_excel', $excel );
			$xtpl->parse ( 'main.export_excel' );
		}

		$pdf = $this->getUrlAccionExportarPdf();
		if( !empty( $pdf )){
			$xtpl->assign ( 'accion_pdf', $pdf );
			$xtpl->parse ( 'main.export_pdf' );
		}

		$this->parseOpciones( $xtpl );

		//filtros de b?squeda
		if (isset ( $_GET ['campoFiltro'] ))
		$campoFiltro = FormatUtils::getParam('campoFiltro');
		else
		$campoFiltro = $this->getCampoFiltroDefault();
		$this->parseOpcionesFiltro( $xtpl , $campoFiltro);

		$this->parseFiltrosEspeciales( $xtpl );


		//si se mostraron filtros, parseamos para que se vean.
		if( $this->hayFiltros )
		$xtpl->parse('main.botones_tabla');


		//manejo de errores.
		$this->parseErrores($xtpl);

		//header del listado.
		$this->parseHeader( $xtpl, $entidades, $criterio );

		//encabezados (ths) de la tabla.
		$this->parseTHs( $xtpl, $query_string );

		//se parsean los elementos a mostrar
		$this->parseRows( $xtpl , $entidades);

		//footer del listado.
		$this->parseFooter( $xtpl, $entidades, $criterio );

		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}

	/**
	 * se parsea un header del listado.
	 * @param XTemplate $xtpl template a parsear.
	 * @param unknown_type $query_string query de b?squeda para mantener los filtros.
	 * @param unknown_type $encabezado descripci?n del encabezado.
	 * @param unknown_type $campoOrden campo por el cual ordenar el listado al cliquear en el encabezado.
	 * @param unknown_type $descripcionOrden descripci?n de la ordenaci?n.
	 * @return none.
	 */
	protected function parseTH(XTemplate $xtpl, $query_string, $encabezado, $campoOrden,  $descripcionOrden){

		$xtpl->assign('encabezado', $encabezado );
		$xtpl->assign('query_string', $query_string );
		$xtpl->assign('campo_orden', $campoOrden );
		$xtpl->assign('accion_listar', $this->getUrlAccionListar() );
		$xtpl->assign('ordenar_por', $descripcionOrden );

		if( FormatUtils::getParam ('orden') == 'ASC')
		$xtpl->assign('orden', 'DESC' );
		else
		$xtpl->assign('orden', 'ASC' );

		/*
		 $filtros_especiales = $this->getFiltrosEspecialesQueryString();
		 if(!empty($filtros_especiales))
			$xtpl->assign('filtros_especiales', $filtros_especiales );
			*/
		$xtpl->parse('main.TH' );

	}

	protected function getFiltrosEspecialesQueryString(){
		return "";
	}
	/**
	 * se parsea un filtro de b?squeda.
	 * @param $xtpl template a parsear.
	 * @param $value valor para el filtro
	 * @param $descripcion descripci?n del filtro.
	 * @return none.
	 */
	protected function parseFiltro(XTemplate $xtpl, $value, $descripcion, $selected=''){
		$xtpl->assign ( 'value_filtro', FormatUtils::selected( $value, $selected) );
		$xtpl->assign ( 'ds_filtro', $descripcion );
		$xtpl->parse ( 'main.botones_tabla.combo_filtros.opcion_filtro' );
	}

	/**
	 * parsea el valor de un item. (el valor de una columna en una fila).
	 * @param $xtpl template a parsear.
	 * @param $value valor a parsear.
	 * @return none.
	 */
	protected function parseItemValue(XTemplate $xtpl, $value){
		$xtpl->assign ( 'value', $value );
		$xtpl->parse('main.row.column' );
	}

	/**
	 * parsea una acci?n en la fila corriente.
	 * @param XTemplate $xtpl template a parsear.
	 * @param unknown_type $onclick evento del onclick.
	 * @param unknown_type $href href del link.
	 * @param unknown_type $img im?gen del link.
	 * @param unknown_type $title descripci?n del link.
	 * @return none.
	 */
	protected function parseAccion(XTemplate $xtpl, $onclick, $href, $img, $title,$target='_self'){

		$link = ( empty($href) )? $onclick : $href ;

		//TODO check permisos
		//if( $this->tienePermisoLink( $link ) ){
		$xtpl->assign('onclick', $onclick );
		$xtpl->assign('href', $href );
		$xtpl->assign('target', $target );
		$xtpl->assign('img', $img );
		$xtpl->assign('title', $title );
		$xtpl->parse('main.row.accion' );
		//}

	}


	/**
	 * se parsea una opci?n sobre el listado.
	 * es un bot?n que aparece arriba del listado.
	 * @param XTemplate $xtpl template a parsear.
	 * @param unknown_type $nombre nombre del bot?n.
	 * @param unknown_type $label label del bot?n.
	 * @param unknown_type $accion acci?n al ejecutar en el onlick
	 * @return none.
	 */
	protected function parseOpcion(XTemplate $xtpl, $nombre, $label, $accion, $style='add'){

		//TODO check permisos
		//if( $this->tienePermisoAccion( $accion ) ){
		$xtpl->assign('nombre', $nombre );
		$xtpl->assign('label', $label );
		$xtpl->assign('accion', $accion );
		$xtpl->assign('li_class', $style );
		$xtpl->parse('main.opcion' );
		//}
	}

	/**
	 * se parsean los filtros especiales
	 * (espec?ficos de cada listado).
	 * @param $xtpl
	 */
	protected function parseFiltrosEspeciales( XTemplate $xtpl ){
		$especiales = $this->getFiltrosEspeciales();
		if( !empty($especiales )){
			$xtpl->assign( 'filtrosEspeciales', $especiales );
			$xtpl->parse('main.botones_tabla.filtrosEspeciales');
			$this->hayFiltros = true;
		}

	}

	/**
	 * se obtienen los<filtros especiales
	 * (espec?ficos de cada listado).
	 * @param $xtpl
	 */
	protected function getFiltrosEspeciales(){
		return '';
	}

	/**
	 * se parsea un header para el listado.
	 * @param $xtpl
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function parseHeader( XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio ){
		$xtpl->assign( 'header', $this->getHeader($entidades, $criterio));
		$xtpl->parse('main.header');

	}

	/**
	 * obtiene el header.
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function getHeader( ItemCollection $entidades, CriterioBusqueda $criterio ){
		return '';
	}

	/**
	 * se parsea un footer para el listado.
	 * @param $xtpl
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function parseFooter( XTemplate $xtpl, ItemCollection $entidades, CriterioBusqueda $criterio){
		$xtpl->assign( 'footer', $this->getFooter($entidades, $criterio));
		$xtpl->parse('main.footer');
	}

	/**
	 * obtiene el footer.
	 * @param $entidades
	 * @param $campoFiltro
	 * @param $filtro
	 * @return unknown_type
	 */
	protected function getFooter( ItemCollection $entidades, CriterioBusqueda $criterio ){
		return '';
	}

	/**
	 * parsea las acciones por default de un listado:
	 *   - ver detalles.
	 *   - modificar.
	 *   - eliminar.
	 * @param XTemplate $xtpl template sobre el cual se parsea.
	 * @param unknown_type $entidad entidad sobre la cual se realizan las acciones.
	 * @param unknown_type $ds_entidad nombre de la entidad
	 * @param unknown_type $id identificar de la entidad.
	 * @return none.
	 */
	protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true){

		if( empty($lbl_entidad))
		$lbl_entidad = $nombre_entidad;

		if($ver){
			$href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
			$this->parseAccion( $xtpl, '', $href, 'search.gif' , 'detalles de ' . $lbl_entidad);
		}

		if($modificar){
			$href = 'doAction?action=modificar_'. $nombre_entidad .  '_init&id=' . $id;
			$this->parseAccion( $xtpl, '', $href, 'edit.gif' , 'editar datos de ' . $lbl_entidad);
		}

		if($eliminar){
			$onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_". $nombre_entidad . "&id=" . $id . "'); return false;" ;
			$this->parseAccion( $xtpl, $onclick, '', 'del.gif' , 'eliminar '  . $lbl_entidad);
		}
	}


	/**
	 * cartel eliminar para la entidad.
	 * @param unknown_type $entidad
	 * @return unknown_type
	 */
	protected function getCartelEliminar($entidad){
		return 'Confirma eliminar ' . $entidad;
	}

	protected function getTituloListado(){
		return $this->getTitulo();
	}

	protected function getOrdenDefault() {
        return 'DESC';
    }
}