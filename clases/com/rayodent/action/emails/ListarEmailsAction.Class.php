<?php


/**
 * Acci�n listar emails.
 * 
 * @author Marcos
 * @since 10-10-2018
 * 
 */
class ListarEmailsAction extends ListarAction {
	
	/**
	 * se listan entidades.
	 * @return boolean (true=exito).
	 */
	protected function getContenido(){
		
		
		
		
		
		
		
		$server = "{imap.mail.yahoo.com:993/imap/ssl}INBOX";
		$username = "rayodent";
		$password = "1q2w3e4r";
		
		// open connection
		$imapStream = imap_open($server, $username, $password);
		
		// check connection
		/*if (! $imapStream) {
		throw new Exception('Connection error: ' . imap_last_error());
		}*/
		
		$criteria = "SINCE ".date("Y-m-d")." FROM estudiopvarela.com.ar";
		//$criteria = "SINCE 2018-10-11 FROM marcos";
		/*var_dump(imap_search($imapStream, $criteria, SE_UID, 'utf-8')); // false
		var_dump(imap_search($imapStream, $criteria, SE_UID, 'UTF-8')); // array of message numbers or UIDs*/
		$emails = imap_search($imapStream, $criteria);
		
		if ($emails) {
		        rsort($emails);
		        foreach ($emails as $email_number) {
		            // echo "in email loop";
		            //print_r($email_number);
		            $header = imap_headerinfo($imapStream, $email_number);
			        $message = imap_fetchbody($imapStream,$email_number,1.2);
				
				
	
				
					if ($message == "") {
						$message = imap_fetchbody($imapStream, $email_number, 1.1);
						if ($message == "") {
							$message = imap_fetchbody($imapStream, $email_number, 1);
						}
					}
		            
					$criterio = new CriterioBusqueda();
	                $criterio->addFiltro('nu_email', $email_number, '=');
	
	                $manager = new EmailManager();
	                $oEmail = $manager->getEmail($criterio);
					
	                if (empty($oEmail)) {
		                if (isset($header->from)) {
							$from = $header->from;
						} else {
							$from = FALSE;
						}
						$fromname = "";
						$fromaddress = "";
					
						if ($from != FALSE) {
							foreach ($from as $id => $object) {
								if (isset($object->personal)) {
									$fromname = $object->personal;
								}
								$fromaddress = $object->mailbox . "@" . $object->host;
								if ($fromname == "") {
									// In case from object doesn't have Name
									$fromname = $fromaddress;
								}
							}
						}
						
						if (isset($header->to)) {
							$to = $header->to;
						} else {
							$to = FALSE;
						}
						$toname = "";
						$toaddress = "";
						
						if ($to != FALSE) {
							foreach ($to as $id => $object) {
								if (isset($object->personal)) {
									$toname = $object->personal;
								}
								$toaddress = $object->mailbox . "@" . $object->host;
								if ($toname == "") {
									// In case to object doesn't have Name
									$toname = $toaddress;
								}
							}
						}
	                	
	                $structure = imap_fetchstructure($imapStream,$email_number);


   
						

						$attachments = array();
						   if(isset($structure->parts) && count($structure->parts)) {
							 for($i = 0; $i < count($structure->parts); $i++) {
							   $attachments[$i] = array(
								  'is_attachment' => false,
								  'filename' => '',
								  'name' => '',
								  'attachment' => '');
			
							   if($structure->parts[$i]->ifdparameters) {
								 foreach($structure->parts[$i]->dparameters as $object) {
								 	
								   if(strtolower($object->attribute) == 'filename') {
									 $attachments[$i]['is_attachment'] = true;
									 $attachments[$i]['filename'] = $object->value;
								   }
								 }
							   }
			
							   if($structure->parts[$i]->ifparameters) {
								 foreach($structure->parts[$i]->parameters as $object) {
								   if(strtolower($object->attribute) == 'name') {
									 $attachments[$i]['is_attachment'] = true;
									 $attachments[$i]['name'] = $object->value;
								   }
								 }
							   }
			
							   if($attachments[$i]['is_attachment']) {
								 $attachments[$i]['attachment'] = imap_fetchbody($imapStream, $email_number, $i+1);
								 if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
								   $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
								 }
								 elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
								   $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
								 }
								 //$message =$attachments[$i]['attachment'];
							   }             
							 } // for($i = 0; $i < count($structure->parts); $i++)
						   } // if(isset($structure->parts) && count($structure->parts))
			
			
						if(count($attachments)!=0){
							foreach($attachments as $at){
								if($at['is_attachment']==1){
									$filename = $at['name'];
									if(empty($filename)) $filename = $at['filename'];
			
									if(empty($filename)) $filename = time() . ".dat";
									
									$dir = APP_PATH .'/'.RYT_PATH_ADJUNTOS.'/';
									if (!file_exists($dir)) mkdir($dir, 0777); 
									$dir .= $email_number.'/';
									if (!file_exists($dir)) mkdir($dir, 0777); 
									
									
									
									$fp = fopen($dir . "/" . $filename, "w+");
									if (!$fp) {
										$fp = fopen($dir . "/" . time() . ".dat", "w+");
										
									}
									fwrite($fp, $at['attachment']);
									fclose($fp);
								}
							}
						}
						
						
	                	$oEmail = new Email();
	                	$oEmail->setDs_asunto(addslashes($header->subject));
	                	$oEmail->setDs_cuerpo(quoted_printable_decode(addslashes($message)));
	                	$oEmail->setDs_destinatario($toaddress);
	                	$oEmail->setDs_remitente($fromaddress);
	                	$oEmail->setDt_fecha(date("Y-m-d H:i:s",$header->udate));
	                	$oEmail->setNu_email($email_number);
	                	//echo $oEmail->getDs_cuerpo()."<br><br>";
	                	$manager->agregarEmail($oEmail);
	                }
		            
		            //this might bug out but should delete the top message that was just parsed
		        }
		    }
		
		
		// close connection
		if ($imapStream && is_resource($imapStream)) {
			
			imap_close($imapStream, CL_EXPUNGE);
		}
		

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
	
	

    protected function getListarTableModel(ItemCollection $items) {
        return new EmailTableModel($items);
    }

    protected function getOpciones() {
        $opciones = array();
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        $filtros[] = $this->buildFiltro('cd_email', RYT_EMAIL_CD_EMAIL);

        $filtros[] = $this->buildFiltro('dt_fecha', RYT_EMAIL_DT_FECHA);
        
        $filtros[] = $this->buildFiltro('ds_asunto', RYT_EMAIL_DS_ASUNTO);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        
         $this->parseAccionesDefault($xtpl, $item, $item->getCd_email(), 'email', 'email', true, false, false);
        
    }

    protected function getEntidadManager() {
        return new EmailManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_email';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de E-mails';
    }

    protected function getUrlAccionListar() {
        return 'listar_emails';
    }

    protected function getForwardError() {
        return 'listar_emails_error';
    }

    protected function getMenuActivo() {
        return "Emails";
    }

    

}
