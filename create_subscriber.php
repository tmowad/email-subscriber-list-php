<?php
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
  
  $conn = mysqli_connect("localhost", "email_subs_user", "evilsaturn310", "email_subscriber_list_php"); 
  
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
?>

