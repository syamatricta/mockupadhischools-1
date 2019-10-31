<?php
class receiveMail
{
	var $server='';
	var $username='';
	var $password='';
	
	var $marubox='';					
	
	var $email='';			
	
	function receiveMail($username,$password,$EmailAddress,$mailserver='localhost',$servertype='pop',$port='110') //Constructure
	{
		if($servertype=='imap')
		{
			if($port=='') $port='143'; 
			$strConnect='{'.$mailserver.':'.$port. '}INBOX'; 
		}
		else
		{
			$strConnect='{'.$mailserver.':'.$port. '/pop3}INBOX'; 
		}
	
		$this->server			=	$strConnect;
		$this->username			=	$username;
		$this->password			=	$password;
		$this->email			=	$EmailAddress;
	}
	
	function get_num_recent(){
		$count = imap_num_msg($this->marubox);
		for($msgno = 1; $msgno <= $count; $msgno++) {
		
			$headers = imap_headerinfo($this->marubox, $msgno);
			if($headers->Unseen == 'U') {
			  //print 'OK';
			}
		}

		return imap_search($this->marubox, 'UNSEEN');
	}
	function get_imap_status(){
		/*1
		$status = imap_status($this->marubox, $this->server, SA_ALL);
		if ($status) {
		  echo "Messages:   " . $status->messages    . "<br />\n";
		  echo "Recent:     " . $status->recent      . "<br />\n";
		  echo "Unseen:     " . $status->unseen      . "<br />\n";
		  echo "UIDnext:    " . $status->uidnext     . "<br />\n";
		  echo "UIDvalidity:" . $status->uidvalidity . "<br /><br /><br />\n";
		} else {
		  echo "imap_status failed: " . imap_last_error() . "\n";
		}
		*/
	}
	function connect() //Connect To the Mail Box
	{
		$this->marubox=imap_open($this->server,$this->username,$this->password); // or die(imap_last_error());
		if($this->marubox){
			//print 'Connected';
		}else{
			//print_r(imap_errors());
		}
	}
	function getHeaders($mid) // Get Header info
	{
		$mail_header=imap_header($this->marubox,$mid);
		$sender=$mail_header->from[0];
		$sender_replyto=$mail_header->reply_to[0];
		if(strtolower($sender->mailbox)!='mailer-daemon' && strtolower($sender->mailbox)!='postmaster')
		{
			$mail_details=array(
					'from'=>strtolower($sender->mailbox).'@'.$sender->host,
					'fromName'=>@$sender->personal,
					'toOth'=>strtolower($sender_replyto->mailbox).'@'.$sender_replyto->host,
					'toNameOth'=>@$sender_replyto->personal,
					'subject'=>@$mail_header->subject,
					'to'=>strtolower($mail_header->toaddress)
				);
		}
		return $mail_details;
	}
	function get_mime_type(&$structure) //Get Mime type Internal Private Use
	{ 
		$primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
		
		if($structure->subtype) { 
			return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype; 
		} 
		return "TEXT/PLAIN"; 
	} 
	function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) //Get Part Of Message Internal Private Use
	{ 
		$prefix	= '';
		if(!$structure) { 
			$structure = imap_fetchstructure($stream, $msg_number); 
		} 
		if($structure) { 
			if($mime_type == $this->get_mime_type($structure))
			{ 
				if(!$part_number) 
				{ 
					$part_number = "1"; 
				} 
				$text = imap_fetchbody($stream, $msg_number, $part_number); 
				if($structure->encoding == 3) 
				{ 
					return imap_base64($text); 
				} 
				else if($structure->encoding == 4) 
				{ 
					return imap_qprint($text); 
				} 
				else
				{ 
					return $text; 
				} 
			} 
			if($structure->type == 1) /* multipart */ 
			{ 
				while(list($index, $sub_structure) = each($structure->parts))
				{ 
					if($part_number)
					{ 
						$prefix = $part_number . '.'; 
					} 
					$data = $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
					if($data)
					{ 
						return $data; 
					} 
				} 
			} 
		} 
		return false; 
	} 
	function getTotalMails() //Get Total Number off Unread Email In Mailbox
	{
		$headers=imap_headers($this->marubox);
		return count($headers);
	}
	function GetAttech($mid,$path) // Get Atteced File from Mail
	{
		$struckture = imap_fetchstructure($this->marubox,$mid);
		$ar="";
		foreach($struckture->parts as $key => $value)
		{
			
			$enc=$struckture->parts[$key]->encoding;
			if($struckture->parts[$key]->ifdparameters)
			{
				$name=$struckture->parts[$key]->dparameters[0]->value;
				$message = imap_fetchbody($this->marubox,$mid,$key+1);
				if ($enc == 0)
					$message = imap_8bit($message);
				if ($enc == 1)
					$message = imap_8bit ($message);
				if ($enc == 2)
					$message = imap_binary ($message);
				if ($enc == 3)
					$message = imap_base64 ($message); 
				if ($enc == 4)
					$message = quoted_printable_decode($message);
				if ($enc == 5)
					$message = $message;
				$fp=fopen($path.$name,"w");
				fwrite($fp,$message);
				fclose($fp);
				$ar=$ar.$name.",";
			}
		}
		$ar=substr($ar,0,(strlen($ar)-1));
		return $ar;
	}
	/**/
	function extract_attachments($message_number) {
   		$connection = $this->marubox;
		$attachments = array();
		$structure = imap_fetchstructure($connection, $message_number);
	    $path = './';
		if(isset($structure->parts) && count($structure->parts)) {
	   
			for($i = 0; $i < count($structure->parts); $i++) {
	   
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => ''
				);
			   
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
					$attachments[$i]['attachment'] = imap_fetchbody($connection, $message_number, $i+1);
					if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					}
					elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
					}
						/*$fp=fopen($path.$attachments[$i]['name'],"w");
						fwrite($fp,$attachments[$i]['attachment']);
						fclose($fp);*/
				}
			   
			}
		   
		}
	   
		return $attachments;
	   
	}

	/**/
	function getBody($mid) // Get Message Body
	{
		$body = $this->get_part($this->marubox, $mid, "TEXT/HTML");
		if ($body == "")
			$body = $this->get_part($this->marubox, $mid, "TEXT/PLAIN");
		if ($body == "") { 
			return "";
		}
		return $body;
	}
	function deleteMails($mid) // Delete That Mail
	{
		imap_delete($this->marubox,$mid);
	}
	function close_mailbox() //Close Mail Box
	{
		imap_close($this->marubox,CL_EXPUNGE);
	}
}
?>