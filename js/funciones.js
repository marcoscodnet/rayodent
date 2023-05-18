/* 
 *  SCRIPTS para ELECNOR.
 *  
 *	Las funciones dentro del script est�n ordenadas alfabéticamente:  
 *  
 *  function confirmaEliminar(cartel, a, href);
 *  function evaluar(onComplete);
 *  function esperar(elementId);
 *  function listartodos();
 *  function listar_todos();
 *  function mensajeErrorEliminar(mensaje);
 *  function popUp(a);
 *  function popUpGrande(a);
 *  function seleccionarContratista(cd_trabajadorObra, ds_nombre);
 *  function seleccionarCuadrilla(cd_trabajadorObra, ds_responsable, nu_numero);
 *  function seleccionarObra(cd_obra, ds_obra);
 *  function seleccionarProducto(cd_producto, ds_numero, ds_producto, ds_cantidad, cd_tipoProducto, nu_cantidad);
 *  function seleccionarProductoEnOpener(cd_producto, ds_numero, ds_producto, ds_cantidad, cd_tipoProducto, nu_cantidad);
 *  function seleccionarTipoProducto(cd_tipoProducto, ds_codigoSAP, ds_tipoProducto, ds_unidadMedida);
 *  function submit_self(accion);
 *  function submit_blank(accion);
 *  function verificarFiltro();
 *  
 */

/** ****************** A ************************* */

