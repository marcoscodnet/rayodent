<?php



//$output = "mysqldump --user=root --password=root01 --add-drop-table mdc | gzip > db.sql.gz";
$name = "/home/rayodent/www/rayodent/backup/" . date("YmdHis") . "_rayodent.sql.gz";
$cmd = "mysqldump --user=pmauser --password=rayoroot0149 --add-drop-table rayodent | gzip > $name";
shell_exec($cmd);

		


 		include '../mailer/class.phpmailer.php';
        include_once '../mailer/class.smtp.php';

        //para que no de la salida del mailer.
       // ob_start();
	 	$diaAnterior = date("Ymd", strtotime("-1 day")); 
		$nombreFile = $diaAnterior . '_cdt_debug.log';
		
        
        $mail = new PHPMailer();


		$mail->SMTPOptions = array(

			'ssl' => array(

				'verify_peer' => false,

				'verify_peer_name' => false,

				'allow_self_signed' => true

			)

		);

	
		$mail->SMTPDebug=0;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "mail.marcospinero.com";
		$mail->Port = "465";
		$mail->Username = "admin@marcospinero.com";
		$mail->Password = "]TUQhTYCtf?*";

		        
        $mail->From = "admin@marcospinero.com";
		$mail->FromName = "Rayodent";
		$mail->Subject = "Backup Rayodent";
		$mail->AltBody = "Backup Rayodent\n.";
		$mail->MsgHTML("Backup Rayodent.");
		$mail->AddAttachment($name);
		if (file_exists("../logs/".$nombreFile)){
			$mail->AddAttachment("../logs/".$nombreFile);
		}
		
		$mail->AddAddress("crones.codnet@gmail.com", "Destinatario");
		$mail->IsHTML(true);
		
		if(!$mail->Send()) {
		  echo "Error: " . $mail->ErrorInfo;
		} else {
		  echo "Mensaje enviado correctamente";
		}

        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();
	unlink($name);	
        //para que no de la salida del mailer.
        //ob_end_clean();


?>
