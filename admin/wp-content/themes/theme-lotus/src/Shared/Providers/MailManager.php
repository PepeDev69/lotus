<?php

namespace Lotus\Shared\Providers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once(ABSPATH . WPINC . "/PHPMailer/PHPMailer.php");
require_once(ABSPATH . WPINC . "/PHPMailer/SMTP.php");

final class MailManager
{
	/**
	 * @var \PHPMailer\PHPMailer\PHPMailer
	 */
	private $mailer;

	public function __construct()
	{
		$this->mailer = new PHPMailer(true);
		$this->setup();
	}

	private function setup()
	{
		$this->mailer->IsSMTP();
		$this->mailer->Mailer = "smtp";

		$this->mailer->SMTPDebug  = 0;
		$this->mailer->SMTPAuth   = TRUE;
		$this->mailer->SMTPSecure = "tls";
		$this->mailer->Port       = 587;
		$this->mailer->Host       = "smtp.gmail.com";
		$this->mailer->Username   = "mailerphp50@gmail.com";
		$this->mailer->Password   = "crpntbehxnsztmzu";

		$this->mailer->IsHTML(true);
		$this->mailer->SetFrom("asegundo442@gmail.com", "Lotus Stetic");
		$this->mailer->AddAddress("asegundo442@gmail.com", "Alex Segundo");
		$this->mailer->Subject = "Se ha registrado su cita en nuestro sistema";
		$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
		$this->mailer->msgHTML($content);
	}

	public function send()
	{
		if (!$this->mailer->send()) {
			return "Error Send Email";
		}
		return "Succes Send Email";
	}
}