function actualizar_obrassociales_seleccionadas(id){
    url = 'doAction?action=actualizar_obrassociales_seleccionadas';
    jQuery.ajax({
        url:url,
        success: function(datos){
            document.getElementById(id).innerHTML = datos;
        }
    });
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function ajax_alta_liquidacionprofesional(url){
    jQuery.ajax({
        url:url,
        success: function(datos){
            ConfirmarLiquidacionProfesionales(datos);
        }
    });
}

function ConfirmarLiquidacionProfesionales(query_excel){
    
    
    var dialogOpts = {
        title : "RAYODENT - Liquidaci�n a Profesional",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 200,
        width : 500,        
        buttons:{
            Salir: function() {
                $( this ).dialog( "close" );
            },
            "Obtener listado": function() {
                nuevaurl='doAction?action=excel_liquidacion_profesionales'+query_excel;
                window.location.href = nuevaurl;
            }
        }
    };

    jQuery("#ui-liqconfirmation").children().remove();
    jQuery("#ui-liqconfirmation").dialog("destroy");
    jQuery("#ui-liqconfirmation").dialog(dialogOpts);
    jQuery("#ui-liqconfirmation").dialog("open");
    document.getElementById("ui-liqconfirmation").innerHTML = "<p style='text-align:center;'><b>Liquidaci�n realizada!</b></p>";
}

function agregarObraSocial(url){
    var dialogOpts = {
        title : "Listar Obras Sociales",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 700,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function abrir_busquedaOrdenpractica(url){
    var dialogOpts = {
        title : "Buscar Orden pr&aacute;ctica",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 700,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function abrir_busquedaPaciente(){
    var dialogOpts = {
        title : "Buscar Pacientes",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load('doAction?action=buscar_pacientes');
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}




function abrir_alta_paciente(url){
    var dialogOpts = {
        title : "Agregar Pacientes",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function abrir_alta_profesional(url){
    var dialogOpts = {
        title : "Agregar Profesionales",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load(url);
        }
    };
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}



function abrir_busquedaProfesional(){
    var dialogOpts = {
        title : "Buscar Profesional",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load('doAction?action=buscar_profesionales');
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function abrir_busquedaPersonal(){
    var dialogOpts = {
        title : "Buscar Personal",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load('doAction?action=buscar_personales');
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function abrir_busquedaObrasocial(){
    var dialogOpts = {
        title : "Buscar Obra Social",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            jQuery("#ui-dialog").load('doAction?action=buscar_obrassociales');
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}


function abrir_busquedaPractica(){
    var dialogOpts = {
        title : "Buscar Pr&aacute;ctica",
        modal : true,
        autoOpen : false,
        bgiframe : true,
        height : 500,
        width : 800,
        open : function() {
            cd_obrasocial = document.getElementById('cd_obrasocial').value;
            if((cd_obrasocial == "") || cd_obrasocial == null|| cd_obrasocial == undefined){
                alert ("Debe seleccionar una obra social primero.");
                jQuery("#ui-dialog").children().remove();
                jQuery("#ui-dialog").dialog("destroy");
            }
            else{
                jQuery("#ui-dialog").load('doAction?action=buscar_practicasobrassociales&id='+cd_obrasocial);
            }
        }
    };

    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    jQuery("#ui-dialog").dialog(dialogOpts);
    jQuery("#ui-dialog").dialog("open");
}

function ajax_validar_dni(){
    nu_doc = document.getElementById('nu_doc').value;
    cd_tipodoc = document.getElementById('cd_tipodoc').value;
    cd_paciente = document.getElementById('cd_paciente').value;
    if(nu_doc!="" && cd_tipodoc!=""){
        $.blockUI({
            message: "Validando dni...",
            fadeIn: 1000,
            timeout:   1000
        });
        url = 'doAction?action=ajax_validar_dni_paciente&nu_doc='+nu_doc+'&cd_tipodoc='+cd_tipodoc+'&cd_paciente='+cd_paciente;
        jQuery.ajax({
            url:url,
            success: function(datos){
                document.getElementById("msg-valid").innerHTML = datos;
                $.unblockUI();
                if(datos!=""){
                    /*document.getElementById("nu_doc").value = "";
                    document.getElementById("cd_tipodoc").value = "";*/
                    document.getElementById("nu_doc").focus();
                    $.fn.jVal.clean($('#editarpaciente'));
                    return false;
                }else{
                    $.fn.jVal.clean($('#editarpaciente'));
                    document.getElementById("ds_direccion").focus();
                    return true;
                }
            }
        });
    }
}

/** ****************** B ************************* */

function cargarCamposTipoConceptoBono(){
    jQuery.ajax({
        url:'doAction?action=cargar_campos_tipo_concepto_bono',
        success: function(datos){
            document.getElementById('campos_restantes').innerHTML = datos;
        }
    });
}

function cargarCamposTipoConceptoPractica(){
    document.getElementById('ds_profesional').setAttribute('jVal', "{valid:function (val) { return requerido(val,'Ingrese un valor'); }}");
    document.getElementById('ds_paciente').setAttribute('jVal', "{valid:function (val) { return requerido(val,'Ingrese un valor'); }}");
    //document.getElementById('ds_personal').setAttribute('jVal', "{valid:function (val) { return requerido(val,'Ingrese un valor'); }}");
    jQuery.ajax({
        url:'doAction?action=cargar_campos_tipo_concepto_practica',
        success: function(datos){
            document.getElementById('campos_restantes').innerHTML = datos;
        }
    });
}

function cargarCamposTipoConceptoReintegro(cd_concepto){
    document.getElementById('ds_profesional').setAttribute('jVal', "");
    document.getElementById('ds_paciente').setAttribute('jVal', "");
    document.getElementById('ds_personal').setAttribute('jVal', "");
    jQuery.ajax({
        url:'doAction?action=cargar_campos_tipo_concepto_reintegro&cd_concepto='+cd_concepto,
        success: function(datos){
            document.getElementById('campos_restantes').innerHTML = datos;
        }
    });
}


function cargarCamposTipoConceptoOtro(){
	//alert('entra');
    document.getElementById('ds_profesional').setAttribute('jVal', "");
    document.getElementById('ds_paciente').setAttribute('jVal', "");
    document.getElementById('ds_personal').setAttribute('jVal', "");
    jQuery.ajax({
        url:'doAction?action=cargar_campos_tipo_concepto_otro',
        success: function(datos){
            document.getElementById('campos_restantes').innerHTML = datos;
        }
    });
}


/** ****************** C ************************* */

/**
 * di�logo de confirmaci�n.
 * 
 * @param cartel -
 *            mensaje de confirmaci�n.
 * @param a -
 *            tag a html al cual se le setea el link en caso de confirmaci�n.
 * @param hred -
 *            link en caso de confirmaci�n.
 */

function cargarConcepto(campoId, divId, idTipoConceptoBono, idTipoConceptoPracica, idTipoConceptoReintegro){
    cd_tipoconcepto = document.getElementById(campoId).value;
    if(cd_tipoconcepto !=""){
        jQuery.ajax({
            url:'doAction?action=crear_combo_concepto&tcid='+cd_tipoconcepto,
            success: function(datos){
                if(divId != undefined && document.getElementById(divId)!=undefined){
                    document.getElementById(divId).innerHTML = datos;
                }
                if(cd_tipoconcepto == idTipoConceptoBono){
                    cargarCamposTipoConceptoBono();
                }
                if(cd_tipoconcepto == idTipoConceptoPracica){
                    cargarCamposTipoConceptoPractica();
                }
                /*if(cd_tipoconcepto == idTipoConceptoReintegro){
                    cargarCamposTipoConceptoReintegro();
                }*/
                
                if(cd_tipoconcepto != idTipoConceptoReintegro && cd_tipoconcepto != idTipoConceptoPracica && cd_tipoconcepto != idTipoConceptoBono){
                    cargarCamposTipoConceptoOtro();
                }
            }
        });
    }else{
        document.getElementById('ds_profesional').setAttribute('jVal', "");
        document.getElementById('ds_paciente').setAttribute('jVal', "");
        document.getElementById('ds_personal').setAttribute('jVal', "");
        document.getElementById('campos_restantes').innerHTML = "";
    }
   
    return false;
}

function confirmaEliminar(cartel, a, href) {

    jConfirm(cartel, 'Confirmaci\u00f3n', function(r) {
        if (r) {
            a.href = href;
            window.location = href;
            return true;
        } else {
            return false;
        }
    });
 
}

function confirmaEliminarAjax(url, divId){
    cartel="Confirma que desea eliminar la fila?";
    jConfirm(cartel, 'Confirmaci\u00f3n', function(r) {
        if (r) {
            invocarURLConAjax(url, divId);
            return false
        } else {
            return false;
        }
    });
    return false;
}

function  CargarOsParticular (id, cd_concepto_practica_particular, cd_os_practica_particular, ds_os_practica_particular){
	
    if(document.getElementById(id).value == cd_concepto_practica_particular && document.getElementById('cd_obrasocial')!= 'undefined' ){
        document.getElementById('cd_obrasocial').value = cd_os_practica_particular;
        document.getElementById('busqOS').style.display = 'none';
        document.getElementById('ds_obrasocial').value = ds_os_practica_particular;
    }else{
        if(document.getElementById('cd_obrasocial')!= null && document.getElementById('cd_obrasocial')!= 'undefined'){
            document.getElementById('cd_obrasocial').value = "";
        }
        if(document.getElementById('busqOS')!= null && document.getElementById('busqOS')!= 'undefined'){
            document.getElementById('busqOS').style.display = 'inline';
        }
        if(document.getElementById('busqOS')!= null && document.getElementById('busqOS')!= 'undefined'){
            document.getElementById('ds_obrasocial').value = "";
        }
    }
    
    if((document.getElementById(id).value == 116)||(document.getElementById(id).value == 115)||(document.getElementById(id).value == 1)||(document.getElementById(id).value == 65)){
        cargarCamposTipoConceptoReintegro(document.getElementById(id).value);
    }

    if(document.getElementById('cd_practicaobrasocial')!= null && document.getElementById('cd_practicaobrasocial')!= 'undefined'){
        document.getElementById('cd_practicaobrasocial').value = "";
    }
    if(document.getElementById('nu_practicaos')!= null && document.getElementById('nu_practicaos')!= 'undefined'){
        document.getElementById('nu_practicaos').value = "";
    }
    if(document.getElementById('nu_importe')!= null && document.getElementById('nu_importe')!= 'undefined'){
        document.getElementById('nu_importe').value = "";
    }
    if(document.getElementById('nu_placas')!= null && document.getElementById('nu_placas')!= 'undefined'){
        document.getElementById('nu_placas').value = "";
    }
    if(document.getElementById('ds_pieza')!= null && document.getElementById('ds_pieza')!= 'undefined'){
        document.getElementById('ds_pieza').value = "";
    }
    if(document.getElementById('ds_ordenpractica')!= null && document.getElementById('ds_ordenpractica')!= 'undefined'){
        document.getElementById('ds_ordenpractica').value = "";
    }
    if(document.getElementById('cd_ordenpractica')!= null && document.getElementById('cd_ordenpractica')!= 'undefined'){
        document.getElementById('cd_ordenpractica').value = "";
    }
    if(document.getElementById('nu_reciboreintegro')!= null && document.getElementById('nu_reciboreintegro')!= 'undefined'){
        document.getElementById('nu_reciboreintegro').value = "";
    }    
}

/** ****************** D ************************* */
function deshabilitarNuMotor() {
    document.getElementById('nu_motor').className = "";
    document.getElementById('nu_cuadro').style['border-color'] = "none";
    document.getElementById('nu_cuadro').style['background-color'] = "none";
    document.getElementById('nu_motor').disabled = true
    if (document.getElementById('nu_motorrequired_msg') != null) {
        document.getElementById('nu_motorrequired_msg').innerHTML = "";
    }
    exValidatorA.initialize('altaunidadmovimiento', exValidatorA.options);
}

function deshabilitarNuCuadro() {
    document.getElementById('nu_cuadro').className = "";
    document.getElementById('nu_cuadro').style['border-color'] = "none";
    document.getElementById('nu_cuadro').style['background-color'] = "none";
    document.getElementById('nu_cuadro').disabled = true
    if (document.getElementById('nu_cuadrorequired_msg') != null) {
        document.getElementById('nu_cuadrorequired_msg').innerHTML = "";
    }
    exValidatorA.initialize('altaunidadmovimiento', exValidatorA.options);
}

/** ****************** E ************************* */

/**
 * se eval�a la funci�n "onComplete" en el opener
 * 
 * @param onComplete
 *            funci�n a evaluar en el opener.
 * @return
 */
function evaluar(onComplete) {
    if (onComplete != null && onComplete != '')
        window.opener.eval(onComplete);
}

/**
 * se muestra la imagen de espera en el element html dado
 * 
 * @param elementId
 *            id del elemento html donde se mostrar� la imagen de espera.
 * @return
 */
function esperar(elementId) {
    document.getElementById(elementId).innerHTML = "<center><img src='../img/ajax-loader.gif' title='cargando...' alt='cargando...' /> </center>";
}

/** ****************** G ************************* */

/** ****************** H ************************* */
/** ****************** I ************************* */
function invocarURLConAjax(url, divId){
    jQuery.ajax({
        url:url,
        success: function(datos){
            if(divId != undefined && document.getElementById(divId)!=undefined){
                document.getElementById(divId).innerHTML = datos;
            }
        }
    });
    return false;
}

/** ****************** L ************************* */

/**
 * funci�n para listar todos los elementos en un listado.
 */
function listartodos() {
    formu = document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('filtro').value = "";
}

function listar_todos_ventas() {
    document.getElementById('cd_sucursal').selectedIndex = 0;
    document.getElementById('cd_usuario').selectedIndex = 0;
    document.getElementById('cd_cliente').selectedIndex = 0;
    document.getElementById('dt_desde').value = "";
    document.getElementById('dt_hasta').value = "";
}
/**
 * funci�n para listar todos los elementos en un listado.
 */
function listar_todos(action) {
    document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('filtro').value = "";
    if (action == 'listar_movimientos') {
        document.getElementById('cd_usuario').selectedIndex = 0;
    }
    if (action == 'listar_unidades') {
        document.getElementById('autorizada').checked = false;
        document.getElementById('sinautorizar').checked = false;
    }
    if (action == 'listar_ventas') {
        listar_todos_ventas();
    }
    submit_self(action);
}


function listar_todos_movcajas(action) {
    if (document.getElementById('nu_caja') != undefined) {
        if (document.getElementById('nu_caja').selectedIndex != undefined){
            document.getElementById('nu_caja').selectedIndex = 0;
        }else{
            document.getElementById('nu_caja').value = 0;
        }
    }
    if (document.getElementById('dt_inicio_filtro') != undefined) {
        document.getElementById('dt_inicio_filtro').value = "";
    }
    if (document.getElementById('dt_fin_filtro') != undefined) {
        document.getElementById('dt_fin_filtro').value = ""
    }
    if (document.getElementById('hs_inicio_filtro') != undefined) {
        document.getElementById('hs_inicio_filtro').value = "";
    }
    if (document.getElementById('hs_fin_filtro') != undefined) {
        document.getElementById('hs_fin_filtro').value = "";
    }
    if (document.getElementById('cd_paciente') != undefined) {
        document.getElementById('cd_paciente').value = "";
    }
    if (document.getElementById('ds_paciente') != undefined) {
        document.getElementById('ds_paciente').value = "";
    }
    if (document.getElementById('cd_concepto') != undefined) {
    	if (document.getElementById('cd_concepto').selectedIndex != undefined){
            document.getElementById('cd_concepto').selectedIndex = 0;
        }else{
            document.getElementById('cd_concepto').value = 0;
        }
    }
    submit_self(action, 'buscarMov');
}

function listar_todos_placas(action) {
    if (document.getElementById('nu_caja') != undefined) {
        if (document.getElementById('nu_caja').selectedIndex != undefined){
            document.getElementById('nu_caja').selectedIndex = 0;
        }else{
            document.getElementById('nu_caja').value = 0;
        }
    }
    if (document.getElementById('cd_practica') != undefined) {
        if (document.getElementById('cd_practica').selectedIndex != undefined){
            document.getElementById('cd_practica').selectedIndex = 0;
        }else{
            document.getElementById('cd_practica').value = 0;
        }
    }

    if (document.getElementById('dt_inicio_filtro') != undefined) {
        document.getElementById('dt_inicio_filtro').value = "";
    }
    if (document.getElementById('dt_fin_filtro') != undefined) {
        document.getElementById('dt_fin_filtro').value = ""
    }
    if (document.getElementById('hs_inicio_filtro') != undefined) {
        document.getElementById('hs_inicio_filtro').value = "";
    }
    if (document.getElementById('hs_fin_filtro') != undefined) {
        document.getElementById('hs_fin_filtro').value = "";
    }
    submit_self(action);
}

function listar_todos_resumen_placas(action) {
    
    if (document.getElementById('cd_obrasocial') != undefined) {
        if (document.getElementById('cd_obrasocial').selectedIndex != undefined){
            document.getElementById('cd_obrasocial').selectedIndex = 0;
        }else{
            document.getElementById('cd_obrasocial').value = 0;
        }
    }
    if (document.getElementById('ds_obrasocial') != undefined) {
        document.getElementById('ds_obrasocial').value = "";
    }
    if (document.getElementById('dt_inicio_filtro') != undefined) {
        document.getElementById('dt_inicio_filtro').value = "";
    }
    if (document.getElementById('dt_fin_filtro') != undefined) {
        document.getElementById('dt_fin_filtro').value = ""
    }
   
    submit_self(action);
}



function listar_todas_unidades(action, formName) {
    document.getElementById('validar').value = "false";
    document.getElementById('campoFiltro').selectedIndex = 0;
    document.getElementById('cd_producto').selectedIndex = 0;
    document.getElementById('filtro').value = "";
    if (document.getElementById('autorizada') != undefined) {
        document.getElementById('autorizada').checked = false;
    }
    if (document.getElementById('sinautorizar') != undefined) {
        document.getElementById('sinautorizar').checked = false;
    }
    submit_self(action, formName);
}

/** ****************** M ************************* */

/**
 * mensaje de error formateado con sexy alert.
 * 
 * @param mensaje -
 *            mensaje de error a mostrar
 */
function mensajeError(mensaje) {
    jAlert("<strong>Error</strong><br/><br/><br/>" + mensaje);
}

/**
 * mensaje de error formateado con sexy alert.
 * 
 * @param mensaje -
 *            mensaje de error a mostrar
 */
function mensajeErrorEliminar(mensaje) {
    jAlert("<strong>Eliminar</strong><br/><br/><br/>" + mensaje);
}


/** ****************** P ************************* */

/**
 * pop up est�ndar de 750x500
 * 
 * @param a -
 *            tag a html con el link para abrir el popup
 */
function popUp(a) {
    window.open(a.href, a.target,
        'width=750,height=500, ,location=center, scrollbars=YES');
    return false;
}

/**
 * pop up grande de 1024x500
 * 
 * @param a -
 *            tag a html con el link para abrir el popup
 */
function popUpGrande(a) {
    window.open(a.href, a.target,
        'width=1024,height=500, ,location=center, scrollbars=YES');
    return false;

}
/** ****************** S ************************* */


/**
 * setea el valor a un input
 * 
 * @param input
 *            input a setear el valor
 * @param value
 *            valor a setear
 * @param setFocus
 *            si pasamos 1, le da el foco al input.
 * @return
 */
function setearInput(input, value, setFocus) {
    if (input != null) {
        input.value = value;
        if (setFocus == 1) {
            input.focus();
        }
    }
}

function submit_self(accion, formName) {
    if (formName == 'undefined' || formName == null)
        formName = 'buscar';
    var form = document.forms[formName];
    if(form.accion != undefined){
        form.accion.value = accion;
    }
    form.target = '_self';
    form.submit();
}

function validate_and_submit_self(accion, formName) {
    if (formName == 'undefined' || formName == null)
        formName = 'buscar';
    var form = document.forms[formName];
    if(form.accion != undefined){
        form.accion.value = accion;
    }
    if(validate(formName)){
        form.target = '_self';
        form.submit();
    }
}

function submit_blank(accion, formName) {
    if (formName == 'undefined' || formName == null)
        formName = 'buscar';

    var form = document.forms[formName];
    input = document.getElementById('validar');
    if (input != null)
        input.value = "false";
    form.accion.value = accion;
    form.target = '_blank';
    form.submit();
}


function seleccion_obrasocial_a_agregar(cd_obrasocial){
    check_selected = document.getElementById("checkbox_"+cd_obrasocial).checked;
    if(check_selected){
        url = 'doAction?action=seleccionar_obrasocial_a_asociar&id='+cd_obrasocial+'&a=add';
    }else{
        url = 'doAction?action=seleccionar_obrasocial_a_asociar&id='+cd_obrasocial+'&a=del';
    }
    jQuery.ajax({
        url:url,
        success: function(datos){
        /*document.getElementById(id).innerHTML = datos;*/
        }
    });

}

function SeleccionarOrdenPractica(cd_ordenpractica,ds_nombre, ds_apynom){
    //Copio los datos;
    document.getElementById('cd_ordenpractica').value = cd_ordenpractica;
    document.getElementById('ds_ordenpractica').value = ds_apynom+" - Prof.:"+ds_nombre;
    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function SeleccionarObrasocial(cd_obrasocial,ds_obrasocial){
    
    //SI elije otra obrasocial, limpio el input de pr�cticaObrasocial
    if(document.getElementById('cd_obrasocial').value != cd_obrasocial){
        if (document.getElementById('cd_practicaobrasocial') != null && document.getElementById('cd_practicaobrasocial') != undefined) {
            document.getElementById('cd_practicaobrasocial').value = "";
        }
        if (document.getElementById('nu_practicaos') != null && document.getElementById('nu_practicaos') != undefined) {
            document.getElementById('nu_practicaos').value = "";
            
        }

    }

    //Copio los datos de la obra social
    document.getElementById('cd_obrasocial').value = cd_obrasocial;
    document.getElementById('ds_obrasocial').value = ds_obrasocial;
    if((typeof ajax_validar_repeticiones == 'function') && (ajax_validar_repeticiones!= undefined)){
        ajax_validar_repeticiones();
    }

    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function SeleccionarPractica(cd_practicaobrasocial,nu_practicaos, nu_importe){
    //Copio los datos;
    document.getElementById('cd_practicaobrasocial').value = cd_practicaobrasocial;
    document.getElementById('nu_practicaos').value = nu_practicaos;

    document.getElementById('nu_importe').value = nu_importe;
    if((typeof ajax_validar_repeticiones == 'function') && (ajax_validar_repeticiones!= undefined)){
        ajax_validar_repeticiones();
    }
    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function SeleccionarPaciente(cd_paciente,ds_apynom){
    //Copio los datos;
    document.getElementById('cd_paciente').value = cd_paciente;
    document.getElementById('ds_paciente').value = ds_apynom;
    if((typeof ajax_validar_repeticiones == 'function') && (ajax_validar_repeticiones!= undefined)){
        ajax_validar_repeticiones();
    }
    
    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
    if((typeof ajax_validar_repeticiones == 'function') && (ajax_validar_repeticiones!= undefined)){
    	var dialogOpts = {
    	        title : "Pr�cticas del Paciente",
    	        modal : true,
    	        autoOpen : false,
    	        bgiframe : true,
    	        height : 500,
    	        width : 800,
    	        open : function() {
    	            jQuery("#ui-dialog").load('doAction?action=listar_practicas_paciente&id='+cd_paciente);
    	        }
    	    };

    	    jQuery("#ui-dialog").children().remove();
    	    jQuery("#ui-dialog").dialog("destroy");
    	    jQuery("#ui-dialog").dialog(dialogOpts);
    	    jQuery("#ui-dialog").dialog("open");
    }
}


function SeleccionarProfesional(cd_profesional,ds_apynom){
    //Copio los datos;
    document.getElementById('cd_profesional').value = cd_profesional;
    document.getElementById('ds_profesional').value = ds_apynom;
    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function SeleccionarPersonal(cd_empleado,ds_apynom){
    //Copio los datos;
    document.getElementById('cd_empleado').value = cd_empleado;
    document.getElementById('ds_personal').value = ds_apynom;
    //Cierro el popUp
    jQuery("#ui-dialog").children().remove();
    jQuery("#ui-dialog").dialog("destroy");
}

function seleccionar_todas_obrassociales(id, a){
    obj = document.getElementById(id);
    if (obj.checked == true) {
        obj.checked = false;
        a.innerHTML = "Select all";
    }else{
        obj.checked = true;
        a.innerHTML = "Unselect all";
    }

    var cds_obrassociales = "";
    var checkBoxes = document.getElementsByTagName('input');
    for (i = 0; i < checkBoxes.length; i++) {
        if (obj.checked == true) {
            checkBoxes[i].checked = true; // this checks all the boxes
        } else {
            checkBoxes[i].checked = false; // this unchecks all the boxes
        }
        if(i>0  && checkBoxes[i].type=="checkbox"){
            nombre = checkBoxes[i].name.split("_");
            cd_contacto = nombre[1];
            if(i>1){
                cds_obrassociales +="_"
            }
            cds_obrassociales += cd_contacto;
        }
    }
    if(obj.checked){
        url = 'doAction?action=seleccionar_obrasocial_a_asociar&id='+cds_obrassociales+'&a=add';
    }else{
        url = 'doAction?action=seleccionar_obrasocial_a_asociar&id='+cds_obrassociales+'&a=del';
    }
    jQuery.ajax({
        url:url,
        success: function(datos){
        }
    });
}


/** ****************** V ************************* */

/**
 * se verifica si se ingres� un criterio de b�squeda en las ventas de
 * listados.
 */
function verificarFiltro() {
    if (document.getElementById('filtro').value == "") {
        if (document.getElementById('validar').value == "true") {
            jAlert("Se debe ingresar un criterio de b&uacute;queda");
            return false;
        }
    }
    return true;
}

function cargarApertura(){
    nu_caja = document.getElementById('nu_caja').value;
    dt_fecha_filtro = document.getElementById('dt_fecha_filtro').value;
    cd_movcaja = document.getElementById('cd_movcaja').value;
        jQuery.ajax({
            url:'doAction?action=crear_combo_apertura&nu_caja='+nu_caja+'&dt_fecha_filtro='+dt_fecha_filtro+'&cd_movcaja='+cd_movcaja,
            success: function(datos){

                    document.getElementById('campos_apertura').innerHTML = datos;


            }
        });


    return false;
}