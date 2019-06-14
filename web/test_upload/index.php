<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <input type="file" name="file" />
  <input type="submit" value="Upload" />
</form>
<script type="text/javascript">
  $(function()
  {
    $('form').submit(function()
    {
      $.ajax({
        url: 'start-timer.php',
        type: 'POST',
        context: this,
        success: function() { this.submit(); },
      });
      return false;
    });
  });
</script>
</body>
</html>