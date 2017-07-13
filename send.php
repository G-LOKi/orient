<?php

// Replace this with your own email address
$siteOwnersEmail = 'garg.lokesh96@gmail.com';

// Pear Mail Library
//require_once "Mail.php";
require 'PHPMailer/PHPMailerAutoload.php';
//echo !extension_loaded('openssl')?"Not Available":"Available";



if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   //$subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage'] ));

	$error = '';
	
   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Please enter your message. It should have at least 15 characters.";
	}
   // Subject
	//if ($subject == '') { $subject = "Contact Form Submission"; }


   if ($error == '') {

      $mail = new PHPMailer();

		$mail->IsSMTP();
		//$mail->SMTPDebug = 3;
		$mail->SMTPAuth = true;

		$mail->CharSet="UTF-8";
		//$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Username = 'mailbox.orient@gmail.com';                 // SMTP username
		$mail->Password = 'welcome2017';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		//$mail->SMTPSecure = false;
	
		$mail->From = $email;
		$mail->FromName = $name;
		$mail->AddAddress($siteOwnersEmail);
		$mail->AddReplyTo($email, 'Information');

		$mail->IsHTML(true);
		$mail->Subject    = 'Planet Scoops Enquiry : '.$name;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->Body    = $contact_message;

		if(!$mail->Send())
		{
		  echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
		  echo "Message successfully send !";
		}
		

		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}


?>
