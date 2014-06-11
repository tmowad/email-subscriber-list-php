<?php
  $confirm_key = isset($_GET["confirm_key"]) ? $_GET["confirm_key"] : "";
  if (empty($confirm_key)) {
?>
<h3>No key</h3>
<p>Sorry, we are not seeing a confirmation key.  Please ensure you have clicked the correct confirmation link in your email.</p>
<p>If you are having persistent errors, try and copy-paste the link in your email, rather than clicking it.</p> 
<?php 
  } else {

    require 'mysql_server_settings.php';
    $conn = mysqli_connect("localhost", $mysql_username, $mysql_password, $mysql_database_name);
    // TODO: more sql injection attack potential here...
    $result = mysqli_query($conn, "SELECT * FROM unconfirmed_subscriptions WHERE confirm_key = {$confirm_key};");
    
    if (!$result) {
?>
<h3>Invalid key</h3>
<p>Sorry, we are not seeing a confirmation key.  Please ensure you have clicked the correct confirmation link in your email.</p>
<p>If you are having persistent errors, try and copy-paste the link in your email, rather than clicking it.</p> 
<?php
// TODO: BTW those 2 <p> tags above were both copy-pasted from earlier...template this thing out???  
    } else if (mysqli_num_rows($result) > 1) {
// TODO: This would be a good place to insert a "re-issue key for this email" command, or something like that...
?>
<h3>Duplicate key</h3>
<p>Sorry, we seeing this confirmation key attached to multiple email submissions.  Please ensure you have clicked the correct confirmation link in your email.</p>
<p>If you are having persistent errors, try and copy-paste the link in your email, rather than clicking it.</p> 
<p>If you are still having issues, please contact our administrators for manual review.</p>
<?php
    } else {
// TODO: on matching, change the email_subscribers db status and DELETE the unconfirmed_subscriptions entry
      // This is the happy case, where we found one matching row.
      echo "<pre>";
      echo print_r(mysqli_fetch_assoc($result));
      echo "</pre>";
    }
  }
?>