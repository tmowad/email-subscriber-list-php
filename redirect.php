<?php
function redirect_with_message($action, $msg) {
?>
<form name="redirect_form" action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="message" value="<?php echo $msg; ?>"></input>
  <?php foreach ($_POST as $key => $val) { ?>
  <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>"></input>
  <?php } ?>
</form>
<script type="text/javascript">
  document.redirect_form.submit();
</script>
<?php
  }
?>