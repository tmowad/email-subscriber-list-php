<?php
  // TODO: seeing how I copied these 2 lines of mysql code from create_subscriber.php, it may be a good thing to 
  //        put into a separate .php file
  require 'mysql_server_settings.php';
  $conn = mysqli_connect("localhost", $mysql_username, $mysql_password, $mysql_database_name);
  
  $result = mysqli_query($conn, "SELECT * FROM email_subscribers;");
  
  if ($result) {
    ?>
    
  <table border="1">
    <tr>
      <td>id</td>
      <td>name</td>
      <td>email</td>
      <td>status</td>
    </tr>
    <?php
    echo "There are {$result->num_rows} results.";
    while ($row = mysqli_fetch_array($result)) {
    ?>
      <tr>
      <td><?php echo $row["id"]; ?></td>
      <td><?php echo $row["name"]; ?></td>
      <td><?php echo $row["email"]; ?></td>
      <td><?php echo $row["status"]; ?></td>
      </tr>
    <?php 
    }
    ?>
  </table>
    
    <?php 
  } else {
    // TODO: error handling
    echo "There was an error.";
  }
?>