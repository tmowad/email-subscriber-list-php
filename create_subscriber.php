<?php
  require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
  require 'email_server_settings.php';
  require 'mysql_server_settings.php';
  
  /**
   * You need to create a 'email_server_settings.php' file which contains:
   *   $smtp_hostname = "smtp.googlemail.com";
   *   $smtp_username = "[email address]@gmail.com";
   *   $smtp_password = "[password]";
   *   $smtp_port = 465;
   *   $smtp_security_method = "ssl";
   *   --> I've left this general stuff so you can send email from a gmail address, but I don't want to put this info into
   *       source control.  
   *       
   * You also need a 'mysql_server_settings.php' file with:
   *   $mysql_username = [username];
   *   $mysql_password = [password];
   *   $mysql_database_name = [database name];
   */

  // TODO: enforce uniqueness constraint on email field
  // TODO: implement a Rails flash[]-like way of flashing a warning/notice into the
  //        next page, and ...
  // TODO: redirect this page to a list-all-users page on success, or the 
  //        new_subscriber.php page on fail
  // TODO: solve the SQL injection issue below...
  // TODO: add a database table CREATE TABLE unconfirmed_subscriptions (id INT, 
  //        subscriber_id INT, confirmation_key VARCHAR);
  // TODO: on success generate the confirmation_key
  // TODO: create the confirm.php page which will test the key and change the 
  //        email_subscribers db status and DELETE the unconfirmed_subscriptions 
  //        entry
  // TODO: on success send a confirmation email 
  $name = $_POST['new_subscriber_name'];
  $email = $_POST['new_subscriber_email'];
  
  $conn = mysqli_connect("localhost", $mysql_username, $mysql_password, $mysql_database_name); 
  
  if (!$conn) {
    die("Database connection fail");
  }
  
  // TODO: SQL injection potential here
  $result = mysqli_query($conn, "INSERT INTO email_subscribers (name, email, status) VALUES ('{$name}', '{$email}', 'UN');");
  if ($result) {
    echo "Email address '{$email}' successfully subscribed on behalf of '${name}'.";
  } else {
    die("DB query failure" . mysqli_error($conn) . "(" . mysqli_errno($conn) . ")");
  }
  
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->CharSet = 'UTF-8';

  $mail->Host       = $smtp_hostname; // SMTP server example
  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->Port       = $smtp_port;                    // set the SMTP port for the GMAIL server
  $mail->SMTPSecure = $smtp_security_method;
  $mail->Username   = $smtp_username; // SMTP account username example
  $mail->From       = $smtp_username;
  $mail->FromName   = "Tom Mowad fanpage";
  $mail->Password   = $smtp_password;        // SMTP account password example
  
  $mail->addAddress($email, $name);
  
  $mail->Subject = "Confirm subscription - Tom Mowad's mailing list";
  $mail->Body = "Dear {$name},<br/>\n<br/>\nPlease click <a href=\"http://www.google.com\">here</a>...";
  $mail->isHTML(true);
  
  if (!$mail->send()) {
    echo "Message could not be sent!";
    echo "Mailer error: " . $mail->ErrorInfo;
  } else {
    echo "Message has been sent.";
  }
?>

