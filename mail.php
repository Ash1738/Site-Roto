<?php
class mail
{
	private $mail;
	 
	public function __construct()
	{
	   date_default_timezone_set('Europe/Lisbon');
	   
	   require('phpmailer/class.phpmailer.php'); 
	   require('phpmailer/class.smtp.php'); 
	   
	   $this->mail           = new PHPMailer();
	   $this->mail->CharSet  = 'UTF-8';
	   $this->mail->SMTPAuth = TRUE; 
	   $this->mail->IsHTML(TRUE);
	   $this->mail->IsSMTP();
	   $this->mail->Host     = 'mail.salesmap.pt';
	   $this->mail->Port     = 25;
	   $this->mail->Username = 'noreply@salesmap.pt';
	   $this->mail->Password = 'salesmap-__2017';
	}
	 
	 /*
	  * Envia um email para o utilizador 
	  *
	  * @param    Array       -> Notifica em BCC para outros emails
	  * @param    Array       -> Identifica para onde responder o email
	  * @param    String      -> Assunto do email
	  * @param    String      -> Html a enviar no email
	  * @param    Array       -> Lista de anexos a enviar no email
	  */
	public function send($sendTo = array(), $bccTo = array(), $replyTo = array(), $subject, $html, $attachments = array())
	{
	   $this->mail->SetFrom($this->mail->Username, 'Tweeeeeet');

	   if(empty($replyTo) == TRUE)
			$this->mail->addReplyTo($this->mail->Username, 'Tweeeeet online');
	   else
			$this->mail->addReplyTo($replyTo['email'], $replyTo['titulo']);

	   foreach($sendTo as $to)           
			$this->mail->addAddress($to);
	   
	   foreach($bccTo as $bcc)
			$this->mail->addBCC($bcc);

	   foreach($attachments as $attach)
			$this->mail->addStringAttachment(file_get_contents($attach['url']), $attach['filename']);

	   $this->mail->Subject        = $subject;
	   $this->mail->Body           = $html;
	   $this->mail->send();
	}
}
?>