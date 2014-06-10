<html>
  <head>
    <title>Signup for Tom Mowad's mailing list</title>
  </head>
  <body>
    <p>You're obviously here since you've heard that Tom Mowad is all the rage these
    days, and you want to stay up to date with his latest thoughts and appearances
    around the world.</p>
    <?php 
      $new_subscriber_name = $new_subscriber_email = $message = "";
      
      if (isset($_POST["message"])) {
        $message = $_POST["message"];
      }
      if (isset($_POST["new_subscriber_name"])) {
        $new_subscriber_name = $_POST["new_subscriber_name"];
      }
      if (isset($_POST["new_subscriber_email"])) {
        $new_subscriber_email = $_POST["new_subscriber_email"];
      }
    ?>
    <div name="message" style="background-color: gray; color: pink;">
      <?php echo $message; ?>
    </div>
    <form name="new_subscriber" action="create_subscriber.php" method="POST">
      <table>
        <tr>
          <td><label>Name</label></td>
          <td><input type="text" name="new_subscriber_name" value="<?php echo $new_subscriber_name;?>"></input></td>
        </tr>
        <tr>
          <td><label>Email</label></td>
          <td><input type="text" name="new_subscriber_email" value="<?php echo $new_subscriber_email;?>"></input></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Signup"></input></td>
        </tr>
      </table>
    </form>
  </body>
</html>
