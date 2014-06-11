<?php
  $confirm_key = isset($_GET["confirm_key"]) ? $_GET["confirm_key"] : "";

  if (empty($confirm_key)) {
    $wont_work_reason = "No key";
  } else {

    require 'mysql_server_settings.php';
    $conn = mysqli_connect("localhost", $mysql_username, $mysql_password, $mysql_database_name);
    // TODO: more sql injection attack potential here...
    $query = "SELECT * FROM unconfirmed_subscribers WHERE confirm_key = '{$confirm_key}';";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
      $wont_work_reason = "Invalid key";
      $error_line = mysqli_error($conn) . ": (" . mysqli_errno($conn) . ")";
    } else if (mysqli_num_rows($result) == 0) {
      $wont_work_reason = "No matching key";
      $error_line = "We are not finding a match for confirmation key {$confirm_key}.";
    } else if (mysqli_num_rows($result) > 1) {
      // TODO: This would be a good place to insert a "re-issue key for this email" command, or something like that...
      $wont_work_reason = "Duplicate key";
      $error_line = "Sorry, we seeing this confirmation key attached to multiple email submissions.  Please ensure you have clicked the correct confirmation link in your email.";
    } else {
      // TODO: on matching, change the email_subscribers db status and DELETE the unconfirmed_subscriptions entry
      // This is the happy case, where we found one matching row.
      $matched_row = mysqli_fetch_assoc($result);
      $email_subscription_id = $matched_row["email_subscriber_id"];
      
      $update_result = mysqli_query($conn, "UPDATE email_subscribers SET status='CO' WHERE id={$email_subscription_id};");
      if (!$update_result) {
        $wont_work_reason = "Could not change subscriber status";
        $error_line = mysqli_error($conn) . ": (" . mysqli_errno($conn) . ")<br/>";
      }
    }
  }
  
  if (isset($wont_work_reason)) {
?>
<h3><?php echo $wont_work_reason; ?></h3>
<?php 
if (isset($error_line)) {
echo "<p>detail: " . $error_line . "</p>";
}
?>
<p>Sorry, we are not seeing a confirmation key.  Please ensure you have clicked the correct confirmation link in your email.</p>
<p>If you are having persistent errors, try and copy-paste the link in your email, rather than clicking it.</p> 
<?php 
  } else {
?>
<h3>Subscription Confirmed!</h3>
<p>Thank you for confirming your subscription with me.</p>
<p>You can look forward to lots of spammy emails now, mwahahaha!</p>
<?php 
  }
?>